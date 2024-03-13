<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentCriterionStandard extends Model
{
    protected $fillable = [
        'assessment_criterion_id',
        'standard_id',
        'content',
        'assessed_point',
    ];

    use HasFactory;

    public function assessmentCriterion()
    {
        return $this->belongsTo(AssessmentCriterion::class);
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class);
    }

    public function evidences()
    {
        return $this->hasMany(AssessmentEvidence::class)
            ->with(['evidence'])->orderBy('code', 'asc');
    }
}
