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
                        <ul class="nav" role="tablist">
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
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="number" id="hfov" name="hfov" min="-360" max="360" value="100" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="yaw">Yaw</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="number" id="yaw" name="yaw" min="0" max="180" value="0" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="pitch">Pitch</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" type="number" id="pitch" name="pitch" min="0" max="180" value="0" required>
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
                                <table class="table table-hover progress-table text-center">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Scene Utama</th>
                                            <th scope="col">Aksi</th>
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
                                                                        <h5 class="modal-title">Edit {{$item->title}}</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('editScene', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data"> 
                                                                            @csrf
                                                                            @method('PUT')

                                                                            <div class="form-group">
                                                                                <label for="title" class="d-flex justify-content-left">Judul Scene</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="text" id="title" name="title" required value="{{$item->title}}" onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="hidden" id="type" name="type" value="{{$item->type}}" onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="hfov" class=" d-flex justify-content-left">Hfov</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="number" id="hfov" name="hfov" min="-360" max="360" value="{{$item->hfov}}" required onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="yaw" class=" d-flex justify-content-left">Yaw</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="number" id="yaw" name="yaw" min="0" max="180" value="{{$item->yaw}}" required onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="pitch" class=" d-flex justify-content-left">Pitch</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" type="number" id="pitch" name="pitch" min="0" max="180" value="{{$item->pitch}}" required onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="image" class=" d-flex justify-content-left">Image</label>
                                                                                <img class="card-img-top img-fluid" src="{{asset('/img/uploads/' . $item->image)}}">
                                                                                <div class="custom-file">
                                                                                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*" onchange="showButton()">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                                                <button type="submit" id="show" class="btn btn-primary">Simpan</button>
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
                                                                        <div class="icon-box">
                                                                            <i class="fa fa-times-circle"></i>
                                                                        </div>							
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                                                        <label for="scene">Target ID</label>
                                                        <select class="form-control form-control-lg input-rounded mb-4" name="scene" required>
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
                                                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="yaw" name="yaw" min="0" max="180" value="0">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="pitch">Pitch</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="pitch" name="pitch" min="0" max="180" value="0">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="targetYaw">Target Yaw</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="targetYaw" name="targetYaw" min="0" max="180" value="0">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="targetPitch">Target Pitch</label>
                                                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="targetPitch" name="targetPitch" min="0" max="180" value="0">
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
                                <table class="table table-hover progress-table text-center">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Target Scene</th>
                                            <th scope="col">Tipe</th>
                                            <th scope="col">Info</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $num = 1; @endphp
                                        @foreach ($hotspot as $item)
                                            <tr>
                                                <th scope="row">{{$num++}}</th>
                                                <td>{{$item->scene->title}}</td>
                                                <td>{{$item->type}}</td>
                                                <td>{{$item->info}}</td>
                                                <td>
                                                    <ul class="d-flex justify-content-center">
                                                        <!-- Detail -->
                                                        <li class="mr-3"><a href="#" class="text-info" data-toggle="modal" data-target="#detailHotspot{{$item['id']}}" ><i class="fa fa-eye"></i></a></li>
                                                        <!-- Detail Modal -->
                                                        <div class="modal fade" id="detailHotspot{{$item['id']}}">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">{{$item->title}}</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h5>Info Hotspot</h5><br>

                                                                        <p class="d-flex justify-content-left"><b>Tipe: </b> {{ $item->type}} </p><br>

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
                                                        <li class="mr-3"><a href="#" class="text-success" data-toggle="modal" data-target="#editModal2{{$item['id']}}"><i class="fa fa-edit"></i></a></li>
                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editModal2{{$item['id']}}">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"> Edit Hotspot {{$item->scene->title}}</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="POST" action="{{ route('editHotspot', ['id' => $item->id]) }}"> 
                                                                            @csrf
                                                                            @method('PUT')
                                                                            
                                                                            <div class="form-group">
                                                                                <label for="scene" class="d-flex justify-content-left">Target ID</label>
                                                                                <select class="form-control form-control-lg input-rounded mb-4" name="scene" required onchange="showButton()">
                                                                                    <option value="" disabled>Pilih Salah Satu </option>
                                                                                    @foreach ($scene as $scenes)
                                                                                        @if ($item->sceneID == $scenes->id)
                                                                                            <option value="{{$item->sceneID}}" selected> {{$scenes->title}}</option>
                                                                                        @else
                                                                                            <option value="{{$scenes->id}}"> {{$scenes->title}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            
                                                                            <div class="form-group">
                                                                                <label for="type" class="d-flex justify-content-left">Tipe</label>
                                                                                <select class="form-control form-control-lg input-rounded mb-4" name="type" required onchange="showButton()">
                                                                                    <option value="" disabled>Pilih Salah Satu </option>
                                                                                    <option value="info" @if (old('type') == "info") {{ 'selected' }} @endif>Info</option>
						                                                            <option value="scene" @if (old('type') == "scene") {{ 'selected' }} @endif>Penghubung</option>
                                                                                </select>
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="yaw" class="d-flex justify-content-left">Yaw</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="yaw" name="yaw" min="0" max="180" value="{{$item->yaw}}" onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="pitch" class="d-flex justify-content-left">Pitch</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="pitch" name="pitch" min="0" max="180" value="{{$item->pitch}}" onchange="showButton()">
                                                                            </div>
                                                                            
                                                                            <div class="form-group">
                                                                                <label for="targetYaw" class="d-flex justify-content-left">Target Yaw</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="targetYaw" name="targetYaw" min="0" max="180" value="{{$item->targetYaw}}" onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="targetPitch" class="d-flex justify-content-left">Target Pitch</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" required type="number" id="targetPitch" name="targetPitch" min="0" max="180" value="{{$item->targetPitch}}" onchange="showButton()">
                                                                            </div>
                        
                                                                            <div class="form-group">
                                                                                <label for="text" class="d-flex justify-content-left">Text</label>
                                                                                <input class="form-control form-control-lg input-rounded mb-4" required type="text" id="text" name="text" value="{{$item->info}}" onchange="showButton()">
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                                                <button type="submit" id="show" class="btn btn-primary" disabled>Simpan</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <!-- Delete -->
                                                        <li><a href="#" class="text-danger" data-toggle="modal" data-target="#deleteModal2{{$item['id']}}"><i class="ti-trash"></i></a></li>

                                                        {{-- Delete Hotspot Modal --}}
                                                        <div id="deleteModal2{{$item['id']}}" class="modal fade">
                                                            <div class="modal-dialog modal-dialog-centered modal-confirm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header flex-column">
                                                                        <div class="icon-box">
                                                                            <i class="fa fa-times-circle"></i>
                                                                        </div>							
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah Anda Yakin Ingin Menghapus Data Ini? </p>
                                                                        <form method="POST" action="{{ route('delHotspot', ['id' => $item->id]) }}">
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
    <!-- trading history area end -->
</div>
@endsection

@push('script')
    <script> 
        function previewImage() {
            document.getElementById("image-preview").style.display = "block";
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("image").files[0]);
        
            oFReader.onload = function(oFREvent) {
                document.getElementById("image-preview").src = oFREvent.target.result;
            };
        };
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("input:checkbox").change(function(){
                var getId = $(this).attr("id");
                $(this).find('input[name="check"]:not(:checked)').prop('checked', true).val(0);
                $("#status"+getId).submit();
            });
        });
    </script>
@endpush