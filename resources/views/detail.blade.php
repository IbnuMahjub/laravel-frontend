@extends('layouts.main')

@section('content')
<div class="main-content">
  <section class="py-5" id="villa-list">
    <div class="container py-4 px-4 px-lg-0">
      <div class="text-center mb-5">
        <h2 class="fw-bold">{{ $data['name_property'] }}</h2>
        <p class="text-muted">{{ $data['name_category'] ?? 'Kategori tidak tersedia' }}</p>
      </div>

      <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
          <img src="{{ $data['image'] ?? asset('images/default.jpg') }}" class="img-fluid rounded shadow" alt="Property Image">
        </div>
      </div>

      <h3 class="mb-4">Daftar Unit</h3>
      <div class="row">
        @forelse ($data['units'] as $unit)
          <div class="col-md-4">
            <div class="card shadow-sm border-0">
              <div id="carousel-{{ $unit['id'] }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  @foreach ($unit['images'] as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                      <img src="{{ $image }}" class="d-block w-100 rounded-top" alt="Unit Image">
                    </div>
                  @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $unit['id'] }}" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $unit['id'] }}" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
              </div>

              <div class="card-body">
                <h5 class="card-title">{{ $unit['name_property'] }}</h5>
                <p class="text-white">Tipe: {{ $unit['tipe'] }}</p>
                <p class="fw-bold text-primary">Rp {{ number_format($unit['harga_unit'], 0, ',', '.') }}</p>
                <p><i class="bi bi-door-closed"></i> {{ $unit['jumlah_kamar'] }} Kamar</p>
                <p class="text-muted">{{ Str::limit($unit['deskripsi'], 100) }}</p>
                <a href="/booking" class="btn btn-primary btn-sm">booking</a>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center text-muted">Belum ada unit tersedia</p>
        @endforelse
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
    
@endsection
