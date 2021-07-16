@extends('admin.main')

@section('title', 'Dashboard')

@section('content')
    @if ($message = Session::has('success'))
        <div class="alert-dismiss">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span class="fa fa-times"></span>
                </button>
            </div>
        </div> 
    @endif
       
    <div class="row">
        <div class="col-md-6">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-map"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h3 class="header-title mb-0">Jumlah Scene</h3>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2> {{ $jumlahScene->count() }} </h2>
                    </div>
                </div>
                <canvas height="50"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-map-marker"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h3 class="header-title mb-0">Jumlah Hotspot</h3>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{ $jumlahHotspot->count() }}</h2>
                    </div>
                </div>
                <canvas height="50"></canvas>
            </div>
        </div>
    </div>
@endsection