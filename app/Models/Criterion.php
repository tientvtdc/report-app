<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    public function assessments()
    {
        return $this->belongsToMany(Assessment::class, 'assessment_criteria', 'criterion_id', 'assessment_id');
    }

}
