<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_has_course_id', 'date', 'attendance_status','c_by','u_by'
    ];


    // list data
    public static function list_data($request)
    {
        $data = new Attendance();
        $data = $data->select('attendances.id', 'attendances.date', 'students.name AS student_name', 'students.phone_1 AS phone', 'courses.name AS course_name', 'time_tables.section', 'time_tables.duration', 'attendances.attendance_status')
            ->leftjoin('student_has_courses', 'student_has_courses.id', '=', 'attendances.student_has_course_id')
            ->leftjoin('courses', 'courses.id', '=', 'student_has_courses.course_id')
            ->leftjoin('time_tables', 'time_tables.id', '=', 'student_has_courses.time_table_id')
            ->leftjoin('students', 'students.id', '=', 'student_has_courses.student_id');

        if (!empty($request->keyword)) {
            $data = $data->where('students.name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('students.phone_1', 'LIKE', '%' . $request->keyword . '%');
        }

        if (!empty($request->course_id)) {
            $data = $data->where('courses.id', $request->course_id);
        }

        if (!empty($request->section_id)) {
            $data = $data->where('time_tables.id', $request->section_id);
        }

        if ($request->att_status != null) {
            $data = $data->where('attendances.attendance_status', $request->att_status);
        }

        if ($request->from_date != '' and $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date)) . ' 00:00';
            $to_date = date('Y-m-d', strtotime($request->to_date)) . ' 23:59';
            $data = $data->whereBetween('attendances.date', [$from_date, $to_date]);
        }

        return $data;
    }

    // getRecent

    public static function getRecent($request)
    {
        // dd($request->all());
        $data = new Attendance();
        $data = $data->select('attendances.id', 'attendances.date', 'students.name AS student_name', 'students.phone_1 AS phone', 'courses.name AS course_name', 'time_tables.section', 'time_tables.duration', 'attendances.attendance_status')
            ->leftjoin('student_has_courses', 'student_has_courses.id', '=', 'attendances.student_has_course_id')
            ->leftjoin('courses', 'courses.id', '=', 'student_has_courses.course_id')
            ->leftjoin('time_tables', 'time_tables.id', '=', 'student_has_courses.time_table_id')
            ->leftjoin('students', 'students.id', '=', 'student_has_courses.student_id')->whereDate('date',date('Y-m-d'));
        if ($request->c_id != null) {
            $data = $data->where('student_has_courses.course_id',$request->c_id);
        }

        if ($request->timetable_id != null) {
            $data = $data->where('student_has_courses.time_table_id',$request->timetable_id);
        }
        return $data;
    }
}