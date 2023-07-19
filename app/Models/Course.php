<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseHasMajor;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'fee', 'duration', 'status'
    ];

    // list data
    public static function list_data($request)
    {
        $data = new Course();

        if (!empty($request->keyword)) {
            $data = $data->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        return $data;
    }


    // store data
    public static function store_data($request)
    {

        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request) {

                $course = Course::create([
                    'name' => $request->name,
                    'fee' => $request->fee,
                    'duration' => $request->duration,
                ]);

                foreach ($request->major as $id) {
                    CourseHasMajor::create([
                        'course_id' => $course->id,
                        'major_id' => $id,
                    ]);
                }

                DB::commit();

                return true;
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            return false;
        }
    }

    // update data
    public static function update_data($course, $request)
    {
        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($request, $course) {

                CourseHasMajor::where('course_id', $course->id)->delete();

                $majors = is_array($request->major) ? $request->major : [];

                foreach ($majors as $id) {
                    CourseHasMajor::create([
                        'major_id' => $id,
                        'course_id' => $course->id
                    ]);
                }

                $course->update([
                    'name' => $request->name,
                    'fee' => $request->fee,
                    'duration' => $request->duration,
                ]);

                DB::commit();

                return true;
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
            return false;
        }
    }

    // delete data
    public static function delete_data($course)
    {

        try {
            // Database Operations Within The Transaction Start
            DB::transaction(function () use ($course) {

                CourseHasMajor::where('course_id', $course->id)->delete();

                $course->delete();

                DB::commit();
            });
        } catch (QueryException $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();
        }
    }

    // change_status
    public static function change_status($request)
    {
        $data = Course::find($request->id);
        $data->update([
            'status' => $request->status,
        ]);
    }
}