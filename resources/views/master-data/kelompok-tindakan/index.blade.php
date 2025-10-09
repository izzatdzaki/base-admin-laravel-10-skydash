@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Master Data</h4>
                    <p class="card-description">Kelompok Tindakan</p>
                    
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tindakan</th>
                                    <th>Kode</th>
                                    <th>Instansi Induk</th>
                                    <th>Instansi Pelaksana</th>
                                    <th>Unit</th>
                                    <th>Kelompok Tindakan</th>
                                    <th>Detail Tindakan</th>
                                    <th>Rincian Tindakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(range(1, 7) as $index)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>TRF{{ str_pad($index, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>RSUD Kota</td>
                                    <td>Poli Umum</td>
                                    <td>P{{ $index }}</td>
                                    <td>Pemeriksaan</td>
                                    <td>Konsultasi Dokter Umum</td>
                                    <td>Pemeriksaan dan konsultasi kesehatan umum</td>
                                    <td>Rincian Tindakan</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Hapus</button>
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
@endsection
