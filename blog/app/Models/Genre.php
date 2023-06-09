<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\Movie;

class Genre extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'name',
    ];
    protected $primaryKey = "id";
    protected $table = "genres";

    public function movies()
    {
        return $this->belongsTo('App\Models\Movie', 'genreId', 'id');
    }
}
