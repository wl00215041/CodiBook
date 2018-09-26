<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = [
        'name',
        'description',
        'markdown',
        'is_public'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
