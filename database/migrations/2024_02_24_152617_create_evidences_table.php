<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evidence', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('attachment')->nullable();
            $table->integer('issued_by')->nullable();
            $table->date('issued_at')->nullable();
            $table->integer('created_by');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evidence');
    }
};
