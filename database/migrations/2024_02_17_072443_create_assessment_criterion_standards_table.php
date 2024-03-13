<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessment_criterion_standards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_criterion_id');
            $table->unsignedBigInteger('standard_id');
            $table->text('content');
            $table->integer('assessed_point');
            $table->timestamps();

            $table->foreign('assessment_criterion_id')
                ->references('id')
                ->on('assessment_criteria')
                ->onDelete('cascade');

            $table->foreign('standard_id')
                ->references('id')
                ->on('standards')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_criterion_standards');
    }
};
