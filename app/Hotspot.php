<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    protected $table = 'hotspots';
    protected $fillable = [
        'title', 'type', 'yaw', 'pitch', 'info', 'sourceScene', 'targetScene'
    ];

    public function scene()
    {
        return $this->belongsTo('App\Scene', 'sourceScene');
    }

    public function targetScene()
    {
        return $this->belongsTo('App\Scene', 'targetScene');
    }
}
