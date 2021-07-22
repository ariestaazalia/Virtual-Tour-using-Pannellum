<!-- Data Scene -->
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
                            <label for="title">Judul Scene</label>
                            <input class="form-control form-control-lg input-rounded mb-4" type="text" name="title" required>
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg input-rounded mb-4" type="hidden" name="type" value="equirectangular">
                        </div>

                        <div class="form-group">
                            <label for="hfov">Hfov</label>
                            <input class="form-control form-control-lg input-rounded mb-4" type="number" step="0.1" name="hfov" min="-360" max="360" value="100" required>
                        </div>

                        <div class="form-group">
                            <label for="yaw">Yaw</label>
                            <input class="form-control form-control-lg input-rounded mb-4" type="number" step="0.1" name="yaw" min="-360" max="360" value="0" required>
                        </div>

                        <div class="form-group">
                            <label for="pitch">Pitch</label>
                            <input class="form-control form-control-lg input-rounded mb-4" type="number" step="0.1" name="pitch" min="-360" max="360" value="0" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar</label>
                            <img class="card-img-top img-fluid" id="image-preview" alt="Image Preview"/>
                            <div class="custom-file">
                                <input type="file" class="form-control-file" id="image-upload" name="image" required onchange="previewImage()" accept="image/*">
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

<div class="table-responsive" style="width:100%">
    <table class="table table-hover progress-table text-center sceneTable" style="width:100%">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama</th>
                <th scope="col">Gambar</th>
                <th scope="col">Scene Utama</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->

@foreach($scene as $item)
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
                <h5>Info {{$item->title}}</h5><br>

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
                        <label for="title" class="d-flex justify-content-left">Judul Scene</label>
                        <input class="form-control form-control-lg input-rounded mb-4" type="text" name="title" required value="{{$item->title}}">
                    </div>

                    <div class="form-group">
                        <input class="form-control form-control-lg input-rounded mb-4" type="hidden" name="type" value="{{$item->type}}">
                    </div>

                    <div class="form-group">
                        <label for="hfov" class=" d-flex justify-content-left">Hfov</label>
                        <input class="form-control form-control-lg input-rounded mb-4" type="number" step="0.1" name="hfov" min="-360" max="360" value="{{$item->hfov}}" required>
                    </div>

                    <div class="form-group">
                        <label for="yaw" class=" d-flex justify-content-left">Yaw</label>
                        <input class="form-control form-control-lg input-rounded mb-4" type="number" step="0.1" name="yaw" min="-360" max="360" value="{{$item->yaw}}" required>
                    </div>

                    <div class="form-group">
                        <label for="pitch" class=" d-flex justify-content-left">Pitch</label>
                        <input class="form-control form-control-lg input-rounded mb-4" type="number" step="0.1" name="pitch" min="-360" max="360" value="{{$item->pitch}}" required>
                    </div>

                    <div class="form-group">
                        <label for="image" class=" d-flex justify-content-left">Image</label>
                        <img class="card-img-top img-fluid" src="{{asset('/img/uploads/' . $item->image)}}">
                        <div class="custom-file">
                            <input type="file" class="form-control-file" name="image" accept="image/*">
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

<!-- Delete Modal -->
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
                <p class="text-center">Apakah Anda Yakin Ingin Menghapus Data Ini? </p>
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
@endforeach