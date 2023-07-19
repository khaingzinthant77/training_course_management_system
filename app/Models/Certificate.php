<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificates';
    protected $fillable = ['student_id','course_id','major_ids','is_taken','taken_date','given_by','generate_by','remark','taken_remark','taken_by','is_delete'];
}
