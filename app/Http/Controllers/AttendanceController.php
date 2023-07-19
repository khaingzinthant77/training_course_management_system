<?php

namespace App\Http\Controllers;

use App\Exports\AttSummaryExport;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\StudentHasCourse;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceStoreRequest;
use App\Models\TimeTable;
use Illuminate\Support\Carbon;
use App\Models\Setting;
use App\Models\Student;
use Hashids\Hashids;
use Excel;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $attendances = Attendance::getRecent($request);
        $att_count = $attendances->count();
        $attendances = $attendances->orderBy('attendances.date', 'DESC')->paginate(10);

        $courses = Course::orderBy('name', "ASC")->get();
        $c_id = $request->c_id;
        $time_id = $request->timetable_id;

        $student_total = new StudentHasCourse();
        $student_total = $student_total->leftjoin('students','students.id','=','student_has_courses.student_id')->where('course_id',$c_id)->where('time_table_id',$time_id)->where('is_delete',0)->count();
        // $student_total = StudentHasCourse::where('course_id',$c_id)->where('time_table_id',$time_id)->where('is_delete',0)->count();

        return view('admin.attendance.index', compact('courses', 'attendances', 'c_id', 'time_id','student_total','att_count'));
        // return redirect('attendance?course_id=' . $request->c_id.'&timetable_id='.$request->time_id);
    }

    public function attendance_history(Request $request)
    {
        $attendances = Attendance::list_data($request);
        $courses = Course::orderBy('name', "ASC")->get();

        $attendances = $attendances->orderBy('attendances.created_at', 'DESC')->paginate(10);
        return view('admin.attendance.history', compact('attendances', 'courses'))->with('i', (request()->input('page', 1) - 1)  * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceStoreRequest $request)
    {
        $student_has_course = StudentHasCourse::where('student_id', $request->std_id)->where('course_id', $request->course_id)->first();

        // dd($student_has_course);
        if ($student_has_course != null) {
            $attendance = Attendance::create([
                'student_has_course_id' => $student_has_course->id,
                'date' => date('Y-m-d H:i', strtotime($request->att_date)) . ':00',
                'attendance_status' => $request->att_status,
                'c_by'=>$request->created_by
            ]);

            return redirect()->route('att_history')->with('success', 'Success');
        } else {
            return redirect()->back()->with('error', 'Student did not attend this course!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $attendance = Attendance::findorfail($id);
        $attendance = new Attendance();
        $attendance = $attendance->leftjoin('student_has_courses', 'student_has_courses.id', '=', 'attendances.student_has_course_id')->select('attendances.*', 'student_has_courses.student_id', 'student_has_courses.course_id')->find($id);
        return view('admin.attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceStoreRequest $request, Attendance $attendance)
    {
        $student_has_course = StudentHasCourse::where('student_id', $request->std_id)->where('course_id', $request->course_id)->first();

        $attendance->update([
            'student_has_course_id' => $student_has_course->id,
            'date' => date('Y-m-d h:i', strtotime($request->att_date)) . ':00',
            'attendance_status' => $request->att_status,
            'u_by'=>$request->updated_by
        ]);

        return redirect()->route('att_history')->with('success', 'Updated Successfully');
    }

    public function attendance_insert(Request $request)
    {

        // dd($request->all());
        $std_id = explode('/', $request->student_id);
        // dd($std_id[4]);

        if (is_null($request->course_id) || is_null($request->timetable_id)) {
            return redirect('attendance?course_id=' . $request->course_id . '&timetable_id=' . $request->timetable_id)->with('error', 'Please Select Course');
        }

        $hashids = new Hashids('', 10); // pad to length 10
        $id = $hashids->decodeHex($std_id[4]);

        $is_exist = StudentHasCourse::where('student_id', $id)->where('course_id', $request->course_id)->first();



        if (is_null($is_exist)) {
            return redirect('attendance?course_id=' . $request->course_id . '&timetable_id=' . $request->timetable_id)->with('error', 'Student has not purchase this code!');
        }

        $section_time =  TimeTable::find($is_exist->time_table_id)->duration;

        // Getting Attedance Status
        $attendance_status = $this->getAttendanceStatus($section_time);

        $attendance = Attendance::where('student_has_course_id',$is_exist->id)->count();

        if ($attendance == 0) {
           Attendance::create([
                'student_has_course_id' => $is_exist->id,
                'date' => date('Y-m-d H:i:s'),
                'attendance_status' => $attendance_status
            ]);

           $url = 'attendance?course_id=' . $request->course_id . '&timetable_id=' . $request->timetable_id;

            return redirect($url)->with('success', 'Attendance Success');
        }else{
            $url = 'attendance?course_id=' . $request->course_id . '&timetable_id=' . $request->timetable_id;

            return redirect($url)->with('error', 'Already Scan');
        }
       
        
    }

    public function getAttendanceStatus($sectionTime)
    {
        if (str_contains($sectionTime, 'AM')) {
            $sectionTime =  trim(explode("~", $sectionTime)[0]);
            $sectionTime =  Carbon::parse($sectionTime . ' AM');
        }

        if (str_contains($sectionTime, 'PM')) {
            $sectionTime =  trim(explode("~", $sectionTime)[0]);
            // dd($sectionTime);
            if ($sectionTime == '11:00') {
                $sectionTime = Carbon::parse('11:00' . ' AM');
            } else {
                $sectionTime = Carbon::parse($sectionTime . ' PM');
            }
        }

        // if('jgg') {
        //      $sectionTime = Carbon::parse('11:00' . ' PM');
        // }



        $now = Carbon::now();
        $setting = Setting::first();
        $lateInterval = $setting ? $setting->late_interval : 0;
        $now = $now->subMinutes($lateInterval);


        return $sectionTime->lt($now) ? 2 : 1;
    }

    public function att_summary(Request $request)
    {
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

        if ($request->keyword != '' or $request->course != '' or $request->time_table != '') {
            $students = Student::getAttendanceData($request, $month);
        } else {
            $students = [];
        }


        return view('admin.attendance.summary', compact('month', 'students'));
    }

    public function att_summary_export(Request $request)
    {
        return Excel::download(new AttSummaryExport, 'attendance_summary.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
        $attendance->delete();
        return redirect()->route('att_history')->with('success', 'Deleted Success');
    }
}