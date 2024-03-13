<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Evidence extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'title',
        'attachment',
        'issued_by',
        'issued_at',
        'created_by',
        'valid_from',
        'valid_to'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "Minh chứng #{$this->id} ({$this->title}) {$eventName} bởi {$this->creator->name}");
    }
    public function assessmentEvidences()
    {
        return $this->belongsToMany(AssessmentEvidence::class);
    }

}
