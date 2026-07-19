<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateFont extends Model
{
    use HasFactory;

    protected $fillable = [
        'font_name',
        'file_path',
    ];
}
