<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;

class HotspotController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'scene' => 'required',
            'type' => 'required',
            'yaw' => 'required',
            'pitch' => 'required',
            'targetYaw' => 'required',
            'targetPitch' => 'required',
            'text' => 'required'
        ]);
        
        Hotspot::create([
            'type' => $request['type'],
            'yaw' => $request['yaw'],
            'pitch' => $request['pitch'],
            'targetYaw' => $request['targetYaw'],
            'targetPitch' => $request['targetPitch'],
            'info' => $request['text'],
            'sceneID' => $request['scene']
        ]);
        
        return redirect()->route('scene')->with('success', 'Hotspot Berhasil Ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'scene' => 'required',
            'type' => 'required',
            'yaw' => 'required',
            'pitch' => 'required',
            'targetYaw' => 'required',
            'targetPitch' => 'required',
            'text' => 'required'
        ]);

        Hotspot::where('id', $id)->update([
            'type' => $request['type'],
            'yaw' => $request['yaw'],
            'pitch' => $request['pitch'],
            'targetYaw' => $request['targetYaw'],
            'targetPitch' => $request['targetPitch'],
            'info' => $request['text'],
            'sceneID' => $request['scene']
        ]);
        
        return redirect()->route('scene')->with(['success' => 'Hotspot Berhasil Diubah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotspot = Hotspot::find($id);
        return view('/scene', compact('hotspot', 'id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hotspot::destroy($id);
        return redirect()->route('scene')->with('success','Hotspot Berhasil Dihapus');
    }
}
