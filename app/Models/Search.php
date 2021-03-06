<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'breed_name',
        'breed_description',
        'breed_photo_url',
        'count'
    ];
}