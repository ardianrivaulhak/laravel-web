<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    protected $primaryKey = "id";
    protected $table = "genres";

    public function movies()
    {
        return $this->belongsTo('App\Models\Hris\Movie', 'genreId', 'id');
    }
}
