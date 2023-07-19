<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\EnquiryHasCourse;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone_1', 'phone_2', 'qualification', 'time_table_id', 'is_anytime', 'enquiry_status', 'remark', 'c_by', 'u_by', 'is_delete'
    ];

    public static function list_data($request)
    {
        $data = new Enquiry();
        $data = $data->select('enquiries.*', 'time_tables.section', 'time_tables.duration')
            ->leftjoin('time_tables', 'time_tables.id', 'enquiries.time_table_id')
            ->leftjoin('enquiry_has_courses', 'enquiry_has_courses.enquiry_id', 'enquiries.id')
            ->groupBy('enquiries.id');

        if (!empty($request->keyword)) {
            $data = $data->where(function ($query) use ($request) {
                $query->where('enquiries.name', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('enquiries.phone_1', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('enquiries.phone_2', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->qualification)) {
            $data = $data->where('enquiries.qualification', $request->qualification);
        }

        if (!empty($request->course)) {
            $data = $data->where('enquiry_has_courses.course_id', $request->course);
        }

        if ($request->condition != '') {
            $data = $data->where('enquiries.enquiry_status', $request->condition);
        }

        if (!empty($request->time_table)) {

            if ($request->time_table == 'any') {
                $data = $data->where('enquiries.is_anytime', '1');
            } else {
                $data = $data->where('enquiries.time_table_id', $request->time_table);
            }
        }

        if ($request->from_date != '' and $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date)) . ' 00:00';
            $to_date = date('Y-m-d', strtotime($request->to_date)) . ' 23:59';
            $data = $data->whereBetween('enquiries.created_at', [$from_date, $to_date]);
        }

        // $data = $data->where('enquiries.enquiry_status', '!=', '1');
        $data = $data->where('is_delete', '0')->orderBy('enquiries.enquiry_status', 'ASC');

        return $data;
    }

    // store data
    public static function store_data($request)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request) {

                $is_anytime = $request->time_table == 'any' ? 1 : 0;

                $enquiry = Enquiry::create([
                    'name' => $request->name,
                    'qualification' => $request->qualification,
                    'phone_1' => $request->phone_1,
                    'phone_2' => $request->phone_2,
                    'remark' => $request->remark,
                    'is_anytime' => $is_anytime,
                    'time_table_id' => is_numeric($request->time_table) ? $request->time_table : null,
                    'c_by' => auth()->user()->name
                ]);

                foreach ($request->course as $course_id) {
                    EnquiryHasCourse::create([
                        'course_id' => $course_id,
                        'enquiry_id' => $enquiry->id,
                    ]);
                }


                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public static function update_data($request, $enquiry)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request, $enquiry) {


                $is_anytime = $request->time_table == 'any' ? 1 : 0;

                $enquiry->update([
                    'name' => $request->name,
                    'qualification' => $request->qualification,
                    'phone_1' => $request->phone_1,
                    'phone_2' => $request->phone_2,
                    'remark' => $request->remark,
                    'is_anytime' => $is_anytime,
                    'enquiry_status' => $request->enquiry_status,
                    'time_table_id' => is_numeric($request->time_table) ? $request->time_table : null,
                    'u_by' => auth()->user()->name
                ]);

                EnquiryHasCourse::where('enquiry_id', $enquiry->id)->delete();

                foreach ($request->course as $course_id) {
                    EnquiryHasCourse::create([
                        'course_id' => $course_id,
                        'enquiry_id' => $enquiry->id,
                    ]);
                }


                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
            dd($e->getMessage());
        }
    }
}