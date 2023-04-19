<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = "id";
    protected $table = "favorite";


    public function movies()
    {
        return $this->hasMany('App\Models\Favorite', 'id', 'movieId');
    }
}
