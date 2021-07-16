@extends('admin.main')

@section('title', 'Ubah Profil')

@section('content')
@if ($message = Session::get('success'))
    <div class="alert-dismiss">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span class="fa fa-times"></span>
            </button>
        </div>
    </div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert-dismiss">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $error }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span class="fa fa-times"></span>
            </button>
        </div>
    </div>
    @endforeach
@endif

<div class="container rounded bg-white mt-5">
    <div class="row">
        <div class="col-md-1">
            <div class="d-flex flex-colu mn align-items-center text-center p-3 py-5">
                
            </div>
        </div>
        <div class="col-md-10">
            <div class="p-3 py-5">
                <h3>Kelola Akun Anda</h3>
                <br><br>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex flex-row align-items-center back"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
                        <a href="javascript:history.back()">Kembali</a>
                    </div>
                </div>
                @foreach ($user as $item)
                <form method="POST" action="{{ route('editProfil', ['id' => $item->id]) }}">
                    @csrf 
                    @method('PUT')

                    <div>
                        <br><label for="name">Nama Lengkap</label><br>
                        <div class="col-md-8"><input type="text" class="form-control" name="name" value="{{$item->name}}" required></div>
                    </div><br>
                    <div>
                        <label for="username">Username</label><br>
                        <div class="col-md-8"><input type="text" class="form-control" name="username" value="{{$item->username}}" required></div>
                    </div><br>
                    <div>
                    <div class="mt-5 text-right">
                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#deleteProfil{{$item['id']}}">Hapus Akun</a>
                        <button class="btn btn-primary profile-button"type="submit">Ubah</button>
                    </div>
                </form> 

                {{-- Delete Scene Modal --}}
                <div id="deleteProfil{{$item['id']}}" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-confirm">
                        <div class="modal-content">
                            <div class="modal-header flex-column"> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <div class="icon-box">
                                    <i class="fa fa-times-circle"></i>
                                </div>						
                            </div>
                            <div class="modal-body">
                                <center><p>Apakah Anda Yakin ingin Menghapus Data ini? </p></center>
                                <form method="POST" action="{{ route('delProfil', ['id' => $item->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach       
            </div>
        </div>
    </div>
</div>
@endsection