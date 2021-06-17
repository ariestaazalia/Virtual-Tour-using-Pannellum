<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scene;
use App\Hotspot;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlahScene = Scene::all();
        $jumlahHotspot = Hotspot::all();

        return view('admin.index', compact('jumlahScene', 'jumlahHotspot'))->with(['success' => 'Selamat Datang di Dashboard Virtual Tour Fakultas Teknik Universitas Jenderal Soedirman']);
    }
}
