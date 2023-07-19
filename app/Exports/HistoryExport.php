<?php

namespace App\Exports;

use App\Models\CertificateHistory;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// for applying style sheet
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
Use \Maatwebsite\Excel\Sheet;

use DB;

class HistoryExport implements  FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function view(): View
    { 
        $course_id = (!empty($_POST['course_id']))?$_POST['course_id']:null;

        $certificate_history = new CertificateHistory();
        $certificate_history = $certificate_history->leftjoin('certificates', 'certificates.id', '=', 'certificate_histories.certificate_id')->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificate_histories.id', 'students.name', 'students.phone_1', 'students.phone_2', 'courses.name AS course_name', 'certificate_histories.print_by','certificate_histories.created_at');

        if ($course_id != null) {
            $certificate_history = $certificate_history->where('certificates.course_id', $course_id);
        }

        $certificate_history = $certificate_history->orderBy('certificate_histories.created_at', 'desc')->get();
       
        return view('admin.certificate.history_export',compact('certificate_history'));
    }

}