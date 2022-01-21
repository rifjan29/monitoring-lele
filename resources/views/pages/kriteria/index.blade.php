@extends('layouts.template')
@section('sidebar')
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">Monitoring Lele</span>
        </a>
        <ul class="sidebar-nav">
            @if (Route::has('login'))
                @auth
                    <li class="sidebar-header">
                        Pages
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('dashboard') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) == 'kriteria' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('kriteria.index') }}">
                        <i class="align-middle" data-feather="file-plus"></i> <span class="align-middle">Kriteria</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('aturan.index') }}">
                            <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Aturan</span>
                        </a>
                    </li>
                @endauth
            @endif
        </ul>
    </div>
</nav>

@endsection
@push('css')
    <!-- bootstrap5 dataTables css cdn -->
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css"
    />
@endpush
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Kriteria Data</h1>
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{session('status')}}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{session('error')}}
                </div>
            @endif
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">

            </div>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                <strong>Success!</strong> Kriteria was updated successfully.
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Tambah Data
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kriteria.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label for="nm_kriteria" class="form-label">Nama Kriteria</label>
                                            <input type="text" name="nm_kriteria" id="" class="form-control @error('nm_kriteria') is_invalid @enderror" autofocus>
                                            @error('nm_kriteria')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nl_bawah" class="form-label">Nilai Bawah</label>
                                            <input type="number" name="nl_bawah" class="form-control @error('nl_bawah') is_invalid @enderror " id="" aria-describedby="emailHelp" autofocus>
                                            @error('nl_bawah')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror

                                            {{-- <div id="emailHelp" class="form-text">We'll nev    er share your email with anyone else.</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nl_tengah" class="form-label">Nilai Tengah</label>
                                            <input type="number" name="nl_tengah" class="form-control @error('nl_tengah') is_invalid @enderror " id="" aria-describedby="emailHelp">
                                            @error('nl_tengah')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                            {{-- <div id="emailHelp" class="form-text">We'll nev    er share your email with anyone else.</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nl_atas" class="form-label">Nilai Atas</label>
                                            <input type="number" name="nl_atas" class="form-control @error('nl_atas') is_invalid @enderror " id="" aria-describedby="emailHelp">
                                            @error('nl_atas')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                            {{-- <div id="emailHelp" class="form-text">We'll nev    er share your email with anyone else.</div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nm_bawah" class="form-label">Nama Bawah</label>
                                            <input type="text" name="nm_bawah" class="form-control @error('nm_bawah') is_invalid @enderror " id="nm_bawah" aria-describedby="emailHelp" autofocus>
                                            @error('nm_bawah')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                            {{-- <div id="emailHelp" class="form-text">We'll nev    er share your email with anyone else.</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nm_tengah" class="form-label">Nama Tengah</label>
                                            <input type="text" name="nm_tengah" class="form-control @error('nm_tengah') is_invalid @enderror " id="nm_tengah" aria-describedby="emailHelp">
                                            @error('nm_tengah')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                            {{-- <div id="emailHelp" class="form-text">We'll nev    er share your email with anyone else.</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nm_atas" class="form-label">nama Atas</label>
                                            <input type="text" name="nm_atas" class="form-control @error('nm_atas') is_invalid @enderror " id="nm_atas" aria-describedby="emailHelp">
                                            @error('nm_atas')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                            {{-- <div id="emailHelp" class="form-text">We'll nev    er share your email with anyone else.</div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data Aturan</h5>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>nama kriteria</th>
                                    <th>nilai bawah</th>
                                    <th>nilai tengah</th>
                                    <th>nilai atas</th>
                                    <th>nama bawah</th>
                                    <th>nama tengah</th>
                                    <th>nama atas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Edit Kriteria Modal -->
<div class="modal" id="ArtikelModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Kriteria Edit</h4>
                <button type="button" class="btn-close modelClose" data-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="ArtikelModalBody">

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditArticleForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end Edit Kriteria Modal -->

<!-- Delete Article Modal -->
<div class="modal" id="deleteKriteria">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Kriteria Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this Kriteria?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteKriteriaForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Article Modal -->

</main>
@endsection
@push('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // isi();
        $('#example').DataTable({
            paging: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url:"{{ route('kriteria.index') }}"
            },
            columns:
            [
                {
                    "data": null, "sortable": false,
                    render : function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {data: 'nama_kriteria', name: 'nama_kriteria'},
                {data: 'nilai_bawah', name: 'nilai_bawah'},
                {data: 'nilai_tengah', name: 'nilai_tengah'},
                {data: 'nilai_atas', name: 'nilai_atas'},
                {data: 'nama_bawah', name: 'nama_bawah'},
                {data: 'nama_tengah', name: 'nama_tengah'},
                {data: 'nama_atas', name: 'nama_atas'},
                {data: 'Action', name: 'Action',orderable:false,serachable:false,sClass:'text-center'},
            ],
            order: [[0, 'desc']]
        });
            // get single edit kriteria
        $('.modelClose').on('click',function() {
            $('#ArtikelModal').hide();
        });
        var id;
        $('body').on('click', '#getEditKriteriaData', function (e) {
            $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "kriteria/"+id+"/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function(result) {
                        $('#ArtikelModalBody').html(result.html);
                        $('#ArtikelModal').show();
                    }
            });
        });
        // update artikel request
        $('#SubmitEditArticleForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "kriteria/"+id ,
                method: 'PUT',
                data: {
                    nama_kriteria: $('#id_nama_kriteria').val(),
                    nilai_bawah: $('#id_nilai_bawah').val(),
                    nilai_tengah: $('#id_nilai_tengah').val(),
                    nilai_atas: $('#id_nilai_atas').val(),
                    nama_bawah: $('#id_nama_bawah').val(),
                    nama_tengah: $('#id_nama_tengah').val(),
                    nama_atas: $('#id_nama_atas').val(),


                },
                success: function(result) {
                    // console.log(data);
                    if (result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('#example').DataTable().ajax.reload();
                        // setInterval(() => {
                            // }, 2000);
                        // var refreshIntervalId = setInterval($('#EditArticleModal').hide(), 10000);
                        setInterval(function(){
                            $('.alert-success').hide();
                        }, 2000);
                        $('#ArtikelModal').hide();
                    }
                }
            });
        });

        // delete data ajax
        var deleteID;
        $('body').on('click','#getDeleteId', function() {
            deleteID = $(this).data('id');
            $('#deleteKriteria').show();
            // console.log(deleteID);
        })
        $('#SubmitDeleteKriteriaForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "kriteria/"+id,
                method: 'DELETE',
                success: function(result) {
                    $('#example').DataTable().ajax.reload();
                    $('#deleteKriteria').hide();
                }
            });
        });
    });

</script>
@endpush
