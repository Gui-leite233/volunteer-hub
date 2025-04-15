<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id()->unique()->primary();
            $table->string('name');
        });
    
        DB::table('status')->insert([
            ['name'=>'confimado'],
            ['name'=>'lista de espera']
        ]);

        Schema::create('events', function (Blueprint $table) {
            $table->id()->unique()->primary();
            $table->string('name');
            $table->text('description');
            $table->geography('location', subtype: 'point', srid: 4326);
            $table->dateTime('date');
            $table->integer('capacity');
            $table->string('category');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
