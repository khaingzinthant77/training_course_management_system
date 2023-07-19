<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'invoiceID', 'course_id', 'payment_method', 'net_pay', 'discount_amount', 'remark', 'c_by', 'u_by', 'time_table_id'
    ];


    // list data
    public static function list_data($request)
    {
        $data = new Invoice();
        $data = $data->select('invoices.*', 'students.name AS student_name', 'students.phone_1', 'students.phone_2', 'courses.name AS course_name', 'time_tables.section', 'time_tables.duration', 'courses.fee AS course_fee')
            ->leftjoin('students', 'students.id', '=', 'invoices.student_id')
            ->leftjoin('time_tables', 'time_tables.id', '=', 'invoices.time_table_id')
            ->leftjoin('courses', 'courses.id', '=', 'invoices.course_id');

        if (!empty($request->keyword)) {
            $data = $data->where('invoices.invoiceID', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('students.phone_1', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('students.phone_2', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('students.name', 'LIKE', '%' . $request->keyword . '%');
        }

        if (!empty($request->payment)) {
            $data = $data->where('invoices.payment_method', $request->payment);
        }

        if (!empty($request->course)) {
            $data = $data->where('courses.id', $request->course);
        }

        if (!empty($request->time_table)) {
            $data = $data->where('invoices.time_table_id', $request->time_table);
        }

        if ($request->from_date != '' and $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date)) . ' 00:00';
            $to_date = date('Y-m-d', strtotime($request->to_date)) . ' 23:59';
            // dd($from_date);
            $data = $data->whereBetween('invoices.created_at', [$from_date, $to_date]);
        }
        return $data;
    }
}