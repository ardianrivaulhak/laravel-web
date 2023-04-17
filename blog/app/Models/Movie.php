<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "movies";


    public function genres()
    {
        return $this->hasMany('App\Models\Hris\Genre', 'id', 'genreId');
    }
}
