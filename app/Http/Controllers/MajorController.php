<?php

namespace App\Http\Controllers;

use App\Http\Requests\MajorStoreRequest;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $majors = Major::list_data($request);
        $count = $majors->count();
        $majors = $majors->orderBy('order_no', 'asc')->paginate(10);

        return view('admin.major.index', compact('majors', 'count'))->with('i', (request()->input('page', 1) - 1)  * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.major.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MajorStoreRequest $request)
    {
        //
        Major::store_data($request);
        return redirect()->route('major.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        //
        return view('admin.major.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function update(MajorStoreRequest $request, Major $major)
    {
        //
        Major::update_data($major, $request);
        return redirect()->route('major.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        //
        $major->delete();
        return redirect()->route('major.index')->with('success', 'Deleted Successfully');
    }

    public function change_status(Request $request)
    {
        Major::change_status($request);

        return response()->json([
            'status' => 1,
            'message' => 'success'
        ]);
    }
}