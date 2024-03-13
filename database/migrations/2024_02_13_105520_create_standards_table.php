<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('standards', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->integer('criterion_id')->nullable();
            $table->integer('code');
            $table->text('content');
            $table->integer('point');
            $table->timestamps(); // Automatically added by Laravel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standards');
    }
};
