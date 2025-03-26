@extends('layouts.main')

@section('content')
<div class="main-content">
  <section class="py-5" id="villa-list">
    <div class="container py-4">
      <div class="row">
        <div class="col-lg-6">
          <h2 class="fw-bold">{{ $data['name_property'] }}</h2>
          <p class="text-grey">{{ $data['name_category'] ?? 'Kategori tidak tersedia' }}</p>
          <img src="{{ $data['image'] ?? asset('images/default.jpg') }}" class="img-fluid rounded shadow" alt="Property Image">
        </div>
        <div class="col-lg-6">
          <h2 class="fw-bold">Lokasi Properti</h2>
          <p class="text-grey">{{ $data['alamat'] }}</p>
          {{-- <p class="fw-bold text-primary">Rp {{ number_format($data['harga_unit'], 0, ',', '.') }} / malam</p> --}}
          <div id="map" style="height: 400px;"></div>
        </div>
      </div>

      <h3 class="mt-5">Daftar Unit</h3>
      <div class="row g-4">
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
                <p class="text-muted">Tipe: {{ $unit['tipe'] }}</p>
                <p class="fw-bold text-primary">Rp {{ number_format($unit['harga_unit'], 0, ',', '.') }} / malam</p>
                <p><i class="bi bi-door-closed"></i> {{ $unit['jumlah_kamar'] }} Kamar</p>
                <p class="text-muted">{{ Str::limit($unit['deskripsi'], 100) }}</p>

                <form action="/booking" method="POST">
                  @csrf
                  <input type="hidden" name="property_id" value="{{ $data['id'] ?? '' }}">
                  <input type="hidden" name="unit_id" value="{{ $unit['id'] ?? '' }}">
                  <input type="hidden" name="name_property" value="{{ $unit['name_property'] ?? '' }}">
                  <input type="hidden" name="harga_unit" value="{{ $unit['harga_unit'] ?? '' }}">
                  <input type="hidden" name="jumlah_kamar" value="{{ $unit['jumlah_kamar'] ?? '' }}">
                  <input type="hidden" name="user_id" value="{{ session('user.id', '') }}">
                  <input type="hidden" name="username" value="{{ session('user.username', '') }}">

                  <div class="mb-2">
                    <label for="checkin_{{ $unit['id'] }}" class="form-label @error('tanggal_check_in') is-invalid @enderror">Tanggal Check-in</label>
                    <input type="date" id="checkin_{{ $unit['id'] }}" name="tanggal_check_in" class="form-control">
                    @error('tanggal_check_in')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label for="checkout_{{ $unit['id'] }}" class="form-label @error('tanggal_check_out') is-invalid @enderror">Tanggal Check-out</label>
                    <input type="date" id="checkout_{{ $unit['id'] }}" name="tanggal_check_out" class="form-control">
                    @error('tanggal_check_out')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="jumlah_hari_{{ $unit['id'] }}" class="form-label">Jumlah Hari</label>
                    <input type="text" id="jumlah_hari_{{ $unit['id'] }}" name="jumlah_hari" class="form-control" readonly>
                  </div>

                  <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="3" style="resize: none;"></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary btn-sm">Booking</button>
                </form>
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
<script>
  document.addEventListener("DOMContentLoaded", function () {
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: "{{ session('success') }}",
        showConfirmButton: true
      });
    @endif

    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        showConfirmButton: true
      });
    @endif

    // Initialize date input listeners
    document.querySelectorAll("input[type='date']").forEach(function (input) {
      input.addEventListener("change", function () {
        let unitId = this.id.split("_")[1];
        let checkin = document.getElementById("checkin_" + unitId).value;
        let checkout = document.getElementById("checkout_" + unitId).value;
        let jumlahHariInput = document.getElementById("jumlah_hari_" + unitId);

        if (checkin && checkout) {
          let startDate = new Date(checkin);
          let endDate = new Date(checkout);
          let timeDiff = endDate.getTime() - startDate.getTime();
          let dayDiff = timeDiff / (1000 * 3600 * 24);

          if (dayDiff > 0) {
            jumlahHariInput.value = dayDiff;
          } else {
            jumlahHariInput.value = "";
            alert("Tanggal check-out harus lebih besar dari check-in!");
          }
        }
      });
    });

    // Initialize Leaflet 
    var map = L.map('map').setView([{{ $data['latitude'] }}, {{ $data['longitude'] }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([{{ $data['latitude'] }}, {{ $data['longitude'] }}]).addTo(map);
    marker.bindPopup("<b>{{ $data['name_property'] }}</b><br>{{ $data['kota'] }}, {{ $data['negara'] }}").openPopup();
  });
</script>
@endsection
