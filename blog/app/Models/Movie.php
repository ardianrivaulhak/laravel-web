<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;

class Movie extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = "id";
    protected $table = "movies";


    public function genres()
    {
        return $this->hasMany('App\Models\Genre', 'id', 'genreId');
    }

    public function favorite()
    {
        return $this->belongsTo('App\Models\Movie', 'movieId', 'id');
    }
}
