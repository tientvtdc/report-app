<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Assessment extends Model
{
    use HasFactory;
    use LogsActivity;

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function criteria()
    {
        return $this->belongsToMany(Criterion::class, 'assessment_criteria', 'assessment_id', 'criterion_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "Assessment {$eventName}");
    }
}
