<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $setting = new Setting;
        $setting->late_interval = 5;
        $setting->pwd_reset_expire = 15;
        $setting->save();
    }
}