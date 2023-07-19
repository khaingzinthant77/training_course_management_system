<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchHasStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id', 'student_id', 'is_finished'
    ];
}