<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseHasMajor;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'status', 'order_no'
    ];

    // list data
    public static function list_data($request)
    {
        $data = new Major();

        if (!empty($request->keyword)) {
            $data = $data->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if (!empty($request->course)) {

            $major_ids = [];

            foreach (CourseHasMajor::where('course_id', $request->course)->select('major_id')->get() as $course_has_major) {
                array_push($major_ids, $course_has_major->major_id);
            }

            $data = $data->whereIn('id',  $major_ids);
        }

        return $data;
    }

    // store data
    public static function store_data($request)
    {
        Major::create([
            'name' => $request->name,
            'order_no' => $request->order_no
        ]);
    }

    // update data
    public static function update_data($major, $request)
    {
        $major->update([
            'name' => $request->name,
            'order_no' => $request->order_no
        ]);
    }

    // change status
    public static function change_status($request)
    {
        $data = Major::find($request->id);
        $data->update([
            'status' => $request->status,
        ]);
    }
}