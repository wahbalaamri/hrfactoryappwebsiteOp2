<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respondents extends Model
{
    use HasFactory,SoftDeletes;
    // table name
    protected $table = 'respondents';
    //fields
    protected $fillable = [
        'name',
        'email',
        'phone',
        'department_id',
    ];
    //belongs to department
    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id', 'id');
    }
}
