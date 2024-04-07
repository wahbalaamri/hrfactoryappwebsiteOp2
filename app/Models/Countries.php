<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Countries extends Model
{
    use HasFactory, SoftDeletes;
    // Table Name
    protected $table = 'countries';
    //fillable fields
    // protected $fillable = [
    //     'CountryName',
    //     'CountryName_ar',
    //     'IsArabCountry',
    //     'CountryCode',
    //     'CountryFlag',
    //     'CountryFlag_ar',
    //     'CountryFlagPath',
    //     'CountryFlagPath_ar',
    //     'CountryFlagPath_svg',
    //     'CountryFlagPath_svg_ar',
    //     'CountryFlagPath_png',
    //     'CountryFlagPath_png_ar',
    //     'CountryFlagPath_jpg',
    //     'CountryFlagPath_jpg_ar',
    //     'CountryFlagPath_gif',
    //     'CountryFlagPath_gif'
    //     ];
    //has many relationship with services
    public function services()
    {
        return $this->hasMany(Services::class);
    }
    //has many relationship with plansPrices
    public function plansPrices()
    {
        return $this->hasMany(PlansPrices::class,'id','country');
    }
}
