<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    // table name
    protected $table = 'clients';
    //fields
    protected $fillable = [
        'name',
        'name_ar',
        'country',
        'industry',
        'client_size',
        'partner_id',
        'logo_path',
        'phone',
        'webiste',
        'use_sections',
    ];

    //relationship focal point
    public function focalPoint()
    {
        return $this->hasMany(FocalPoints::class, 'client_id', 'id');
    }
}
