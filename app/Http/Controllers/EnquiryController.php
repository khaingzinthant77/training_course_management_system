<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnquiryStoreRequest;
use App\Models\Enquiry;
use App\Models\EnquiryHasCourse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $enquiries = Enquiry::list_data($request);
        $count = $enquiries->get()->count();

        $enquiries = $enquiries->orderBy('enquiries.created_at', 'DESC')->paginate(10);;
        return view('admin.enquiries.index', compact('enquiries', 'count'))->with('i', (request()->input('page', 1) - 1)  * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.enquiries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnquiryStoreRequest $request)
    {
        //
        Enquiry::store_data($request);

        return redirect()->route('enquiries.index')->with('success', 'Created Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function show(Enquiry $enquiry)
    {
        //

        $enquiry_has_courses = [];
        $ehc = EnquiryHasCourse::where('enquiry_id', $enquiry->id)->get();

        foreach ($ehc as $data) {
            array_push($enquiry_has_courses, $data->course_id);
        }
        return view('admin.enquiries.show', compact('enquiry', 'enquiry_has_courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(Enquiry $enquiry)
    {
        //
        $enquiry_has_courses = [];
        $ehc = EnquiryHasCourse::where('enquiry_id', $enquiry->id)->get();

        foreach ($ehc as $data) {
            array_push($enquiry_has_courses, $data->course_id);
        }

        return view('admin.enquiries.edit', compact('enquiry', 'enquiry_has_courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function update(EnquiryStoreRequest $request, Enquiry $enquiry)
    {
        //
        Enquiry::update_data($request, $enquiry);

        return redirect()->route('enquiries.index')->with('success', 'Updated Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $data = Enquiry::find($id);
        $data->update([
            'is_delete' => 1,
        ]);

        return redirect()->route('enquiries.index')->with('success', 'Deleted Success');
    }
}