<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Excel;
use stdClass;
use App\Models\Course;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $invoices = Invoice::list_data($request);

        $count = $invoices->count();
        $invoices = $invoices->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.invoice.index', compact('invoices', 'count'))->with('i', (request()->input('page', 1) - 1)  * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice = $invoice->select('invoices.*', 'students.name AS student_name', 'students.phone_1', 'courses.name AS course_name', 'courses.fee')
            ->leftjoin('students', 'students.id', '=', 'invoices.student_id')
            ->leftjoin('courses', 'courses.id', '=', 'invoices.course_id')
            ->where('invoices.id', $invoice->id)->first();
        return view('admin.invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        return view('admin.invoice.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $invoice = Invoice::find($id)->update([
            'payment_method' => $request->payment_method,
            'net_pay' => $request->net_amount,
            'discount_amount' => $request->course_fee - $request->net_amount,
            'u_by' => auth()->user()->name
        ]);
        return redirect()->route('invoice.index')->with('success', 'Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', 'Deleted Successfully');
    }

    public function export()
    {
        return Excel::download(new InvoiceExport, 'training_fee.xlsx');
    }

    public function detail($id)
    {
        // dd($id);
        $invoice = Invoice::find($id);
        $invoice = $invoice->select('invoices.*', 'students.name AS student_name', 'students.phone_1', 'courses.name AS course_name', 'courses.fee')
            ->leftjoin('students', 'students.id', '=', 'invoices.student_id')
            ->leftjoin('courses', 'courses.id', '=', 'invoices.course_id')
            ->where('invoices.id', $invoice->id)->first();

        return view('admin.invoice.detail', compact('invoice'));
    }

    public function summary(Request $request)
    {
        // 
        $courses =  Course::select('id', 'name')->get();

        $invoices = [];

        foreach ($courses as $course) {

            $incomes = getIncomeByCourse($course->id, $request);
            $fee = getFeeByCourse($course->id);
            // init
            $totalFee = 0;
            $totalNetPay = 0;
            $totalDiscount = 0;

            foreach ($incomes as $income) {
                $totalFee +=  $fee;
                $totalNetPay += $income->net_pay;
                $totalDiscount += $income->discount_amount;
            }

            $newObj = new stdClass();
            $newObj->name = $course->name;
            $newObj->total_fee = $totalFee;
            $newObj->total_netpay = $totalNetPay;
            $newObj->total_discount = $totalDiscount;

            array_push($invoices, $newObj);
        }

        return view('admin.invoice.summary', compact('invoices'));
    }
}