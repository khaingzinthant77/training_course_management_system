<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\TimeTable;
use App\Models\Student;
use App\Models\Invoice;
use App\Models\Enquiry;
use App\Models\StudentHasCourse;
use stdClass;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Call Helper
        $course_count = Course::where('status', 1)->get()->count();
        $timetable_count = TimeTable::where('status', 1)->get()->count();
        $enquiry_count = Enquiry::where('enquiry_status','!=',"1")->get()->count();
        $student_count = Student::where('is_delete', 0)->get()->count();
        $invoices = new Invoice();
        $invoices = $invoices->whereYear('invoices.created_at', date('Y'))->get();
        $total_amount = 0;

        foreach ($invoices as $key => $value) {
            $total_amount += $value->net_pay;
        }

        $courses = Course::select("name",'id')->get();
  
        $result[] = ['Name','Count'];
        foreach ($courses as $key => $value) {
            $count = StudentHasCourse::where('course_id',$value->id)->get()->count();
            $result[++$key] = [$value->name,$count];
        }

        $students = StudentHasCourse::whereYear('join_date',date('Y'))->get();
        // dd($students);
        // $pieChart[] = ['Complete','Ongoing','Cancel'];
        // foreach ($students as $key => $value) {
        //     $complete_count = StudentHasCourse::whereYear('join_date',date('Y'))->where('is_finished',1)->get()->count();
        //     $pending_count = StudentHasCourse::whereYear('join_date',date('Y'))->where('is_finished',0)->get()->count();
        //     $cancel_count = StudentHasCourse::whereYear('join_date',date('Y'))->where('is_finished',2)->get()->count();
        //     $pieChart[++$key] = [$complete_count,$pending_count,$cancel_count];
        // }

        $pieChart = [
            ['name' => 'Complete', 'count' => StudentHasCourse::whereYear('join_date',date('Y'))->where('is_finished',1)->get()->count()],
            ['name' => 'Ongoing', 'count' => StudentHasCourse::whereYear('join_date',date('Y'))->where('is_finished',0)->get()->count()],
            ['name' => 'Cancel', 'count' => StudentHasCourse::whereYear('join_date',date('Y'))->where('is_finished',2)->get()->count()]
        ];

        // dd($pieChart);
        
        $users = User::count();
        return view('home', compact('users', 'course_count', 'timetable_count', 'enquiry_count', 'invoices', 'student_count', 'total_amount','result','pieChart'));
    }

    public function table()
    {
        return view('table');
    }

    public function button()
    {
        return view('button');
    }

    public function card()
    {
        return view('card');
    }

    public function color()
    {
        return view('utl_color');
    }

    public function animation()
    {
        return view('utl_animation');
    }

    public function border()
    {
        return view('utl_border');
    }

    public function other()
    {
        return view('utl_other');
    }
}