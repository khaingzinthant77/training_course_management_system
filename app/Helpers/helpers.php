<?php

use App\Models\Attendance;
use App\Models\CategoryHasStockType;
use App\Models\CourseHasMajor;
use App\Models\Course;
use App\Models\EnquiryHasCourse;
use App\Models\Invoice;
use App\Models\TimeTable;
use App\Models\StudentHasCourse;
use App\Models\Student;
use App\Models\Major;
use App\Models\User;
use App\Models\Batch;
use App\Models\BatchHasStudent;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

//  Active Route
if (!function_exists('activeRoute')) {
  function activeRoute($route, $isClass = false)
  {
    // $requestUrl = request()->fullUrl() === $route ? true : false;
    $requestUrl = str_contains(request()->fullUrl(), $route) ? true : false;

    if ($isClass) {
      return $requestUrl ? $isClass : '';
    } else {
      return $requestUrl ? 'active' : '';
    }
  }
}

//  get_major_count_from_course
if (!function_exists('get_major_count_from_course')) {
  function get_major_count_from_course($course_id)
  {
    return CourseHasMajor::where('course_id', $course_id)->count();
  }
}

//  get_majors
if (!function_exists('get_majors')) {
  function get_majors($course_id)
  {
    $data = CourseHasMajor::where('course_id', $course_id)->select('majors.name')
      ->leftjoin('majors', 'majors.id', '=', 'course_has_majors.major_id')
      ->get();
    return $data;
  }
}

//  getStudentIdByTimeTable
if (!function_exists('getStudentIdByTimeTable')) {
  function getStudentIdByTimeTable($id)
  {
    return StudentHasCourse::where('time_table_id', $id)->select('student_id')->get();
  }
}

//  getStudentIdByCourse
if (!function_exists('getStudentIdByCourse')) {
  function getStudentIdByCourse($id)
  {
    return StudentHasCourse::where('course_id', $id)->select('student_id')->get();
  }
}

//  getStudentIdByDate
if (!function_exists('getStudentIdByDate')) {
  function getStudentIdByDate($from_date, $to_date)
  {
    return StudentHasCourse::whereBetween('join_date', [$from_date, $to_date])->select('student_id')->get();
  }
}

//get foc student
if (!function_exists('getFOCStudent')) {
  function getFOCStudent($foc)
  {
    return StudentHasCourse::where('is_foc', $foc)->select('student_id')->get();
  }
}
//  getTodayAttCount
if (!function_exists('getTodayAttCount')) {
  function getTodayAttCount()
  {
    return Attendance::whereDate('date', date('Y-m-d'))->count();
  }
}

//  getCourseByEnquiry
if (!function_exists('getCourseByEnquiry')) {
  function getCourseByEnquiry($enquiry_id)
  {
    $data = new EnquiryHasCourse();
    $data = $data->select('courses.name')
      ->leftjoin('courses', 'courses.id', 'enquiry_has_courses.course_id')
      ->where('enquiry_has_courses.enquiry_id', $enquiry_id)
      ->get();


    return $data;
  }
}

//  getAttendingCourse
if (!function_exists('getAttendingCourse')) {
  function getAttendingCourse($student_id)
  {

    $data = new StudentHasCourse();
    $data = $data->select('courses.name', 'student_has_courses.student_id', 'student_has_courses.course_id', 'student_has_courses.is_finished', 'student_has_courses.join_date', 'time_tables.section', 'time_tables.duration', 'student_has_courses.is_foc')
      ->leftjoin('courses', 'courses.id', 'student_has_courses.course_id')
      ->leftjoin('time_tables', 'time_tables.id', 'student_has_courses.time_table_id')
      ->where('student_has_courses.student_id', $student_id)
      ->get();

    return $data;
  }
}

//  get Batch Name
if (!function_exists('getBatchName')) {
  function getBatchName($student_id, $course_id)
  {
    $data = new BatchHasStudent();
    $data = $data->select('batches.name')
      ->leftjoin('batches', 'batches.id', 'batch_has_students.batch_id')
      ->where('course_id', $course_id)
      ->where('student_id', $student_id)
      ->first();


    return $data;
  }
}


//  check attending stauts
if (!function_exists('checkAttendingStatus')) {
  function checkAttendingStatus($status)
  {
    $check = StudentHasCourse::where('is_finished', $status)->select('student_id')->get();
    return $check;
  }
}

