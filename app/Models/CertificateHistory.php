<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateHistory extends Model
{
    use HasFactory;
    protected $table = 'certificate_histories';
    protected $fillable = ['certificate_id','print_by'];
}
