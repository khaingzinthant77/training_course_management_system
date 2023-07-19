<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //

        $setting->update([
            'late_interval' => $request->late_interval ?? 0,
            'firebase_apiKey' => $request->firebase_apiKey,
            'firebase_authDomain' => $request->firebase_authDomain,
            'firebase_projectId' => $request->firebase_projectId,
            'firebase_storageBucket' => $request->firebase_storageBucket,
            'firebase_messagingSenderId' => $request->firebase_messagingSenderId,
            'firebase_appId' => $request->firebase_appId,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'recovery_mail' => $request->recovery_mail,
            'pwd_reset_expire' => $request->pwd_reset_expire,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_from_name' => $request->mail_from_name,
            'mail_from_address' => $request->mail_from_address,
            'mail_encryption' => $request->mail_encryption,
        ]);

        return redirect()->back()->with('success', 'Setting Data has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}