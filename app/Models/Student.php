<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['name', 'qr_filename', 'dob', 'nrc', 'father_name', 'qualification', 'nationality', 'religion', 'phone_1', 'phone_2', 'address', 'status', 'photo', 'is_delete', 'studentID','c_by','u_by'];


    public static function getAttendanceData($request, $month)
    {
        $students =  Student::where('students.status', 1)->where('students.is_delete', 0)->select('name', 'id');
        $students = $students->select('students.name', 'students.id')
            ->leftjoin('student_has_courses', 'student_has_courses.student_id', 'students.id');

        if ($request->keyword != '') {
            $students = $students->where('students.name', 'LIKE', '%' . $request->keyword . '%');
        }


        if ($request->course != '') {
            $students = $students->where('student_has_courses.course_id', $request->course);
        }

        if ($request->time_table != '') {
            $students = $students->where('student_has_courses.time_table_id', $request->time_table);
        }

        $students = $students->get();

        $studentData = [];
        foreach ($students as $student) {
            $obj = new stdClass();
            $obj->student_id = $student->id;
            $obj->name = $student->name;
            $obj->attendances = [];

            array_push($studentData, $obj);
        }

        // dd($studentData);


        foreach ($studentData as $student_data) {
            foreach ($month as $day) {

                $date = $day['year'] . '-' . $day['month'] . '-' . $day['number_day'];



                $attendances = new Attendance();
                $attendances = $attendances->select('attendances.date', 'attendances.attendance_status')
                    ->leftjoin('student_has_courses', 'student_has_courses.id', 'attendances.student_has_course_id')
                    ->where('student_has_courses.student_id', $student_data->student_id)
                    ->whereDate('attendances.date', '=', $date);

                $attendances = $attendances->first();

                // is_null($attendances) ? array_push($student_data->attendances, '') : array_push($student_data->attendances,  $attendances);

                if (is_null($attendances)) {
                    array_push($student_data->attendances, '');
                } else {
                    array_push($student_data->attendances,  $attendances);
                }
            }
        }

        return $studentData;
    }


    public static function getAttendanceDataByStudent($request, $student_id, $month)
    {


        $students =  Student::where('id', $student_id)->get();

        // dd($students);

        $studentData = [];
        foreach ($students as $student) {
            $obj = new stdClass();
            $obj->student_id = $student->id;
            $obj->name = $student->name;
            $obj->attendances = [];

            array_push($studentData, $obj);
        }



        foreach ($studentData as $student_data) {
            foreach ($month as $day) {

                $date = $day['year'] . '-' . $day['month'] . '-' . $day['number_day'];



                $attendances = new Attendance();
                $attendances = $attendances->select('attendances.date', 'attendances.attendance_status')
                    ->leftjoin('student_has_courses', 'student_has_courses.id', 'attendances.student_has_course_id')
                    ->where('student_has_courses.student_id', $student_data->student_id)
                    ->whereDate('attendances.date', '=', $date);

                $attendances = $attendances->first();

                // is_null($attendances) ? array_push($student_data->attendances, '') : array_push($student_data->attendances,  $attendances);

                if (is_null($attendances)) {
                    array_push($student_data->attendances, '');
                } else {
                    array_push($student_data->attendances,  $attendances);
                }
            }
        }

        return $studentData;
    }

    public static function getAttendanceDataForExcel($post, $month)
    {
        $students =  Student::where('students.status', 1)->where('students.is_delete', 0)->select('name', 'id');
        $students = $students->select('students.name', 'students.id')
            ->leftjoin('student_has_courses', 'student_has_courses.student_id', 'students.id');

        if ($post->keyword != '') {
            $students = $students->where('students.name', 'LIKE', '%' . $post->keyword . '%');
        }


        if ($post->course != '') {
            $students = $students->where('student_has_courses.course_id', $post->course);
        }

        if ($post->time_table != '') {
            $students = $students->where('student_has_courses.time_table_id', $post->time_table);
        }

        $students = $students->get();

        $studentData = [];
        foreach ($students as $student) {
            $obj = new stdClass();
            $obj->student_id = $student->id;
            $obj->name = $student->name;
            $obj->attendances = [];

            array_push($studentData, $obj);
        }

        // dd($studentData);


        foreach ($studentData as $student_data) {
            foreach ($month as $day) {

                $date = $day['year'] . '-' . $day['month'] . '-' . $day['number_day'];



                $attendances = new Attendance();
                $attendances = $attendances->select('attendances.date', 'attendances.attendance_status')
                    ->leftjoin('student_has_courses', 'student_has_courses.id', 'attendances.student_has_course_id')
                    ->where('student_has_courses.student_id', $student_data->student_id)
                    ->whereDate('attendances.date', '=', $date);

                $attendances = $attendances->first();

                // is_null($attendances) ? array_push($student_data->attendances, '') : array_push($student_data->attendances,  $attendances);

                if (is_null($attendances)) {
                    array_push($student_data->attendances, '');
                } else {
                    array_push($student_data->attendances,  $attendances);
                }
            }
        }

        return $studentData;
    }
}