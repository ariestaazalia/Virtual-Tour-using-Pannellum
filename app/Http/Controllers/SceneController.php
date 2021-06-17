<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Scene;
use App\Hotspot;

class SceneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $scene = Scene::all();
        $hotspots = Hotspot::all();
        $sourceScene = DB::table('hotspots')
            ->join('scenes', 'scenes.id', '=', 'hotspots.sourceScene')
            ->select('scenes.id', 'scenes.title', 'hotspots.*')
            ->get();

        $targetScene = DB::table('hotspots')
            ->join('scenes', 'scenes.id', '=', 'hotspots.targetScene')
            ->select('scenes.id', 'scenes.title', 'hotspots.targetScene')
            ->get();
        
        return view('admin.config', compact('hotspots', 'scene', 'sourceScene', 'targetScene'));
    }

    public function pannellum() {
        $fscene= DB::table('scenes')->where('status', '1')->first();
        $scenes= DB::table('scenes')->get();
        $hotspots = DB::table('hotspots')
            ->join('scenes', 'scenes.id', '=', 'hotspots.sourceScene')
            ->select('hotspots.*')
            ->get();


        return view('welcome', compact('fscene', 'scenes', 'hotspots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'hfov' => 'required',
            'yaw' => 'required',
            'pitch' => 'required',
            'image' => 'required|image'
        ]);

        $file = $request->file('image');
        $extension = $file->extension();
        $file_name = time() . '.' . $extension;
        $file->move(public_path('img/uploads'), $file_name);
        
        $scene = Scene::create([
            'title' => $request['title'],
            'type' => $request['type'],
            'hfov' => $request['hfov'],
            'yaw' => $request['yaw'],
            'pitch' => $request['pitch'],
            'image' => $file_name
        ]);
        
        if ($scene) {
            return redirect()->route('config')->with('success', 'Scene Berhasil Ditambahkan');
        }else {
            return back()->withInput()->with(['error', 'Scene Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scene = Scene::find($id);
        return view('/scene', compact('scene', 'id'));
    }

    public function update(Request $request, $id){
        $scene = Scene::find($id); 
        $file = $request->file('image');
        if ($file == '') {
            $file_name=$scene->image;
        } else {
            $extension = $file->extension();
            $file_name = time() . '.' . $extension;
            $file->move(public_path('img/uploads'), $file_name);
        }

        $scene = Scene::where('id',$id)->update([
            'title' => $request['title'],
            'type' => $request['type'],
            'hfov' => $request['hfov'],
            'yaw' => $request['yaw'],
            'pitch' => $request['pitch'],
            'image' => $file_name
        ]);
        
        if ($scene) {
            return redirect()->route('config')->with('success', 'Scene Berhasil Diubah');
        }else {
            return back()->withInput()->with(['error', 'Scene Gagal Ditambahkan']);
        }
    }

    public function status(Request $request, $id){
    
        $scene = Scene::find($id);
        $updated = Scene::where('id',$id)->update([
            'status' => $request['check']
        ]);
        
        if ($updated) {
            return redirect()->route('config')->with('success', 'Scene Utama Berhasil Diubah');
        }else {
            return back()->withInput()->with(['error', 'Scene Utama Gagal Diubah']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Scene::destroy($id);
        return redirect()->route('config')->with('success','Scene Berhasil Dihapus');
    }
}
