<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    protected $table = 'hotspots';
    protected $fillable = [
        'title', 'type', 'yaw', 'pitch', 'targetYaw', 'targetPitch',  'info', 'sceneID'
    ];

    public function scene()
    {
        return $this->belongsTo('App\Scene', 'sceneID');
    }
}
