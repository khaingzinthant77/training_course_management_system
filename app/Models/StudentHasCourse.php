<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHasCourse extends Model
{
    use HasFactory;
    protected $table = 'student_has_courses';
    protected $fillable = ['student_id', 'course_id', 'status', 'time_table_id', 'join_date', 'studentID','is_finished','is_foc','batch_id','remark'];
}