<?php

namespace App\Exports;

use App\Models\Student;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// for applying style sheet
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use App\Models\Invoice;

use DB;
use stdClass;

class AttSummaryExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $time_table = (!empty($_POST['time_table_id'])) ? $_POST['time_table_id'] : null;
        $keyword = (!empty($_POST['keyword'])) ? $_POST['keyword'] : null;
        $course = (!empty($_POST['course_id'])) ? $_POST['course_id'] : null;

        $post = new stdClass();
        $post->time_table = $time_table;
        $post->keyword = $keyword;
        $post->course = $course;


        // Set the timezone to your desired timezone
        date_default_timezone_set('Asia/Yangon');

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Get the number of days in the current month
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        // Loop through each day of the month and add it to the data array
        $month = array();
        for ($i = 1; $i <= $numberOfDays; $i++) {
            $dayOfWeek = date('D', strtotime("$currentYear-$currentMonth-$i"));
            $formattedDay = sprintf("%02d", $i);
            $month[] = array(
                'number_day' => $formattedDay,
                'string_day' => $dayOfWeek,
                'month' => $currentMonth,
                'year' => $currentYear,
            );
        }

        if ($keyword != '' or $course != '' or $time_table != '') {
            $students = Student::getAttendanceDataForExcel($post, $month);
        } else {
            $students = [];
        }




        return view('admin.attendance.export', compact('month', 'students'));
    }
}