<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Process\Process;

class PrismaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('prisma', function () {
            // Check if Prisma client exists
            $prismaClientPath = base_path('node_modules/.prisma/client');
            
            if (!file_exists($prismaClientPath)) {
                // Generate Prisma client if it doesn't exist
                $this->generatePrismaClient();
            }
            
            // Use exec to run Node.js script that returns Prisma client instance
            $nodeBridge = base_path('resources/js/prisma-bridge.js');
            
            if (!file_exists($nodeBridge)) {
                $this->createPrismaBridge();
            }
            
            // Return a wrapper for the Prisma client
            return new \App\Services\PrismaClient();
        });
    }
    
    /**
     * Generate Prisma client using the CLI
     */
    protected function generatePrismaClient(): void
    {
        $process = new Process(['npx', 'prisma', 'generate']);
        $process->setTimeout(60);
        $process->run();
        
        if (!$process->isSuccessful()) {
            \Log::error('Failed to generate Prisma client: ' . $process->getErrorOutput());
            throw new \Exception('Failed to generate Prisma client');
        }
    }
    
    /**
     * Create a Node.js bridge script to instantiate the Prisma client
     */
    protected function createPrismaBridge(): void
    {
        $bridgeDir = base_path('resources/js');
        if (!is_dir($bridgeDir)) {
            mkdir($bridgeDir, 0755, true);
        }
        
        $bridgeContent = <<<'JS'
const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

process.on('message', async (message) => {
    try {
        const result = await prisma[message.model][message.method](...message.args);
        process.send({ success: true, data: result });
    } catch (error) {
        process.send({ success: false, error: error.message });
    }
});
JS;
        
        file_put_contents(base_path('resources/js/prisma-bridge.js'), $bridgeContent);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}