<?php

namespace App\Http\Controllers;

use App\Models\TimeTable;
use Illuminate\Http\Request;
use App\Http\Requests\TimetableStoreRequest;
use App\Models\Student;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $time_tables = new TimeTable();

        $count = $time_tables->get()->count();

        $time_tables = $time_tables->orderBy('order_no', 'asc')->paginate(10);
        return view('admin.timetable.index', compact('time_tables', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.timetable.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimetableStoreRequest $request)
    {
        foreach ($request->duration as $key => $value) {
            $time_table = TimeTable::create([
                'section' => $request->section,
                'duration' => $value,
                'order_no' => $request->order_no
            ]);
        }

        return redirect()->route('time_tables.index')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function show(TimeTable $timeTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $timetable = TimeTable::findorfail($id);
        return view('admin.timetable.edit', compact('timetable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function update(TimetableStoreRequest $request, $id)
    {
        $timetable = TimeTable::findorfail($id);
        $timetable = $timetable->update([
            'section' => $request->section,
            'duration' => $request->duration,
            'order_no' => $request->order_no
        ]);
        return redirect()->route('time_tables.index')->with('success', 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::where('time_table_id', $id)->get()->count();

        if ($student > 0) {
            return redirect()->route('time_tables.index')->with('error', 'cannot delete!');
        } else {
            $time_tables = TimeTable::findorfail($id)->delete();
            return redirect()->route('time_tables.index')->with('success', 'Success');
        }
    }

    public function timetable_change_status(Request $request)
    {
        $time_tables = TimeTable::findorfail($request->id)->update([
            'status' => $request->status
        ]);

        return response()->json('success');
    }
}