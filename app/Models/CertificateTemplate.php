<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'background_path',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
