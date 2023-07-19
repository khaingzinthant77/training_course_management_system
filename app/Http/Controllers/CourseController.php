<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Models\Course;
use App\Models\CourseHasMajor;
use App\Models\Major;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $courses = Course::list_data($request);
        $count = $courses->count();
        $courses = $courses->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.course.index', compact('courses', 'count'))->with('i', (request()->input('page', 1) - 1)  * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $majors = Major::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('admin.course.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        //
        Course::store_data($request);


        return redirect()->route('course.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    public function getCourseFee($course_id)
    {
        $course = Course::find($course_id);
        return response()->json([
            'status' => 1,
            'fee' => $course->fee,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
        $majors = Major::where('status', 1)->orderBy('name', 'ASC')->get();

        $course_has_majors = [];

        foreach (CourseHasMajor::where('course_id', $course->id)->select('major_id')->get() as $data) {
            array_push($course_has_majors, $data->major_id);
        }

        return view('admin.course.edit', compact('course', 'majors', 'course_has_majors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseStoreRequest $request, Course $course)
    {
        //
        Course::update_data($course, $request);

        return redirect()->route('course.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
        Course::delete_data($course);
        return redirect()->route('course.index')->with('success', 'Deleted Successfully');
    }

    public function change_status(Request $request)
    {
        Course::change_status($request);

        return response()->json([
            'status' => 1,
            'message' => 'success'
        ]);
    }
}