//  checkCourseFilter
if (!function_exists('checkCourseFilter')) {
  function checkCourseFilter($course_id)
  {
    $check = StudentHasCourse::where('course_id', $course_id)->select('student_id')->get();
    return $check;
  }
}

//  checkSectionFilter
if (!function_exists('checkSectionFilter')) {
  function checkSectionFilter($section_id)
  {
    $check = StudentHasCourse::where('time_table_id', $section_id)->select('student_id')->get();
    return $check;
  }
}

//  checkBatchFilter
if (!function_exists('checkBatchFilter')) {
  function checkBatchFilter($batch_id)
  {
    $check = BatchHasStudent::where('batch_id', $batch_id)->select('student_id')->get();
    return $check;
  }
}

//  getCourseName
if (!function_exists('getCourseName')) {
  function getCourse($course_id)
  {
    $data = Course::find($course_id);
    return $data;
  }
}

//get batch
if (!function_exists('getBatch')) {
  function getBatch()
  {
    $data = Batch::where('status', 1)->get();
    return $data;
  }
}

function nrc_codes()
{
  $nrc_codes = DB::table('nrccode')->get();
  return $nrc_codes;
}

function nrcstate()
{
  $nrcstate = DB::table('nrcstate')->get();
  return $nrcstate;;
}

function courses()
{
  $courses = Course::all();
  return $courses;
}

function coursesByStudent($student_id)
{
  $data = new Course();
  $data = $data->select('courses.name', 'courses.id')
    ->leftjoin('student_has_courses', 'student_has_courses.course_id', 'courses.id')
    ->where('student_has_courses.student_id', $student_id)
    ->where('student_has_courses.is_finished', '=', '0')->get();
  return $data;
}

function getStudentCoursesHistories($student_id)
{
  $data = new Course();
  $data = $data->select('courses.name', 'courses.id', 'student_has_courses.is_finished')
    ->leftjoin('student_has_courses', 'student_has_courses.course_id', 'courses.id')
    ->where('student_has_courses.student_id', $student_id)
    ->get();
  return $data;
}

function timetables()
{
  $time_tables = TimeTable::all();
  return $time_tables;
}

function students()
{
  $students = Student::where('is_delete', 0)->get();
  return $students;
}

function majors()
{
  $majors = Major::where('status', 1)->get();
  return $majors;
}

function getStudentCountByBatch($batch_id)
{
  return BatchHasStudent::where('batch_id', $batch_id)->count();
}

function getStudentListByBatch($batch_id)
{
  $data = new BatchHasStudent();
  $data = $data->select('batch_has_students.is_finished', 'students.name')
    ->leftjoin('students', 'students.id', 'batch_has_students.student_id')
    ->where('batch_id', $batch_id)->get();
  return  $data;
}

function users()
{
  $users = User::all();
  return $users;
}

function batches()
{
  $batches = Batch::all();
  return $batches;
}

// Get Income By Course
if (!function_exists('getIncomeByCourse')) {
  function getIncomeByCourse($course_id, $request)
  {
    $data = new Invoice();
    $data = $data->select('discount_amount', 'net_pay')
      ->where('course_id', $course_id);

    if ($request->from_date != '' and $request->to_date != '') {

      $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    $data = $data->get();
    return  $data;
  }
}

// Get Fee By Course
if (!function_exists('getFeeByCourse')) {
  function getFeeByCourse($course_id)
  {
    return  Course::find($course_id)->fee;
  }
}



// Set Mail Configure
if (!function_exists('setMailConfig')) {
  function setMailConfig()
  {
    $setting = Setting::first();
    if ($setting) {
      $host = $setting->mail_host;
      $port = $setting->mail_port;
      $username = $setting->mail_username;
      $password = $setting->mail_password;
      $encryption = $setting->mail_encryption;
      $from_address = $setting->mail_from_address;
      $from_name = $setting->mail_from_name;

      $config = array(
        'transport'     => 'smtp',
        'host'       => $host,
        'port'       => $port,
        'from'       => array('address' => $from_address, 'name' => $from_name),
        'encryption' => $encryption,
        'username'   => $username,
        'password'   => $password,
      );

      config(['mail.mailers.smtp' => $config]);
    }
  }
}