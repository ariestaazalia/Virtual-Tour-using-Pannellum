<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Scene;
use App\Hotspot;
use Datatables;

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
        return view('admin.config', compact('hotspots', 'scene'));
    }

    public function dataScene(Request $request){
        if ($request->ajax()) {
            $data = Scene::select('*');
            return Datatables::of($data)
                ->addColumn('status', function ($row){
                    $sendData = route('changeFScene', $row->id);
                    $csrf = csrf_token();
                    if ($row->status !=0)
                        return '<form method="post" id="status'. $row->id.'" action='.$sendData.'>
                                    <input name="_token" type="hidden" value='.$csrf.'>
                                    <input name="_method" type="hidden" value="PUT">
                                    <input type="checkbox" id="'. $row->id.'" name="check" checked value="1"/>
                                </form>';
                    else 
                        return '<form method="post" id="status'. $row->id.'" action='.$sendData.'>
                                    <input name="_token" type="hidden" value='.$csrf.'>
                                    <input name="_method" type="hidden" value="PUT">            
                                    <input type="checkbox" id="'. $row->id.'" name="check" value="1"/>
                                </form>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="#" class="text-success" data-toggle="modal" 
                        data-target="#detailScene'. $row->id.'"><i class="fa fa-eye"></i></a>
                            <a href="#" class="text-info" data-toggle="modal" 
                        data-target="#editModal' . $row->id . '"><i class="fa fa-edit"></i></a>
                            <a href="#" class="text-danger" data-toggle="modal" 
                        data-target="#deleteModal'. $row->id .'"><i class="ti-trash"></i></a>';
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function dataHotspot(){
        $hotspots = DB::table('hotspots')->join('scenes as sc1', 'hotspots.sourceScene', '=', 'sc1.id')
                        ->join('scenes as sc2', 'hotspots.targetScene', '=', 'sc2.id')
                        -> select('sc1.title as sourceSceneName', 'sc2.title as targetSceneName', 'hotspots.*');

        return Datatables::of($hotspots)
            ->addColumn('action', function ($row) {
                return '<a href="#" class="text-success" data-toggle="modal" 
                    data-target="#detailHotspot'. $row->id.'"><i class="fa fa-eye"></i></a>
                        <a href="#" class="text-info" data-toggle="modal" 
                    data-target="#editHotspot' . $row->id . '"><i class="fa fa-edit"></i></a>
                        <a href="#" class="text-danger" data-toggle="modal" 
                    data-target="#deleteHotspot'. $row->id .'"><i class="ti-trash"></i></a>';
                })
            ->make(true);
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
            'hfov' => 'required|min:-360|max:360',
            'yaw' => 'required|min:-360|max:360',
            'pitch' => 'required|min:-360|max:360',
            'image' => 'required|image'
        ]);

        $file = $request->file('image');
        $extension = $file->extension();
        $file_name = time() . '.' . $extension;
        $file->move(public_path('img/uploads'), $file_name);
        
        Scene::create([
            'title' => $request['title'],
            'type' => $request['type'],
            'hfov' => $request['hfov'],
            'yaw' => $request['yaw'],
            'pitch' => $request['pitch'],
            'image' => $file_name
        ]);
        
        return redirect()->route('config')->with('success', 'Scene Berhasil Ditambahkan');
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

        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'hfov' => 'required|min:-360|max:360',
            'yaw' => 'required|min:-360|max:360',
            'pitch' => 'required|min:-360|max:360',
            'image' => 'image'
        ]);

        $file = $request->file('image');
        if ($file == '') {
            $file_name=$scene->image;
        } else {
            $extension = $file->extension();
            $file_name = time() . '.' . $extension;
            $file->move(public_path('img/uploads'), $file_name);
        }

        Scene::where('id',$id)->update([
            'title' => $request['title'],
            'type' => $request['type'],
            'hfov' => $request['hfov'],
            'yaw' => $request['yaw'],
            'pitch' => $request['pitch'],
            'image' => $file_name
        ]);
        
        return redirect()->route('config')->with('success', 'Scene Berhasil Diubah');
    }

    public function status(Request $request, $id){
    
        $scene = Scene::find($id);
        $updated = Scene::where('id',$id)->update([
            'status' => $request['check']
        ]);

        return redirect()->route('config')->with('success', 'Scene Utama Berhasil Diubah');
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
