<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefaultMB extends Model
{
    use HasFactory,SoftDeletes;
    //one to many relationship, create children relationship
    public function children()
    {
        return $this->hasMany(DefaultMB::class, 'ParenId')->orderBy('Ordering');
    }
}
