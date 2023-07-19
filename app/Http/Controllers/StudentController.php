<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentHasCourse;
use App\Http\Requests\StudentStoreRequest;
use Illuminate\Http\Request;
use Excel;
use App\Exports\StudentExport;
use App\Exports\EnquiryExport;
use App\Exports\CertificateExport;
use App\Exports\HistoryExport;
use App\Exports\AttHistoryExport;
use QrCode;
use Carbon\Carbon;
use DB;
use App\Models\Invoice;
use App\Models\CourseHasMajor;
use App\Models\Certificate;
use App\Models\CertificateHistory;
use App\Models\Enquiry;
use App\Models\Major;
use App\Models\BatchHasStudent;
use Intervention\Image\Facades\Image;
use Imagick;
use URL;
use Hashids\Hashids;
use Illuminate\Support\Facades\File;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = new Student();

        if (!empty($request->keyword)) {
            $students = $students->where(function ($query) use ($request) {
                $query->where('students.name', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('students.studentID', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('students.phone_1', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('students.phone_2', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : null;

        if ($from_date != null && $to_date != null) {
            $student_ids = getStudentIdByDate($from_date, $to_date);
            $students = $students->whereIn('id', $student_ids);
        }

        if ($request->attending_status != null) {
            $student_ids = checkAttendingStatus($request->attending_status);
            $students = $students->whereIn('id',$student_ids);
        }

        if ($request->course_id != null) {
            $student_ids = checkCourseFilter($request->course_id);
            $students = $students->whereIn('id',$student_ids);
        }

        if ($request->section_id != null) {
            $student_ids = checkSectionFilter($request->section_id);
            $students = $students->whereIn('id',$student_ids);
        }

        if ($request->batch_id != null) {
            $student_ids = checkBatchFilter($request->batch_id);
            $students = $students->whereIn('id',$student_ids);
        }

        


        if ($request->is_foc != null) {
            // dd($request->is_foc);
            $student_ids = getFOCStudent($request->is_foc);
            $students = $students->whereIn('id', $student_ids);
        }

        $count = $students->where('students.is_delete', 0)->get()->count();

        $students = $students->where('students.is_delete', 0)->orderBy('students.created_at', 'desc')->paginate(10);
        return view('admin.student.index', compact('students', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreRequest $request)
    {
        $nrc_code_id = DB::table('nrccode')->where('id', $request->nrc_code)->first();

        if ($nrc_code_id != null) {
           $nrc = $nrc_code_id->name . '/' . $request->nrc_state . '(' . $request->nrc_status . ')' . $request->nrc;
        }else{
            $nrc = null;
        }
        

        $destinationPath = public_path() . '/uploads/student_photo/';
        //upload photo
        $photo = "";
        if ($file = $request->file('photo')) {
            $photo = $request->file('photo');
            $ext = '.' . $request->photo->getClientOriginalExtension();
            $fileName = str_replace($ext, date('d-m-Y-H-i') . $ext, $request->photo->getClientOriginalName());
            $file->move($destinationPath, $fileName);
            $photo = $fileName;
        }

        $currentYear = date('Y'); // get the current year
        $studentCount = Student::where('is_delete', 0)
            ->whereYear('created_at', $currentYear)
            ->count(); // count the number of students created this year

        // $studentId = 'IT' . str_pad($studentCount + 1, 4, '0', STR_PAD_LEFT) . date('my'); 
        // $studentID = "IT" . $std_id . date('dm', strtotime($request->join_date)) . date('y', strtotime($request->join_date));

        $students = Student::create([
            'name' => $request->name,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'nrc' => $nrc,
            'studentID' => $request->studentID,
            'father_name' => $request->father_name,
            'qualification' => $request->qualification,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'phone_1' => $request->phone_1,
            'phone_2' => $request->phone_2,
            'address' => $request->address,
            'photo' => $photo,
            'c_by' => $request->created_by
        ]);

        $hashids = new Hashids('', 10); // pad to length 10
        $hashids = $hashids->encodeHex($students->id);

        // dd(URL::to('/student_detail/'.$hashids));
        $url = URL::to('/student_detail/' . $hashids);
        $qr_filename =  'qr_' . Carbon::now()->timestamp . '.png';
        QrCode::format('png')->backgroundColor(255, 255, 255)->color(0, 0, 0)->size(200)->generate($url, public_path('uploads/qr_code/' . $qr_filename));

        $students->update([
            'qr_filename' => $qr_filename,
        ]);

        if ($request->is_enquiry != null) {
            return redirect()->route('enquiry')->with('success', 'Success');
        } else {
            return redirect()->route('students.index')->with('success', 'Success');
        }
    }

    public function cancelCourse(Request $request, $id)
    {
        $data = StudentHasCourse::where('student_id', $id)->where('course_id', $request->course_id)->first();
        $data->update([
            'is_finished' => 2,
            'remark'=>$request->remark
        ]);

        return redirect()->route('students.index')->with('success', 'Success');
    }

    public function add_to_student(StudentStoreRequest $request)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request) {

                $nrc_code_id = DB::table('nrccode')->where('id', $request->nrc_code)->first();
                if ($nrc_code_id != null) {
                    $nrc = $nrc_code_id->name . '/' . $request->nrc_state . '(' . $request->nrc_status . ')' . $request->nrc;
                }else{
                    $nrc = null;
                }
                

                $destinationPath = public_path() . '/uploads/student_photo/';
                //upload photo
                $photo = "";
                if ($file = $request->file('file')) {
                    $photo = $request->file('file');
                    $ext = '.' . $request->file->getClientOriginalExtension();
                    $fileName = str_replace($ext, date('d-m-Y-H-i') . $ext, $request->file->getClientOriginalName());
                    $file->move($destinationPath, $fileName);
                    $photo = $fileName;
                }

                $currentYear = date('Y'); // get the current year
                $studentCount = Student::where('is_delete', 0)
                    ->whereYear('created_at', $currentYear)
                    ->count(); // count the number of students created this year

                // $studentId = 'IT' . str_pad($studentCount + 1, 4, '0', STR_PAD_LEFT) . date('my');




                $student = Student::create([
                    'name' => $request->name,
                    'dob' => date('Y-m-d', strtotime($request->dob)),
                    'nrc' => $nrc,
                    'studentID' => $request->student_id,
                    'father_name' => $request->father_name,
                    'qualification' => $request->qualification,
                    'nationality' => $request->nationality,
                    'religion' => $request->religion,
                    'phone_1' => $request->phone_1,
                    'phone_2' => $request->phone_2,
                    'address' => $request->address,
                    'photo' => $photo
                ]);

                $qr_filename =  'qr_' . Carbon::now()->timestamp . '.png';

                $hashids = new Hashids('', 10); // pad to length 10
                $hashids = $hashids->encodeHex($student->id);

                QrCode::format('png')->backgroundColor(255, 255, 255)->color(0, 0, 0)->size(200)->generate(URL::to('/student_detail/' . $hashids), public_path('uploads/qr_code/' . $qr_filename));

                $student->update([
                    'qr_filename' => $qr_filename,
                ]);
                $enquiry = Enquiry::find($request->enquiry_id);
                $enquiry->update([
                    'enquiry_status' => '1'
                ]);



                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
        }

        return redirect()->route('enquiries.index')->with('success', 'Added To Student Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $student = Student::findorfail($id);

        $student_has_courses = new StudentHasCourse();
        $student_has_courses = $student_has_courses->leftjoin('students', 'students.id', '=', 'student_has_courses.student_id')
            ->leftjoin('courses', 'courses.id', '=', 'student_has_courses.course_id')
            ->leftjoin('time_tables', 'time_tables.id', '=', 'student_has_courses.time_table_id')
            ->select('students.id AS student_id', 'students.name', 'courses.name AS course_name', 'student_has_courses.status', 'students.qr_filename', 'time_tables.section', 'time_tables.duration', 'student_has_courses.join_date', 'students.phone_1', 'students.phone_2', 'student_has_courses.id', 'students.qr_filename','student_has_courses.is_finished','student_has_courses.remark')->where('student_has_courses.student_id', $id)->get();

        foreach ($student_has_courses as $key => $value) {
            $value->invoiceID = Invoice::where('student_id', $value->student_id)->first()->invoiceID;
        }

        // Set the timezone to your desired timezone
        date_default_timezone_set('Asia/Yangon');

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');


        if ($request->date != '') {

            $currentMonth = explode('-', $request->date)[0];
            $currentYear = explode('-', $request->date)[1];

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

            $students = Student::getAttendanceDataByStudent($request, $id, $month);
        } else {
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

            $students = Student::getAttendanceDataByStudent($request, $id, $month);
        }

        return view('admin.student.show', compact('student', 'student_has_courses', 'month', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findorfail($id);
        $nrc_code = explode('/', $student->nrc);
        $code_id = $nrc_code[0];
        $code = DB::table('nrccode')->where('name', $code_id)->first();

        if ($code != null) {
            $code_id = $code->id;
        }else{
            $code_id = null;
        }

        return view('admin.student.edit', compact('student', 'code_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentStoreRequest $request, $id)
    {
        $student = Student::findorfail($id);

        $nrc_code_id = DB::table('nrccode')->where('id', $request->nrc_code)->first();
        if ($nrc_code_id != null) {
            $nrc = $nrc_code_id->name . '/' . $request->nrc_state . '(' . $request->nrc_status . ')' . $request->nrc;
        }else{
            $nrc = null;
        }

        $path = public_path() . '/uploads/student_photo/';
        $photos = ($request->photo != '') ? $request->photo : $student->photo;

        if ($file = $request->file('photo')) {
            $photos = $request->file('photo');
            $ext = '.' . $request->photo->getClientOriginalExtension();
            $fileName = str_replace($ext, date('d-m-Y-H-i') . $ext, $photos->getClientOriginalName());
            $file->move($path, $fileName);
            $photos = $fileName;
        }

        $student = $student->update([
            'name' => $request->name,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'nrc' => $nrc,
            'father_name' => $request->father_name,
            'qualification' => $request->qualification,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'phone_1' => $request->phone_1,
            'phone_2' => $request->phone_2,
            'address' => $request->address,
            'photo' => $photos,
            'u_by' => $request->updated_by,
            'studentID'=>$request->studentID
        ]);

        if ($request->is_enquiry != null) {
            return redirect()->route('enquiry')->with('success', 'Success');
        } else {
            return redirect()->route('students.index')->with('success', 'Success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findorfail($id)->update([
            'is_delete' => 1
        ]);

        return redirect()->route('students.index')->with('success', 'Success');
    }

    public function student_change_status(Request $request)
    {
        $student = Student::findorfail($request->id)->update([
            'status' => $request->status
        ]);

        return response()->json('success');
    }

    public function course_add(Request $request)
    {

        $qr_filename =  'qr_' . Carbon::now()->timestamp . '.png';
        QrCode::format('png')->backgroundColor(255, 255, 255)->color(0, 0, 0)->size(200)->generate($request->student_id, public_path('uploads/qr_code/' . $qr_filename));

        $student_count = Student::where('is_enquiry', 0)->where('is_delete', 0)->get()->count();

        $std_id = str_pad(($student_count + 1), 3, '0', STR_PAD_LEFT);

        $studentID = "IT" . $std_id . date('m', strtotime($request->join_date)) . date('y', strtotime($request->join_date));
        // dd($studentID);
        DB::beginTransaction();
        try {
            $student_course = StudentHasCourse::create([
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'time_table_id' => $request->time_table_id,
                'qr_filename' => $qr_filename,
                'join_date' => date('Y-m-d', strtotime($request->join_date)),

            ]);

            $last = Invoice::orderByDesc('id')->first();
            $invoiceID = 'INV-' . date('Ymd') . str_pad($last->id + 1, 4, '0', STR_PAD_LEFT);

            Invoice::create([
                'invoiceID' => $invoiceID,
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'payment_method' => $request->payment_method,
                'net_pay' => $request->net_amount,
                'discount_amount' => $request->course_fee - $request->net_amount,
            ]);

            $student = Student::findorfail($request->student_id)->update([
                'is_enquiry' => 0,
                'studentID' => $request->studentID
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }


        return redirect()->route('enquiry')->with('success', 'Success');
    }

    public function add_course(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $student_course = StudentHasCourse::create([
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'time_table_id' => $request->time_table_id,
                'join_date' => date('Y-m-d', strtotime($request->join_date)),
                'is_foc' => $request->net_amount == 0 ? 1 : 0,
                'batch_id' => $request->batch_id
            ]);

            $last = Invoice::get()->count();

            $invoiceID = 'INV-' . date('Ymd') . str_pad($last + 1, 4, '0', STR_PAD_LEFT);

            Invoice::create([
                'invoiceID' => $invoiceID,
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'payment_method' => $request->payment_method,
                'net_pay' => $request->net_amount,
                'time_table_id' => $request->time_table_id,
                'discount_amount' => $request->course_fee - $request->net_amount,
                'remark' => $request->remark,
                'c_by' => auth()->user()->name
            ]);
            // $student_count = Student::where('is_delete', 0)->get()->count();

            // $std_id = str_pad(($student_count + 1), 3, '0', STR_PAD_LEFT);

            // $studentID = "IT" . $std_id . date('m', strtotime($request->join_date)) . date('y', strtotime($request->join_date));

            // $student = Student::findorfail($request->student_id)->update([
            //     'studentID' => $request->studentID
            // ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }


        return redirect()->route('students.index')->with('success', 'Succesfully Added');
    }

    public function student_card_generate(Request $request)
    {
        $student_has_courses = new StudentHasCourse();
        $student_has_courses = $student_has_courses->leftjoin('students', 'students.id', '=', 'student_has_courses.student_id')->leftjoin('courses', 'courses.id', '=', 'student_has_courses.course_id')->leftjoin('time_tables', 'time_tables.id', '=', 'student_has_courses.time_table_id')->select('students.id AS student_id', 'students.name', 'courses.name AS course_name', 'student_has_courses.status', 'students.qr_filename', 'time_tables.section', 'time_tables.duration', 'student_has_courses.join_date', 'students.phone_1', 'student_has_courses.id')->where('students.is_delete', 0);

        $count = $student_has_courses->get()->count();

        $student_has_courses = $student_has_courses->orderBy('students.created_at', 'desc')->paginate(10);
        return view('admin.student.card_generate', compact('student_has_courses', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function card_generate($id)
    {
        // dd(URL::to('/student_detail/'.$id));

        // dd($id);
        $student = Student::find($id);
        // dd($student->nrc);
        $img = Image::make(public_path('uploads/card_design.png'));

        if ($student->photo != null) {
            $std_photo = public_path('uploads/student_photo/' . $student->photo);
        } else {
            $std_photo = public_path('uploads/no_photo.jpeg');
        }
        $image = new Imagick($std_photo);

        $img->resize(857, 540, function ($constraint) {
            $constraint->aspectRatio();
        });

        // 153

        $std_img = Image::make($std_photo);
        $std_img->resize(180, 205);


        $img->insert($std_img, 'top-left', 60, 165);

        $qr = Image::make(public_path('uploads/qr_code/' . $student->qr_filename));
        $qr->resize(130, 130);
        $img->insert($qr, 'top-left', 710, 375);

        $img->text($student->name, 270, 190, function ($font) {
            $font->file(public_path('fonts/Linn-Caracas-Medium.otf'));
            $font->size(36);
        });

        $img->text('ID CODE', 320, 240, function ($font) {
            $font->file(public_path('fonts/Linn-Caracas-Light.otf'));
            $font->size(28);
            $font->align('center');
            $font->valign('bottom');
            $font->angle(0);
        });

        $img->text(': ' . $student->studentID, 370, 240, function ($font) {
            $font->file(public_path('fonts/Linn-Caracas-Light.otf'));
            $font->size(28);
            $font->align('left');
            $font->valign('bottom');
            $font->angle(0);
        });

        $img->text('NRC No', 320, 290, function ($font) {
            $font->file(public_path('fonts/Linn-Caracas-Light.otf'));
            $font->size(28);
            $font->align('center');
            $font->valign('bottom');
            $font->angle(0);
        });

        $student_nrc = $student->nrc != null ? $student->nrc : "No";
        // dd($student_nrc);
        $img->text(': ' . $student_nrc, 370, 290, function ($font) {
            $font->file(public_path('fonts/Linn-Caracas-Light.otf'));
            $font->size(28);
            $font->align('left');
            $font->valign('bottom');
            $font->angle(0);
        });

        $img->save(public_path('uploads/student_photo/' . $student->studentID . '.jpg'));

        $strpath = public_path() . "/uploads/student_photo/" . $student->studentID . '.jpg';

        $myFile = str_replace("\\", '/', $strpath);
        $headers = ['Content-Type: application/*'];
        $newName = $student->name . $student->studentID . '.jpg';




        return response()->download($myFile, $newName, $headers);
    }

    public function excel_export()
    {
        return Excel::download(new StudentExport, 'student_export.xlsx');
    }

    public function enquiry(Request $request)
    {
        $students = new Student();

        if ($request->keyword != null) {
            $students = $students->where('name', 'like', '%' . $request->keyword . '%')->orwhere('phone', 'like', '%' . $request->keyword . '%');
        }
        $count = $students->where('is_enquiry', 1)->where('is_delete', 0)->get()->count();

        $students = $students->where('is_enquiry', 1)->where('is_delete', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.enquiry.index', compact('students', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function enquiry_create()
    {
        return view('admin.enquiry.create');
    }

    public function enquiry_delete($id)
    {
        $student = Student::findorfail($id)->update([
            'is_delete' => 1
        ]);

        return redirect()->route('enquiry')->with('success', 'Success');
    }

    public function enquiry_edit($id)
    {
        $student = Student::findorfail($id);
        $nrc_code = explode('/', $student->nrc);
        $code_id = $nrc_code[0];
        $code_id = DB::table('nrccode')->where('name', $code_id)->first()->id;
        return view('admin.enquiry.edit', compact('student', 'code_id'));
    }

    public function enquiry_detail($id)
    {
        $student = Student::findorfail($id);

        return view('admin.enquiry.show', compact('student'));
    }

    public function nrc_state(Request $request)
    {
        if ($request->ajax()) {
            $nrc_state = DB::table('nrcstate')->where('code_id', $request->code_id)->get();
            echo "<option value=''>Select --</opiton>";
            foreach ($nrc_state as $key => $state) {
                echo "<option value='" . $state->name . "'>" . $state->name . "</opiton>";
            }
        }
    }

    public function student_detail($id)
    {
        $hashids = new Hashids('', 10); // pad to length 10
        $std_id = $hashids->decodeHex($id);

        $student = Student::findorfail($std_id);

        $courses = getStudentCoursesHistories($std_id);
        // dd($student);

        return view('admin.student.qr_detail', compact('student', 'courses'));
    }

    public function get_major(Request $request)
    {
        if ($request->ajax()) {
            $majors = new CourseHasMajor();
            $majors = $majors->select('majors.id', 'course_has_majors.course_id')
                ->leftjoin('majors', 'majors.id', '=', 'course_has_majors.major_id')
                ->where('course_has_majors.course_id', $request->course_id)->get();

            $majs = [];


            foreach ($majors as $key => $value) {

                if ($value->course_id == $request->course_id) {
                    array_push($majs, $value->id);
                }
            }

            $rmids = Major::whereNotIn('id', $majs)->pluck('id');

            return response()->json([
                'status' => true,
                'data' => $majs,
                'rm' => $rmids,
            ]);
        }
    }

    public function store_exam(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $date = $request->date;
            $has_students = Certificate::where('student_id', $request->std_id)->where('course_id', $request->c_id)->get()->count();
            // dd($has_students);
            if ($has_students == 0) {
                $major_ids = json_encode($request->major_id);
                // dd($major_ids);
                $certificate = Certificate::create([
                    'student_id' => $request->std_id,
                    'course_id' => $request->c_id,
                    'major_ids' => $major_ids,
                    'generate_by' => auth()->user()->name,
                    'remark' => $request->remark
                ]);

                $print_certificate = new Certificate();
                $print_certificate = $print_certificate->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificates.*', 'students.name', 'students.studentID')->find($certificate->id);


                $certificate_majors = Major::whereIn('id', $request->major_id)->orderBy('order_no','asc')->select('name')->get();
            } else {

                $print_certificate = new Certificate();
                $print_certificate = $print_certificate->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificates.*', 'students.name', 'students.studentID')->where('certificates.student_id', $request->std_id)->where('certificates.course_id', $request->c_id)->first();

               // dd($print_certificate);
                if ($print_certificate->is_delete == 1) {
                    $certificate = new Certificate();
                    $certificate = $certificate->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificates.*', 'students.name', 'students.studentID')->where('certificates.student_id', $request->std_id)->where('certificates.course_id', $request->c_id)->first();

                    $certificate = $certificate->update([
                        'is_delete'=>0
                    ]);
                }

                $certificate_majors = Major::whereIn('id', $request->major_id)->orderBy('order_no','asc')->select('name')->get();

                // $certificate = Certificate::where('student_id', $request->std_id)->where('course_id', $request->c_id)->first();
                // dd($certificate);
            }

            // dd($request->all());
            $student_has_course = StudentHasCourse::where('student_id', $request->std_id)->where('course_id', $request->c_id)->update([
                'is_finished' => 1
            ]);

            $filePath = public_path('uploads/qr_code/qr_').$print_certificate->studentID.'.png';
        
            if (!File::exists($filePath)) {
                $data = $print_certificate->studentID."/NPT , ".date('d-F-Y',strtotime($date));

                $qr_filename =  'qr_' . $print_certificate->studentID . '.png';
                QrCode::format('png')->backgroundColor(255, 255, 255)->color(0, 0, 0)->size(200)->generate($data, public_path('uploads/qr_code/' . $qr_filename));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        $print_option = $request->print_option;

        
        // dd($print_certificate);
        return view('admin.student.certificate_print', compact('print_certificate', 'certificate_majors', 'date','print_option'));
    }

    public function store_certificate_history(Request $request)
    {
        // dd($request->all());
        $certificate_history = CertificateHistory::create([
            'certificate_id' => $request->certificate_id,
            'print_by' => auth()->user()->name
        ]);

        return response()->json('success');
    }

    public function certificates(Request $request)
    {
        // dd($request->all());
        $certificates = new Certificate();
        $certificates = $certificates->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificates.*', 'students.name', 'students.phone_1', 'students.phone_2', 'students.photo', 'courses.name AS course_name');

        if ($request->keyword != null) {
            $certificates = $certificates->where(function ($query) use ($request) {
                $query->where('students.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('students.phone_1', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('students.phone_2', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        if ($request->course_id != null) {
            $certificates = $certificates->where('certificates.course_id', $request->course_id);
        }

        if ($request->is_taken != null) {
            $certificates = $certificates->where('certificates.is_taken', $request->is_taken);
        }

        // dd($certificates->get());

        $count = $certificates->where('certificates.is_delete',0)->get()->count();

        $certificates = $certificates->orderBy('certificates.created_at', 'desc')->paginate(10);
        return view('admin.certificate.list', compact('certificates', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function certificate_taken(Request $request)
    {
        $certificate = Certificate::findorfail($request->certificate_id)->update([
            'is_taken' => 1,
            'taken_by' => $request->taken_by,
            'taken_date' => date('Y-m-d H:i', strtotime($request->taken_date)) . ':00',
            'given_by' => auth()->user()->name,
            'taken_remark' => $request->remark
        ]);

        return redirect()->route('certificates')->with('success', 'Success');
    }

    public function certificate_detail($id)
    {
        $certificates = new Certificate();
        $certificates = $certificates->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificates.*', 'students.name', 'students.phone_1', 'students.phone_2', 'students.photo', 'courses.name AS course_name', 'students.father_name', 'students.dob', 'students.nrc', 'students.address')->find($id);

        $major_ids = json_decode($certificates->major_ids);
        // dd($majors);
        $majors = Major::whereIn('id', $major_ids)->select('name')->get();

        return view('admin.certificate.detail', compact('certificates', 'majors'));
    }

    public function certificate_history(Request $request)
    {
        $certificate_history = new CertificateHistory();
        $certificate_history = $certificate_history->leftjoin('certificates', 'certificates.id', '=', 'certificate_histories.certificate_id')->leftjoin('students', 'students.id', '=', 'certificates.student_id')->leftjoin('courses', 'courses.id', '=', 'certificates.course_id')->select('certificate_histories.id', 'students.name', 'students.phone_1', 'students.phone_2', 'courses.name AS course_name', 'certificate_histories.print_by','certificate_histories.created_at');

        if ($request->keyword != null) {
            $certificate_history = $certificate_history->where(function ($query) use ($request) {
                $query->where('students.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('students.phone_1', 'like', '%' . $request->keyword . '%')
                    ->orWhere('students.phone_2', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->course_id != null) {
            $certificate_history = $certificate_history->where('certificates.course_id', $request->course_id);
        }

        $certificate_history = $certificate_history->orderBy('certificate_histories.created_at', 'desc')->paginate(10);
        return view('admin.certificate.certificate_history', compact('certificate_history'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function get_course(Request $request)
    {
        // dd($request->all());
        $student_has_courses = new StudentHasCourse();
        $student_has_courses = $student_has_courses->leftjoin('courses', 'courses.id', '=', 'student_has_courses.course_id')->select('courses.id', 'courses.name')->where('student_has_courses.student_id', $request->std_id)->get();

        echo "<option value=''>Select--</opiton>";
        foreach ($student_has_courses as $key => $student_has_course) {
            echo "<option value='" . $student_has_course->id . "'>" . $student_has_course->name . "</opiton>";
        }
        // return $student_has_courses;
    }

    public function get_student_batch($id)
    {
        // dd($id);
        // $batches = BatchHasStudent::where('student_id',$id)->get();
        $batches = new BatchHasStudent();
        $batches = $batches->leftjoin('batches','batches.id','=','batch_has_students.batch_id')->where('batch_has_students.student_id',$id)->select('batches.name','batches.id')->where('batches.status',1)->get();

        echo "<option value=''>Select--</opiton>";
        foreach ($batches as $key => $batch) {
            echo "<option value='" . $batch->id . "'>" . $batch->name . "</opiton>";
        }
    }

    public function enquiry_export()
    {
        return Excel::download(new EnquiryExport, 'enquiry.xlsx');
    }

    public function certificate_export()
    {
        return Excel::download(new CertificateExport, 'certificate.xlsx');
    }

    public function history_export()
    {
        return Excel::download(new HistoryExport, 'certificate_history.xlsx');
    }

    public function att_history_export()
    {
        return Excel::download(new AttHistoryExport, 'attendance_history.xlsx');
    }

    public function certificate_delete($id)
    {
        // dd($id);
        $certificate = Certificate::findorfail($id)->update([
            'is_delete'=>1
        ]);

        return redirect()->route('certificates')->with('success','Success');
    }

    public function student_course_delete($id)
    {
        DB::beginTransaction();
        try {
            $student_course = StudentHasCourse::findorfail($id);

            $invoice = Invoice::where('student_id',$student_course->student_id)->where('course_id',$student_course->course_id)->delete();

            $student_batch = BatchHasStudent::where('student_id',$student_course->student_id)->where('batch_id',$student_course->batch_id)->delete();

            $course_student = StudentHasCourse::findorfail($id)->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return redirect()->route('students.index')->with('success','Success');
    }

    public function update_certificate_taken(Request $request)
    {
        // dd($request->all());
        $certificate = Certificate::findorfail($request->edit_id)->update([
            'taken_by' => $request->edit_taken_by,
            'taken_date' => date('Y-m-d H:i', strtotime($request->edit_taken_date)) . ':00',
            'taken_remark' => $request->remark
        ]);

        return redirect()->route('certificates')->with('success', 'Success');
    }

    public function print_preview(Request $request)
    {
        $student = Student::findorfail($request->preview_std_id);

        $certificate_majors = Major::whereIn('id', $request->preview_major_id)->orderBy('order_no','asc')->select('name')->get();

        $date = $request->date;

        $filePath = public_path('uploads/qr_code/qr_').$student->studentID.'.png';
        
        if (!File::exists($filePath)) {
            $data = $student->studentID."/NPT , ".date('d-F-Y',strtotime($date));

            $qr_filename =  'qr_' . $student->studentID . '.png';
            QrCode::format('png')->backgroundColor(255, 255, 255)->color(0, 0, 0)->size(200)->generate($data, public_path('uploads/qr_code/' . $qr_filename));
        }

        $print_option = $request->print_option;

        return view('admin.student.certificate_preview', compact('student', 'certificate_majors', 'date','print_option'));
    }
}