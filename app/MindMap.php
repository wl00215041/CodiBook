<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MindMap extends Model
{
    protected $table = 'mind_maps';
    protected $fillable = [
        'name',
        'description',
        'mindmap',
        'style',
        'is_public'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
