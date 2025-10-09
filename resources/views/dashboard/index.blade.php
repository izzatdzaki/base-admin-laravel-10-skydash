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
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">Welcome, {{ auth()->user()->name }}!</h3>
            <h6 class="font-weight-normal mb-0">Selamat datang di Dashboard Admin. Semua sistem berjalan dengan baik!</h6>

            <div class="card mt-4">
              <div class="card-body">
                <h4 class="card-title">Informasi Pengguna</h4>
                <p class="card-text">Anda masuk sebagai: <strong>{{ auth()->user()->email }}</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

