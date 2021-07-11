<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.changepass');
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
            'passwordLama' => ['required', new MatchOldPassword],
            'passwordBaru' => ['required'],
            'konfirmasiPasswordBaru' => ['same:passwordBaru'],
        ]);

        $update= User::find(Auth::user()->id)->update(['password'=> Hash::make($request->passwordBaru)]);
        if($update){
            return redirect()->route('ubahPassword')->with('success','Anda Berhasil Mengubah Password');
        }else{
            return redirect()->route('ubahPassword')->with('error','Password Gagal Diubah');
        }
        
    }
}
