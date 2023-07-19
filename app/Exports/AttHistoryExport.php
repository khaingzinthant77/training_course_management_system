<?php

namespace App\Exports;

use App\Models\Attendance;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// for applying style sheet
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
Use \Maatwebsite\Excel\Sheet;

use DB;

class AttHistoryExport implements  FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function view(): View
    { 
        $course_id = (!empty($_POST['course_id']))?$_POST['course_id']:null;
        $section_id = (!empty($_POST['section_id']))?$_POST['section_id']:null;
        $att_status = (!empty($_POST['att_status']))?$_POST['att_status']:null;
        $from_date = (!empty($_POST['from_date']))?$_POST['from_date']:null;
        $to_date = (!empty($_POST['to_date']))?$_POST['to_date']:null;

        $data = new Attendance();
        $data = $data->select('attendances.id', 'attendances.date', 'students.name AS student_name', 'students.phone_1 AS phone', 'courses.name AS course_name', 'time_tables.section', 'time_tables.duration', 'attendances.attendance_status')
            ->leftjoin('student_has_courses', 'student_has_courses.id', '=', 'attendances.student_has_course_id')
            ->leftjoin('courses', 'courses.id', '=', 'student_has_courses.course_id')
            ->leftjoin('time_tables', 'time_tables.id', '=', 'student_has_courses.time_table_id')
            ->leftjoin('students', 'students.id', '=', 'student_has_courses.student_id');

        if (!empty($course_id)) {
            $data = $data->where('courses.id', $course_id);
        }

        if (!empty($section_id)) {
            $data = $data->where('time_tables.id', $section_id);
        }

        if ($att_status != null) {
            $data = $data->where('attendances.attendance_status', $att_status);
        }

        if ($from_date != '' and $to_date != '') {
            $from_date = date('Y-m-d', strtotime($from_date)) . ' 00:00';
            $to_date = date('Y-m-d', strtotime($to_date)) . ' 23:59';
            $data = $data->whereBetween('attendances.date', [$from_date, $to_date]);
        }

        $data = $data->orderBy('attendances.created_at', 'DESC')->get();
        return view('admin.attendance.history_export',compact('data'));
    }

}