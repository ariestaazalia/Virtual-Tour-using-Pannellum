@extends('admin.main')

@section('title', 'Konfigurasi Virtual Tour')

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

@if ($message = Session::get('error'))
    <div class="alert-dismiss">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span class="fa fa-times"></span>
            </button>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-lg-12 mt-sm-30 mt-xs-30">
        <div class="card">
            <div class="card-body">
                <!-- Tab -->
                <div class="d-flex justify-content-center">
                    <div class="trd-history-tabs">
                        <ul class="nav" role="tablist" id="TabMenu">
                            <li>
                                <a class="active" data-toggle="tab" href="#scene" role="tab">Scene</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#hotspot" role="tab">Hotspot</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Scene Tab -->
                <div class="trad-history mt-4" >
                    <div class="tab-content" id="myTabContent" >
                        <div class="tab-pane fade show active" id="scene" role="tabpanel">
                            <div class="d-flex justify-content-end">
                                <!-- Add Scene -->
                                <button type="button" class="btn btn-rounded btn-outline-info mb-3" data-toggle="modal" data-target="#addScene">Tambah Scene</button>
                                <div class="modal fade" id="addScene">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Scene</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('addScene') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="title">Judul Scene</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="text" id="title" name="title" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="hidden" id="type" name="type" value="equirectangular">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="hfov">Hfov</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="number" id="hfov" step="0.1" name="hfov" min="-360" max="360" value="100" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="yaw">Yaw</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="number" id="yaw" step="0.1" name="yaw" min="0" max="180" value="0" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="pitch">Pitch</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="number" id="pitch" step="0.1" name="pitch" min="0" max="180" value="0" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="image">Gambar</label>
                                                        <img class="card-img-top img-fluid" id="image-preview" alt="Image Preview"/>
                                                        <div class="custom-file">
                                                            <input type="file" class="form-control-file" id="image" name="image" required onchange="previewImage()" accept="image/*">
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Scene -->
                            <div class="table-responsive">
                                <table class="table table-hover progress-table text-center conf" id="">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col" data-sort-method='none'>Gambar</th>
                                            <th scope="col" data-sort-method='none'>Scene Utama</th>
                                            <th scope="col" data-sort-method='none'>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $num= 1;
                                        @endphp
                                        @foreach($scene as $item)
                                            <tr>
                                                <th scope="row">{{$num++}}</th>
                                                <td>{{$item->title}}</td>
                                                <td><img style="height: 70px" src="{{asset('/img/uploads/' . $item->image)}}"></td>
                                                <td> 
                                                    <form method="post" id="status{{$item['id']}}" action=" {{ url('/setFScene/' . $item->id) }} ">
                                                        @csrf 
                                                        @method('PUT')

                                                        @if ($item->status !=0)
                                                            <input type="checkbox" id="{{$item->id}}" name="check" checked value="1" />
                                                        @else
                                                            <input type="checkbox" id="{{$item->id}}" name="check" value="1" />
                                                        @endif
                                                    </form>
                                                </td>
                                                <td>
                                                    <ul class="d-flex justify-content-center">
                                                        <!-- Detail -->
                                                        <li class="mr-3"><a href="#" class="text-info" data-toggle="modal" data-target="#detailScene{{$item['id']}}" ><i class="fa fa-eye"></i></a></li>
                                                        <!-- Detail Modal -->
                                                        <div class="modal fade" id="detailScene{{$item['id']}}">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">{{$item->title}}</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <img class="card-img-top img-fluid" src="{{asset('/img/uploads/' . $item->image)}}">
                                                                        <br> <br> <hr>
                                                                        <h5>Info Panorama</h5><br>

                                                                        <p class="d-flex justify-content-left"><b> Tipe: </b> {{ $item->type}} </p><br>

                                                                        <p class="d-flex justify-content-left"> 
                                                                            <b> Hfov: </b> {{$item->hfov}} 
                                                                        </p><br>

                                                                        <p class="d-flex justify-content-left"> 
                                                                            <b> Yaw: </b> {{$item->yaw}}
                                                                        </p><br>

                                                                        <p class="d-flex justify-content-left"> 
                                                                            <b> Pitch: </b> {{$item->pitch}} 
                                                                        </p><br>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Edit -->
                                                        <li class="mr-3"><a href="#" class="text-success" data-toggle="modal" data-target="#editModal{{$item['id']}}"><i class="fa fa-edit"></i></a></li>
                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editModal{{$item['id']}}">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Ubah {{$item->title}}</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('editScene', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data"> 
                                                                            @csrf
                                                                            @method('PUT')

                                                                            <div class="form-group">
                                                                                <label for="title" class="d-flex justify-content-left">Judul Scene</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="text" id="title" name="title" required value="{{$item->title}}">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="hidden" id="type" name="type" value="{{$item->type}}">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="hfov" class=" d-flex justify-content-left">Hfov</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="number" id="hfov" name="hfov" min="-360" max="360" value="{{$item->hfov}}" required>
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="yaw" class=" d-flex justify-content-left">Yaw</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="number" id="yaw" name="yaw" min="0" max="180" value="{{$item->yaw}}" required>
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="pitch" class=" d-flex justify-content-left">Pitch</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="number" id="pitch" name="pitch" min="0" max="180" value="{{$item->pitch}}" required>
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="image" class=" d-flex justify-content-left">Image</label>
                                                                                <img class="card-img-top img-fluid" src="{{asset('/img/uploads/' . $item->image)}}">
                                                                                <div class="custom-file">
                                                                                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Delete -->
                                                        <li><a href="#" class="text-danger" data-toggle="modal" data-target="#deleteModal{{$item['id']}}"><i class="ti-trash"></i></a></li>

                                                        {{-- Delete Scene Modal --}}
                                                        <div id="deleteModal{{$item['id']}}" class="modal fade">
                                                            <div class="modal-dialog modal-dialog-centered modal-confirm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header flex-column">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <div class="icon-box">
                                                                            <i class="fa fa-times-circle"></i>
                                                                        </div>	
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah Anda Yakin Ingin Menghapus Data Ini? </p>
                                                                        <form method="POST" action="{{ route('delScene', ['id' => $item->id]) }}">
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
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="hotspot" role="tabpanel">
                            <div class="d-flex justify-content-end">
                                <!-- Add Hotspot -->
                                <button type="button" class="btn btn-rounded btn-outline-info mb-3" data-toggle="modal" data-target="#addHotspot">Tambah Hotspot</button>
                                <div class="modal fade" id="addHotspot">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Hotspot</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>

                                            <div class="modal-body">
                                                <form action="{{ route('addHotspot') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="sourceScene">Asal Scene</label>
                                                        <select class="form-control form-control-lg input-rounded mb-4" name="sourceScene" required>
                                                            <option value="" disabled selected>Pilih Salah Satu </option>
                                                            @foreach ($scene as $item)
                                                                <option value="{{$item->id}}">
                                                                    {{$item->title}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="scene">Target Scene</label>
                                                        <select class="form-control form-control-lg input-rounded mb-4" name="targetScene" required>
                                                            <option value="" disabled selected>Pilih Salah Satu </option>
                                                            @foreach ($scene as $item)
                                                                <option value="{{$item->id}}">
                                                                    {{$item->title}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="type">Tipe</label>
                                                        <select class="form-control form-control-lg input-rounded mb-4" name="type" required>
                                                            <option value="" disabled selected>Choose One </option>
                                                            <option value="info">Info</option>
                                                            <option value="scene">Penghubung</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="yaw">Yaw</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" step="0.1" id="yaw" name="yaw" min="-360" max="360" value="0">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="pitch">Pitch</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" step="0.1" id="pitch" name="pitch" min="-360" max="360" value="0">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="text">Informasi</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" required type="text" id="text" name="text">
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Hotspot -->
                            <div class="table-responsive">
                                <table class="table table-hover progress-table text-center conf" id="">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Asal Scene</th>
                                            <th scope="col">Target Scene</th>
                                            <th scope="col">Tipe</th>
                                            <th scope="col">Info</th>
                                            <th scope="col" data-sort-method='none'>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $num= 1;
                                        @endphp
                                        @foreach ($hotspots as $hotspot)
                                            <tr>
                                                <th scope="row">{{$num++}}</th>
                                                @foreach ($scene as $scenes)
                                                    @if ($hotspot->sourceScene == $scenes->id)
                                                        <td>{{$scenes->title}}</td>
                                                    @endif
                                                @endforeach

                                                @foreach ($scene as $scenes)
                                                    @if ($hotspot->targetScene == $scenes->id)
                                                        <td>{{$scenes->title}}</td>
                                                    @endif
                                                @endforeach

                                                <td>{{$hotspot->type}}</td>
                                                <td>{{$hotspot->info}}</td>
                                                <td>
                                                    <ul class="d-flex justify-content-center">
                                                        <!-- Detail -->
                                                        <li class="mr-3"><a href="#" class="text-info" data-toggle="modal" data-target="#detailHotspot{{$hotspot['id']}}" ><i class="fa fa-eye"></i></a></li>
                                                        <!-- Detail Modal -->
                                                        <div class="modal fade" id="detailHotspot{{$hotspot['id']}}">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">{{$hotspot->title}}</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h5>Info Hotspot</h5><br>

                                                                        <p class="d-flex justify-content-left">
                                                                            <b>Tipe: </b> {{ $hotspot->type}} 
                                                                        </p><br>

                                                                        <p class="d-flex justify-content-left"> 
                                                                            <b> Yaw: </b> {{$hotspot->yaw}}
                                                                        </p><br>

                                                                        <p class="d-flex justify-content-left"> 
                                                                            <b> Pitch: </b> {{$hotspot->pitch}} 
                                                                        </p><br>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <!-- Edit -->
                                                        <li class="mr-3"><a href="#" class="text-success" data-toggle="modal" data-target="#editHotspot{{$hotspot['id']}}"><i class="fa fa-edit"></i></a></li>
                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editHotspot{{$hotspot['id']}}">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"> Ubah Hotspot </h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="POST" action="{{ route('editHotspot', ['id' => $hotspot->id]) }}"> 
                                                                            @csrf
                                                                            @method('PUT')
                                                                            
                                                                            <div class="form-group">
                                                                                <label for="sourceScene" class="d-flex justify-content-left">Asal Scene</label>
                                                                                <select class="form-control form-control-lg input-rounded mb-4" name="sourceScene" required>
                                                                                    <option value="" disabled>Pilih Salah Satu </option>
                                                                                    @foreach ($scene as $scenes)
                                                                                        @if ($hotspot->sourceScene == $scenes->id)
                                                                                            <option value="{{$hotspot->sourceScene}}" selected> {{$scenes->title}}</option>
                                                                                        @else
                                                                                            <option value="{{$scenes->id}}"> {{$scenes->title}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="scene" class="d-flex justify-content-left">Target Scene</label>
                                                                                <select class="form-control form-control-lg input-rounded mb-4" name="targetScene" required>
                                                                                    <option value="" disabled>Pilih Salah Satu </option>
                                                                                    @foreach ($scene as $scenes)
                                                                                        @if ($hotspot->targetScene == $scenes->id)
                                                                                            <option value="{{$hotspot->targetScene}}" selected> {{$scenes->title}}</option>
                                                                                        @else
                                                                                            <option value="{{$scenes->id}}"> {{$scenes->title}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            
                                                                            <div class="form-group">
                                                                                <label for="type" class="d-flex justify-content-left">Tipe</label>
                                                                                <select class="form-control form-control-lg input-rounded mb-4" name="type" required>
                                                                                    <option value="" disabled>Pilih Salah Satu </option>
                                                                                    <option value="info" @if ($hotspot->type == "info") {{ 'selected' }} @endif>Info</option>
						                                                            <option value="scene" @if ($hotspot->type == "scene") {{ 'selected' }} @endif>Penghubung</option>
                                                                                </select>
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="yaw" class="d-flex justify-content-left">Yaw</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="yaw" name="yaw" min="-360" max="360" value="{{$hotspot->yaw}}">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="pitch" class="d-flex justify-content-left">Pitch</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="pitch" name="pitch" min="-360" max="360" value="{{$hotspot->pitch}}">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="text" class="d-flex justify-content-left">Text</label>
                                                                                <textarea class="form-control form-control-lg input-rounded mb-4" id="text" name="text" required > {{$hotspot->info}} </textarea>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <!-- Delete -->
                                                        <li><a href="#" class="text-danger" data-toggle="modal" data-target="#deleteModal2{{$hotspot['id']}}"><i class="ti-trash"></i></a></li>

                                                        {{-- Delete Hotspot Modal --}}
                                                        <div id="deleteModal2{{$hotspot['id']}}" class="modal fade">
                                                            <div class="modal-dialog modal-dialog-centered modal-confirm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header flex-column">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <div class="icon-box">
                                                                            <i class="fa fa-times-circle"></i>
                                                                        </div>							
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah Anda Yakin Ingin Menghapus Data Ini? </p>
                                                                        <form method="POST" action="{{ route('delHotspot', ['id' => $hotspot->id]) }}">
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
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

    <script>
        $(document).ready(function() {
            $('table.conf').DataTable({
                pageLength : 5,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Semua']],
                "language": {
                    "lengthMenu": "Menampilkan _MENU_ Data Per Halaman",
                    "zeroRecords": "Data Tidak Ditemukan",
                    "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Data Tidak Ditemukan",
                    "infoFiltered": "(Difitler dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "next":       "Selanjutnya",
                        "previous":   "Sebelumnya"
                    }
                }
            });
        } );
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("input:checkbox").change(function(){
                var getId = $(this).attr("id");
                if ($('input[type=checkbox]:checked').length > 1) {
                    $(this).prop('checked', false)
                    alert('Scene Utama Hanya Diperbolehkan 1')
                }else{
                    $(this).find('input[name="check"]:not(:checked)').prop('checked', true).val(0);
                    $("#status"+getId).submit();
                }
            });
        });
    </script>
@endpush