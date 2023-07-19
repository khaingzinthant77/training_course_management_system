<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'late_interval',
        'firebase_apiKey',
        'firebase_authDomain',
        'firebase_projectId',
        'firebase_storageBucket',
        'firebase_messagingSenderId',
        'firebase_appId',
        'mail_username',
        'mail_password',
        'mail_port',
        'mail_host',
        'pwd_reset_expire',
        'recovery_mail',
        'mail_from_name',
        'mail_from_address',
        'mail_encryption'
    ];
}