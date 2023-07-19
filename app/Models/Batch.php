<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BatchHasStudent;
use Illuminate\Support\Facades\DB;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'course_id', 'max_students', 'status', 'start_date', 'end_date', 'remark', 'c_by', 'u_by'
    ];

    // list data
    public static function list_data($request)
    {
        $data = new Batch();
        // $data = $data->select('batches.*',)

        if ($request->keyword != '') {
            $data = $data->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->start_date != '') {
            $data = $data->whereDate('start_date', date('Y-m-d', strtotime($request->start_date)));
        }

        if ($request->end_date != '') {
            $data = $data->whereDate('end_date', date('Y-m-d', strtotime($request->end_date)));
        }

        if ($request->status != '') {
            $data = $data->where('status', $request->status);
        }


        if ($request->course != '') {
            $data = $data->where('course_id', $request->course);
        }

        return $data;
    }

    // store data 
    public static function store_data($request)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request) {

                $batch = Batch::create([
                    'name' => $request->name,
                    'course_id' => $request->course,
                    'max_students' => $request->max_students,
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'c_by' => $request->c_by,
                ]);

                foreach ($request->students as $id) {
                    BatchHasStudent::create([
                        'student_id' => $id,
                        'batch_id' => $batch->id,
                        'is_finished' => 0,
                    ]);
                }

                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
        }
    }

    // update data
    public  static function update_data($request, $batch)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request, $batch) {

                $batch->update([
                    'name' => $request->name,
                    'course_id' => $request->course,
                    'max_students' => $request->max_students,
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'u_by' => $request->u_by,
                ]);

                BatchHasStudent::where('batch_id', $batch->id)->delete();

                foreach ($request->students as $id) {
                    BatchHasStudent::create([
                        'student_id' => $id,
                        'batch_id' => $batch->id,
                        'is_finished' => 0,
                    ]);
                }

                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
        }
    }
}