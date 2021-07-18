@extends('admin.main')

@section('title', 'Ubah Password')

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
                <h3>Ubah Password</h3>
                <br><br>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex flex-row align-items-center back"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
                        <a href="javascript:history.back()">Kembali</a>
                    </div>
                </div>
                <form method="POST" action="{{ route('changePassword') }}">
                    @csrf 

                    <div>
                        <br><label for="passwordLama">Password Lama:</label><br>
                        <div class="col-md-8"><input type="password" class="form-control" minlength="8" name="passwordLama" required></div>
                    </div><br>
                    <div>
                        <label for="passwordBaru">Password Baru:</label><br>
                        <div class="col-md-8"><input type="password" class="form-control" minlength="8" name="passwordBaru" required></div>
                    </div><br>
                    <div>
                        <label for="konfirmasiPasswordBaru">Konfirmasi Password Baru: </label><br>
                        <div class="col-md-8"><input type="password" class="form-control" minlength="8" name="konfirmasiPasswordBaru" required></div>
                    </div>
                    <div class="mt-5 text-right">
                        <button class="btn btn-primary profile-button" type="submit">Ubah</button>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>
@endsection