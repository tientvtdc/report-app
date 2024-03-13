<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssessmentEvidence extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'assessment_evidence';

    protected $fillable = [
        'assessment_criterion_standard_id',
        'evidence_id',
        'code',
        'added_by'
    ];

    public function assessmentCriterionStandard()
    {
        return $this->belongsTo(AssessmentCriterionStandard::class);
    }

    public function adder()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function evidence()
    {
        return $this->belongsTo(Evidence::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "Minh chứng #{$this->evidence->id} ({$this->evidence->title})
               {$eventName} trong
              {$this->assessmentCriterionStandard->assessmentCriterion->assessment->content}
              ({$this->assessmentCriterionStandard->assessmentCriterion->assessment->program->program_vi_title}
              {$this->assessmentCriterionStandard->assessmentCriterion->assessment->schoolyear})
              bởi {$this->adder->name}");
    }
}
