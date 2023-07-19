<?php

namespace App\Exports;

use App\Models\Enquiry;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// for applying style sheet
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
Use \Maatwebsite\Excel\Sheet;

use DB;

class EnquiryExport implements  FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function view(): View
    { 
        $from_date = (!empty($_POST['from_date']))?date('Y-m-d',strtotime($_POST['from_date'])):null;
        $to_date = (!empty($_POST['to_date']))?date('Y-m-d',strtotime($_POST['to_date'])):null;
        $qualification = (!empty($_POST['qualification']))?$_POST['qualification']:null;
        $course_id = (!empty($_POST['course_id']))?$_POST['course_id']:null;
        $time_table_id = (!empty($_POST['time_table_id']))?$_POST['time_table_id']:null;
        $condition = (!empty($_POST['condition']))?$_POST['condition']:null;

        $data = new Enquiry();
        $data = $data->select('enquiries.*', 'time_tables.section', 'time_tables.duration')
            ->leftjoin('time_tables', 'time_tables.id', 'enquiries.time_table_id')
            ->leftjoin('enquiry_has_courses', 'enquiry_has_courses.enquiry_id', 'enquiries.id')
            ->groupBy('enquiries.id');

        if (!empty($qualification)) {
            $data = $data->where('enquiries.qualification', $qualification);
        }

        if (!empty($course)) {
            $data = $data->where('enquiry_has_courses.course_id', $course);
        }

        if ($condition != '') {
            $data = $data->where('enquiries.enquiry_status', $condition);
        }

        if (!empty($time_table)) {

            if ($time_table == 'any') {
                $data = $data->where('enquiries.is_anytime', '1');
            } else {
                $data = $data->where('enquiries.time_table_id', $time_table);
            }
        }

        if ($from_date != '' and $to_date != '') {
            $from_date = date('Y-m-d', strtotime($from_date)) . ' 00:00';
            $to_date = date('Y-m-d', strtotime($to_date)) . ' 23:59';
            $data = $data->whereBetween('enquiries.created_at', [$from_date, $to_date]);
        }

        // $data = $data->where('enquiries.enquiry_status', '!=', '1');
        $data = $data->orderBy('enquiries.enquiry_status', 'ASC')->get();

        return view('admin.enquiries.enquiry_export',compact('data'));
    }

}