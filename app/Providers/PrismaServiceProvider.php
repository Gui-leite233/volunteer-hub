<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PrismaServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
      $this->app->singleton('prisma', function () {
          $prismaClientPath = base_path('node_modules/.prisma/client');
          
          
          return new \stdClass(); // Placeholder
      });
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
      //
  }
}