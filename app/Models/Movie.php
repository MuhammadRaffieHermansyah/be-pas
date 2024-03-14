<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // public function getImageAttribute(){
    //     return asset("movie_image/" .$this->attributes["image"]);
    //     }


    protected $fillable = [
        'name',
        'duration',
        'synopsis',
        'year',
        'image'
    ];
}
