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
        Schema::create('assessment_evidence', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_criterion_standard_id');
            $table->unsignedBigInteger('evidence_id');
            $table->string('code');
            // Foreign key constraints
            $table->foreign('assessment_criterion_standard_id')->references('id')->on('assessment_criterion_standards')->onDelete('cascade');
            $table->foreign('evidence_id')->references('id')->on('evidence')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_evidence', function (Blueprint $table) {
            $table->dropForeign(['assessment_criterion_standard_id']);
            $table->dropForeign(['evidence_id']);
        });
        Schema::dropIfExists('assessment_evidence');
    }
};
