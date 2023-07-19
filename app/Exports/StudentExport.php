<?php

namespace App\Exports;

use App\Models\Student;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// for applying style sheet
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
Use \Maatwebsite\Excel\Sheet;

use DB;

class StudentExport implements  FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function view(): View
    { 
        $from_date = (!empty($_POST['from_date']))?date('Y-m-d',strtotime($_POST['from_date'])):null;
        $to_date = (!empty($_POST['to_date']))?date('Y-m-d',strtotime($_POST['to_date'])):null;
        $course_id = (!empty($_POST['course_id']))?$_POST['course_id']:null;
        $section_id = (!empty($_POST['section_id']))?$_POST['section_id']:null;
        $attending_status = (!empty($_POST['attending_status']))?$_POST['attending_status']:null;
        $is_foc = (!empty($_POST['is_foc']))?$_POST['is_foc']:null;
        $batch_id = (!empty($_POST['batch_id']))?$_POST['batch_id']:null;

        $students = new Student();

        if ($from_date != null && $to_date != null) {
            $student_ids = getStudentIdByDate($from_date, $to_date);
            $students = $students->whereIn('id', $student_ids);
        }

        if ($is_foc != null) {
            // dd($is_foc);
            $student_ids = getFOCStudent($is_foc);
            $students = $students->whereIn('id', $student_ids);
        }

        $students = $students->where('students.is_delete', 0)->orderBy('students.created_at', 'desc')->get();
        
        return view('admin.student.export',compact('students','course_id','section_id','attending_status','batch_id'));
    }

}