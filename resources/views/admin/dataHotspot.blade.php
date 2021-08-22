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
                            <input class="form-control form-control-lg input-rounded mb-4" required type="number" step="0.1" name="yaw" min="-360" max="360" value="0">
                        </div>

                        <div class="form-group">
                            <label for="pitch">Pitch</label>
                            <input class="form-control form-control-lg input-rounded mb-4" required type="number" step="0.1" name="pitch" min="-360" max="360" value="0">
                        </div>

                        <div class="form-group">
                            <label for="text">Informasi</label>
                            <textarea class="form-control form-control-lg input-rounded mb-4" required type="text" name="text"></textarea>
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

<div class="table-responsive" style="width:100%;">
    <table class="table table-hover progress-table text-center hotspotTable" style="width:100%">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Asal Scene</th>
                <th scope="col">Target Scene</th>
                <th scope="col">Tipe</th>
                <th scope="col">Info</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
@foreach($hotspots as $hotspot)
<!-- Detail Modal -->
<div class="modal fade" id="detailHotspot{{$hotspot['id']}}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title justify-content-">Info Hotspot</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">

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
                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" step="0.1" name="yaw" min="-360" max="360" value="{{$hotspot->yaw}}">
                    </div>

                    <div class="form-group">
                        <label for="pitch" class="d-flex justify-content-left">Pitch</label>
                        <input class="form-control form-control-lg input-rounded mb-4" required type="number" step="0.1" name="pitch" min="-360" max="360" value="{{$hotspot->pitch}}">
                    </div>

                    <div class="form-group">
                        <label for="text" class="d-flex justify-content-left">Text</label>
                        <textarea class="form-control form-control-lg input-rounded mb-4" name="text" required > {{$hotspot->info}} </textarea>
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

<!-- Delete Modal -->
<div id="deleteHotspot{{$hotspot['id']}}" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="icon-box">
                    <i class="fa fa-times-circle"></i>
                </div>							
            </div>
            <div class="modal-body">
                <p class="text-center">Apakah Anda Yakin Ingin Menghapus Data Ini? </p>
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
@endforeach