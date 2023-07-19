<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchStoreRequest;
use App\Models\Batch;
use App\Models\BatchHasStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $batches = Batch::list_data($request);
        $count = $batches->count();
        $batches =  $batches->paginate(10);

        return view('admin.batch.index', compact('batches', 'count'))->with('i', (request()->input('page', 1) - 1)  * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.batch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BatchStoreRequest $request)
    {
        //
        Batch::store_data($request);

        return redirect()->route('batch.index')->with('success', 'Created Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
        $students = new BatchHasStudent();
        $students = $students->select('students.name', 'students.phone_1', 'students.studentID', 'batch_has_students.is_finished')
            ->leftjoin('students', 'students.id', 'batch_has_students.student_id')
            ->where('batch_has_students.batch_id', $batch->id)
            ->get();
        return view('admin.batch.show', compact('batch', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        //

        $student_ids = BatchHasStudent::where('batch_id', $batch->id)->pluck('student_id');
        return view('admin.batch.edit', compact('batch', 'student_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(BatchStoreRequest $request, Batch $batch)
    {
        //

        Batch::update_data($request, $batch);
        return redirect()->route('batch.index')->with('success', 'Updated Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        //
    }

    public function end(Request $request, $id)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request, $id) {

                $batch = Batch::find($id);

                $batch->update([
                    'remark' => $request->remark,
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'status' => 0,
                ]);

                BatchHasStudent::where('batch_id', $id)->where('is_finished', '!=', 2)->update([
                    'is_finished' => 1,
                ]);

                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
        }

        return redirect()->route('batch.index')->with('success', 'Finised');
    }

    public function unfinish(Request $request,$id)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request, $id) {

                $batch = Batch::find($id);

                $batch->update([
                    'remark' => null,
                    'end_date' => null,
                    'status' => 1,
                ]);

                BatchHasStudent::where('batch_id', $id)->where('is_finished', '!=', 2)->update([
                    'is_finished' => 0,
                ]);

                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
        }

        return redirect()->route('batch.index')->with('success', 'Finised');
    }
}