<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'district',
        'width',
        'length',
        'category',
        'kind',
        'images',
        'livingrooms',
        'bedrooms',
        'area',
        'bathrooms',
        'age',
        'kitchen',
        'ac',
        'furnished',
        'rentperiod',
        'price',
        'other'
    ];
}
