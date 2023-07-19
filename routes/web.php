<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('table', [App\Http\Controllers\HomeController::class, 'table'])->name('table');

Route::get('button', [App\Http\Controllers\HomeController::class, 'button'])->name('button');

Route::get('card', [App\Http\Controllers\HomeController::class, 'card'])->name('card');

Route::get('animation', [App\Http\Controllers\HomeController::class, 'animation'])->name('animation');

Route::get('border', [App\Http\Controllers\HomeController::class, 'border'])->name('border');

Route::get('other', [App\Http\Controllers\HomeController::class, 'other'])->name('other');

Route::get('color', [App\Http\Controllers\HomeController::class, 'color'])->name('color');

Route::get('ui', function () {
    // return view('admin.user_folder.vm_detail_ui');
    return view('admin.users.show');
});


//student detail for qr scan
Route::get('student_detail/{id}', [StudentController::class, 'student_detail'])->name('student_detail');
// Redirect
Route::get('/', function () {
    return redirect()->route('login');
});


// Authentication Routes
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

// Ajax Login 
Route::get('ajax_login', [LoginController::class, 'ajax_login'])->name('ajax_login');

// Ajax Validate OTP
Route::post('ajax_check_otp', [LoginController::class, 'ajax_check_otp'])->name('ajax_check_otp');

// Ajax Normal Login
Route::post('ajax_normal_login', [LoginController::class, 'ajax_normal_login'])->name('ajax_normal_login');

Route::get('forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password');

Route::get('forgot_password_reseted', [LoginController::class, 'forgot_password_reseted'])->name('forgot_password_reseted');

Route::post('send_reset_link', [LoginController::class, 'send_reset_link'])->name('send_reset_link');

Route::get('password_reset', [LoginController::class, 'password_reset'])->name('password_reset');

