<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeTable;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TimeTable::create([
            'section' => 'mon-to-thu',
            'duration' => '9:00 ~ 11:00 AM',
            'order_no' => 1,
        ]);

        TimeTable::create([
            'section' => 'mon-to-thu',
            'duration' => '11:00 ~ 1:00 PM',
            'order_no' => 2,
        ]);

        TimeTable::create([
            'section' => 'mon-to-thu',
            'duration' => '1:00 ~ 3:00 PM',
            'order_no' => 3,
        ]);

        TimeTable::create([
            'section' => 'mon-to-thu',
            'duration' => '5:00 ~ 7:00 PM',
            'order_no' => 4,
        ]);

        TimeTable::create([
            'section' => 'sat-to-sun',
            'duration' => '9:00 ~ 12:00 PM',
            'order_no' => 5,
        ]);

        TimeTable::create([
            'section' => 'sat-to-sun',
            'duration' => '12:00 ~ 3:00 PM',
            'order_no' => 6,
        ]);

        TimeTable::create([
            'section' => 'sat-to-sun',
            'duration' => '3:00 ~ 6:00 PM',
            'order_no' => 7,
        ]);
    }
}