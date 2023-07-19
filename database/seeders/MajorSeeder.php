<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Major::create([
            'name' => 'Windows 11',
            'order_no' => 1,
        ]);

        Major::create([
            'name' => 'Nero Burning',
            'order_no' => 2,
        ]);
        Major::create([
            'name' => 'Adobe Page Maker 7.0',
            'order_no' => 3,
        ]);

        Major::create([
            'name' => 'Microsoft Office Power Point',
            'order_no' => 4,
        ]);

        Major::create([
            'name' => 'Microsoft Office Excel',
            'order_no' => 5,
        ]);

        Major::create([
            'name' => 'Microsoft Office Word',
            'order_no' => 6,
        ]);

        Major::create([
            'name' => 'Internet e-mail',
            'order_no' => 7,
        ]);

        Major::create([
            'name' => 'Adobe Illustrator',
            'order_no' => 8,
        ]);

        Major::create([
            'name' => 'Photoshop',
            'order_no' => 9,
        ]);
    }
}