Route::post('pwd_reset', [LoginController::class, 'pwd_reset'])->name('pwd_reset');




Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //timetable module
    Route::resource('time_tables', TimeTableController::class);

    Route::get('timetable_change_status', [TimeTableController::class, 'timetable_change_status'])->name('timetable_change_status');

    //student module
    Route::resource('students', StudentController::class);

    // add to student
    Route::post('add_to_student', [StudentController::class, 'add_to_student'])->name('add_to_student');

    Route::post('cancel_course/{id}', [StudentController::class, 'cancelCourse'])->name('cancelCourse');

    // add course
    Route::post('add_course', [StudentController::class, 'add_course'])->name('add_course');

    //enquiry module
    Route::get('enquiry', [StudentController::class, 'enquiry'])->name('enquiry');

    Route::get('enquiry_create', [StudentController::class, 'enquiry_create'])->name('enquiry_create');

    Route::get('enquiry_edit/{id}', [StudentController::class, 'enquiry_edit'])->name('enquiry_edit');

    Route::get('enquiry_detail/{id}', [StudentController::class, 'enquiry_detail'])->name('enquiry_detail');

    Route::delete('enquiry/{id}', [StudentController::class, 'enquiry_delete'])->name('enquiry_delete');

    //enquiry export
    Route::post('enquiry_export', [StudentController::class, 'enquiry_export'])->name('enquiry_export');

    Route::get('student_change_status', [StudentController::class, 'student_change_status'])->name('student_change_status');

    Route::post('course_add', [StudentController::class, 'course_add'])->name('course_add');

    //card generate list
    Route::get('student_card_generate', [StudentController::class, 'student_card_generate'])->name('student_card_generate');

    //card genrate
    Route::get('card_generate/{id}', [StudentController::class, 'card_generate'])->name('card_generate');

    //student excel export
    Route::post('excel_export', [StudentController::class, 'excel_export'])->name('excel_export');

    // Users Module
    Route::resource('users', UserController::class);


    // Major Module
    Route::resource('major', MajorController::class);
    Route::get('major_change_status', [MajorController::class, 'change_status']);

    // Course Module
    Route::resource('course', CourseController::class);
    Route::get('course_change_status', [CourseController::class, 'change_status']);
    Route::post('get_course_fee/{id}', [CourseController::class, 'getCourseFee']);

    // Attendance Module
    Route::resource('attendance', AttendanceController::class);
    Route::get('att_history', [AttendanceController::class, 'attendance_history'])->name('att_history');
    Route::get('att_summary', [AttendanceController::class, 'att_summary'])->name('att_summary');
    Route::post('att_summary_export', [AttendanceController::class, 'att_summary_export'])->name('att_summary_export');
    Route::post('attendance', [AttendanceController::class, 'attendance_insert'])->name('attendance_insert');
    Route::post('attendance_store', [AttendanceController::class, 'store'])->name('attendance.store');

    // Invoice Module
    Route::resource('invoice', InvoiceController::class);
    Route::post('invoice_export', [InvoiceController::class, 'export'])->name('invoice.export');
    Route::get('invoice_detail/{id}', [InvoiceController::class, 'detail'])->name('invoice.detail');
    Route::get('invoice_summary', [InvoiceController::class, 'summary'])->name('invoice.summary');

    // Batch Module
    Route::resource('batch', BatchController::class);
    Route::post('batch_end/{id}', [BatchController::class, 'end'])->name('batch.end');
    Route::post('batch_unfinish/{id}',[BatchController::class,'unfinish'])->name('batch.unfinish');

    //get nrc state
    Route::post('nrc_state', [StudentController::class, 'nrc_state'])->name('nrc_state');

    //get major
    Route::post('get_major', [StudentController::class, 'get_major'])->name('get_major');

    //store exam result
    Route::post('store_exam', [StudentController::class, 'store_exam'])->name('store_exam');

    //print_preview
    Route::post('print_preview',[StudentController::class,'print_preview'])->name('print_preview');

    //get batch student
    Route::post('get_student_batch/{id}', [StudentController::class, 'get_student_batch']);

    // Enquiries Module
    Route::resource('enquiries', EnquiryController::class);

    //store_certificate_history
    Route::post('store_certificate_history', [StudentController::class, 'store_certificate_history'])->name('store_certificate_history');

    // Setting Module
    Route::resource('setting', SettingController::class);
    Route::post('store_certificate_history', [StudentController::class, 'store_certificate_history'])->name('store_certificate_history');

    //certificate
    Route::get('certificates', [StudentController::class, 'certificates'])->name('certificates');

    //certificate edit
    Route::post('update_certificate_taken',[StudentController::class,'update_certificate_taken'])->name('update_certificate_taken');

    //certificate delete
    Route::delete('certificate_delete/{id}',[StudentController::class,'certificate_delete'])->name('certificate.destroy');

    //certificate_taken
    Route::post('certificate_taken', [StudentController::class, 'certificate_taken'])->name('certificate_taken');

    //certificate detail
    Route::get('certificate_detail/{id}', [StudentController::class, 'certificate_detail'])->name('certificate_detail');

    //certificate history
    Route::get('certificate_history', [StudentController::class, 'certificate_history'])->name('certificate_history');

    //certificate export
    Route::post('certificate_export', [StudentController::class, 'certificate_export'])->name('certificate_export');

    //get_course
    Route::post('get_course', [StudentController::class, 'get_course'])->name('get_course');

    //history_export
    Route::post('history_export', [StudentController::class, 'history_export'])->name('history_export');

    //attendance history export
    Route::post('att_history_export', [StudentController::class, 'att_history_export'])->name('att_history_export');

    //student course edit
    Route::get('student_course_edit/{id}',[StudentController::class,'student_course_edit'])->name('student_course_edit');

    //student course update
    Route::put('student_course/{id}',[StudentController::class,'student_course_update'])->name('student_course.update');

    //student course delete
    Route::delete('student_course_delete/{id}',[StudentController::class,'student_course_delete'])->name('student_course_delete');
});