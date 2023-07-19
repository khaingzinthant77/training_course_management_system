<?php

namespace App\Exports;

use App\Models\Certificate;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// for applying style sheet
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
Use \Maatwebsite\Excel\Sheet;

use DB;

class CertificateExport implements  FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function view(): View
    { 
        $course_id = (!empty($_POST['course_id']))?$_POST['course_id']:null;
        
        $certificates = new Certificate();
        $certificates = $certificates->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificates.*', 'students.name', 'students.phone_1', 'students.phone_2', 'students.photo', 'courses.name AS course_name');

        if ($course_id != null) {
            $certificates = $certificates->where('certificates.course_id', $course_id);
        }

        $certificates = $certificates->where('certificates.is_delete',0)->orderBy('certificates.created_at', 'desc')->get();

        return view('admin.certificate.export',compact('certificates'));
    }

}