<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryHasCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id', 'course_id'
    ];
}