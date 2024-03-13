<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentCriterion extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'criterion_id',
        'content',
        'old_assessment_id'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criterion::class);
    }

    public function assessmentCriterionStandards()
    {
        return $this->hasMany(AssessmentCriterionStandard::class)
            ->with(['standard' => function($query) {
                $query->orderBy('code');
            }]);
    }

}
