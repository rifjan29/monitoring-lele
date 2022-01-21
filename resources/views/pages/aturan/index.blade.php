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
                    <li class="sidebar-item {{ Request::segment(1) == 'aturan' ? 'active' : '' }}">
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
    <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css"
    />
@endpush
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Aturan Data</h1>
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
                <strong>Success!</strong> Aturan was updated successfully.
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
                            <form action="{{ route('aturan.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label for="nm_rule" class="form-label">Nama Aturan</label>
                                            <input type="text" name="nm_rule" id="" class="form-control @error('nm_rule') is_invalid @enderror" autofocus>
                                            @error('nm_rule')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="rule_ph" class="form-label">Rule 1</label>
                                            <select class="form-select @error('rule_ph') is_invalid @enderror" name="rule_ph" aria-label="Default select example">
                                                <option value="asam">Asam</option>
                                                <option value="netral">Netral</option>
                                                <option value="basa">Basa</option>
                                              </select>
                                            @error('rule_ph')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="rule_suhu" class="form-label">Rule 2</label>
                                            <select class="form-select @error('rule_suhu') is_invalid @enderror" name="rule_suhu" aria-label="Default select example">
                                                <option value="rendah">Rendah</option>
                                                <option value="normal">Normal</option>
                                                <option value="tinggi">Tinggi</option>
                                              </select>
                                            @error('rule_suhu')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <select class="form-select @error('keterangan') is_invalid @enderror" name="keterangan" aria-label="Default select example">
                                                <option value="kurang baik">Kurang Baik</option>
                                                <option value="baik">Baik</option>
                                                <option value="buruk">Buruk</option>
                                              </select>
                                            @error('keterangan')
                                                <small class="help-block form-text text-danger">{{$message}}</small>
                                            @enderror
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
                                    <th>Nama Rule</th>
                                    <th>Rule PH</th>
                                    <th>Rule Suhu</th>
                                    <th>Hasil Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Edit Aturan Modal -->
<div class="modal" id="AturanModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Aturan Edit</h4>
                <button type="button" class="btn-close modelClose" data-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="AturanModalBody">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="nm_rule" class="form-label">Nama Aturan</label>
                                <input type="text" name="nm_rule" id="nm_rule" value="" class="form-control @error('nm_rule') is_invalid @enderror" autofocus>
                                @error('nm_rule')
                                    <small class="help-block form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="rule_ph" class="form-label">Rule 1</label>
                                <select class="form-select @error('rule_ph') is_invalid @enderror" id="rule_ph" name="rule_ph" aria-label="Default select example">
                                    <option value="" disabled selected>Select BG</option>
                                    <option value="asam">Asam</option>
                                    <option value="netral">Netral</option>
                                    <option value="basa">Basa</option>
                                  </select>
                                @error('rule_ph')
                                    <small class="help-block form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="rule_suhu" class="form-label">Rule 2</label>
                                <select class="form-select @error('rule_suhu') is_invalid @enderror" id="rule_suhu" name="rule_suhu" aria-label="Default select example">
                                    <option value="rendah">Rendah</option>
                                    <option value="normal">Normal</option>
                                    <option value="tinggi">Tinggi</option>
                                  </select>
                                @error('rule_suhu')
                                    <small class="help-block form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <select class="form-select @error('keterangan') is_invalid @enderror" id="keterangan" name="keterangan" aria-label="Default select example">
                                    <option value="kurang baik">Kurang Baik</option>
                                    <option value="baik">Baik</option>
                                    <option value="buruk">Buruk</option>
                                  </select>
                                @error('keterangan')
                                    <small class="help-block form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditAturanForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end Edit Aturan Modal -->

<!-- Delete Aturan Modal -->
<div class="modal" id="deleteAturan">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Aturan Delete</h4>
                <button type="button" class="btn-close modelClose" data-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this Aturan?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteAturanForm">Yes</button>
                {{-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">No</button> --}}
                <button type="button" class="btn btn-default modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Aturan Modal -->
{{-- {{ $data }} --}}
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
        $('#example').DataTable({
            paging: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url:"aturan-data"
            },
            columns:
            [
                {
                    "data": null, "sortable": false,
                    render : function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {data: 'nama_rule', name: 'nama_rule'},
                {data: 'ph', name: 'ph'},
                {data: 'suhu', name: 'suhu'},
                {data: 'keterangan', name: 'nilai_atas'},
                {data: 'Action', name: 'Action',orderable:false,serachable:false,sClass:'text-center'},
            ],
            // order: [[0, 'desc']]
        })
        // get single edit aturan request
        $('.modelClose').on('click',function() {
            $('#AturanModal').hide();
        });
        var id;
        $('body').on('click','#getEditAturanData',function(e) {
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "aturan/"+id+"/edit",
                method: 'GET',
                success: function(data) {
                    // $('#AturanModalBody').html(result.html);
                    $('#nm_rule').val(data.nama_rule);
                    $('#rule_ph').val(data.ph);
                    $('#rule_suhu').val(data.suhu);
                    $('#keterangan').val(data.keterangan);
                    // $('#rule_ph option[value="' + data.ph.bgroup+ '"]').prop('selected', true);
                    // $("#rule_ph").val(data.ph.rule_ph).attr('selected',true);
                    $('#AturanModal').show();
                }
            })
        })
        // update artikel request
        $('#SubmitEditAturanForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "aturan/"+id,
                method: 'PUT',
                data: {
                    nm_rule: $('#nm_rule').val(),
                    rule_ph: $('#rule_ph').val(),
                    rule_suhu: $('#rule_suhu').val(),
                    keterangan: $('#keterangan').val(),
                },
                success: function(result) {
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
                        $('#AturanModal').hide();
                    }
                }
            })
        });

        // delete data ajax
        $('.modelClose').on('click',function() {
            $('#deleteAturan').hide();
        });
        var deleteID;
        $('body').on('click', '#getDeleteId', function() {
            deleteID = $(this).data('id');
            $('#deleteAturan').show();
        });
        $('#SubmitDeleteAturanForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "aturan/"+id,
                method: 'DELETE',
                success: function(result) {
                    $('#example').DataTable().ajax.reload();
                    $('#deleteAturan').hide();
                }
            });
        })
    });

</script>
@endpush
