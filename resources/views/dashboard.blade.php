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
                        <a class="sidebar-link" href="index.html">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
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
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

            <div class="row">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Kriteria</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="truck"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $kriteria }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Aturan</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $aturan }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-xxl-7">
                    <div class="card flex-fill w-100">
                        <div class="card-header">

                            <h5 class="card-title mb-0">Kelompok 2 Bondowoso</h5>
                        </div>
                        <div class="card-body py-3">
                            <ol>
                                <li>Firman Abdi S.P. (E41192233)</li>
                                <li>Rifjan Jundila (E41192303)</li>
                                <li>Viky L.S.P. (E41192227)</li>
                                <li>Marsella Dwi Faira (E41192295)</li>
                                <li>Riskie Nur Fadilah (E41191443)</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@endpush
