@extends('layouts.main')

@section('content')
<div class="main-content">

  <section class="py-5" id="villa-list">
    <div class="container py-4 px-4 px-lg-0">
      <div class="text-center mb-5">
        <h1 class="fw-bold">Temukan Villa Impianmu</h1>
        <p class="text-muted">Pilih dari berbagai pilihan villa terbaik untuk liburan yang sempurna.</p>
      </div>
      <div class="row g-4">
        @foreach ($data as $villa)
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm border-0 rounded position-relative">
            <div class="position-absolute top-0 start-0 bg-dark text-white px-3 py-2 rounded-end">
              {{ $villa['name_category'] }}
            </div>
            <img src="{{ $villa['image'] }}" class="card-img-top" alt="{{ $villa['name_property'] }}">
            <div class="card-body">
              <p class="text-white mb-2">{{ $villa['name_property'] }}</p>
              <p class="fw-bold text-primary">{{ $villa['alamat'] }}</p>
              <a href="/properties/{{ $villa['slug'] }}" class="btn btn-primary w-100">Lihat Detail</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

</div>
@endsection
