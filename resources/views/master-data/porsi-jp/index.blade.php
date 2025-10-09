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
                    <p class="card-description">Porsi Jasa</p>
                    
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tarif</th>
                                    <th>Instalasi Induk</th>
                                    <th>Instansi Pelaksana</th>
                                    <th>Kelompok Tindakan</th>
                                    <th>JLP</th>
                                    <th>JLA</th>
                                    <th>JTL-ST</th>
                                    <th>JTL-P</th>
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
                                    <td>Kelompok Tindakan {{ $index }}</td>
                                    <td>1</td>
                                    <td>12</td>
                                    <td>123</td>
                                    <td>1234</td>
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
