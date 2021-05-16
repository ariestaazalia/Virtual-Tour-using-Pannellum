<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    protected $table = 'scenes';

    protected $fillable = [
        'title', 'type', 'hfov', 'yaw', 'pitch', 'image', 'status'
    ];
    
    public function hotspots()
    {
        return $this->hasMany('App\Hotspot', 'sourceScene');
    }
}
