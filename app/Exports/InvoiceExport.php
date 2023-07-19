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

class InvoiceExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $from_date = (!empty($_POST['from_date'])) ? date('Y-m-d', strtotime($_POST['from_date'])) : null;
        $to_date = (!empty($_POST['to_date'])) ? date('Y-m-d', strtotime($_POST['to_date'])) : null;
        $payment = (!empty($_POST['payment'])) ? $_POST['payment'] : null;
        $keyword = (!empty($_POST['keyword'])) ? $_POST['keyword'] : null;
        $course = (!empty($_POST['course'])) ? $_POST['course'] : null;

        $title = 'All';
        $data = new Invoice();
        $data = $data->select('invoices.*', 'students.name AS student_name', 'students.phone_1', 'students.phone_2', 'courses.name AS course_name', 'courses.fee AS course_fee')
            ->leftjoin('students', 'students.id', '=', 'invoices.student_id')
            ->leftjoin('courses', 'courses.id', '=', 'invoices.course_id');

        if (!empty($keyword)) {
            $data = $data->where('invoices.invoiceID', 'LIKE', '%' . $keyword . '%')
                ->orWhere('students.phone_1', 'LIKE', '%' . $keyword . '%')
                ->orWhere('students.phone_2', 'LIKE', '%' . $keyword . '%')
                ->orWhere('students.name', 'LIKE', '%' . $keyword . '%');
        }

        if (!empty($course)) {
            $title = getCourse($course)->name;
            $data = $data->where('courses.id', $course);
        }

        if (!empty($payment)) {
            $data = $data->where('invoices.payment_method', $payment);
        }

        if ($from_date != '' and $to_date != '') {
            $from_date = date('Y-m-d', strtotime($from_date)) . ' 00:00';
            $to_date = date('Y-m-d', strtotime($to_date)) . ' 23:59';
            // dd($from_date);
            $data = $data->whereBetween('invoices.created_at', [$from_date, $to_date]);
        }
        $invoices = $data->orderBy('created_at', 'DESC')->get();
        return view('admin.invoice.export', compact('invoices', 'title'));
    }
}