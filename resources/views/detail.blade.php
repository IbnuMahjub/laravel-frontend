@extends('layouts.main')

@section('content')
<div class="main-content">
  <section class="py-5" id="villa-list">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card shadow-lg border-0">
            <div class="position-relative">
              <img src="{{ $data['image'] ?? asset('images/default.jpg') }}" class="card-img-top img-fluid rounded-top" alt="...">
              <span class="badge bg-primary position-absolute top-0 start-0 m-3 fs-6">
                {{ $data['name_category'] }}
              </span>
            </div>
            <div class="card-body">
              <h3 class="card-title">{{ $data['name_property'] }}</h3>
              <p class="text-muted mb-1"><i class="bi bi-geo-alt"></i> {{ $data['alamat'] }}, {{ $data['kecamatan'] }}, {{ $data['kota'] }}, {{ $data['negara'] }}</p>
              <p class="mb-0"><strong>Koordinat:</strong> {{ $data['latitude'] }}, {{ $data['longitude'] }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow-lg border-0">
            <div class="card-body">
              <div id="map" style="height: 400px;" class="rounded"></div>
            </div>
          </div>
        </div>

        <!-- Unit Section -->
        @foreach($data['units'] as $unit)
        <div class="col-12">
          <form action="/booking" method="POST">
            @csrf
            <input type="hidden" name="property_id" value="{{ $data['id'] ?? '' }}">
            <input type="hidden" name="unit_id" value="{{ $unit['id'] ?? '' }}">
            <input type="hidden" name="name_property" value="{{ $unit['name_property'] ?? '' }}">
            <input type="hidden" name="harga_unit" value="{{ $unit['harga_unit'] ?? '' }}">
            <input type="hidden" name="jumlah_kamar" value="{{ $unit['jumlah_kamar'] ?? '' }}">
            <input type="hidden" name="user_id" value="{{ session('user.id', '') }}">
            <input type="hidden" name="username" value="{{ session('user.username', '') }}">

            <div class="card shadow-sm border-0 p-3">
              <h4 class="mb-3">{{ $unit['tipe'] }} - Rp{{ number_format($unit['harga_unit'], 0, ',', '.') }}/malam</h4>
              <p><strong>Jumlah Kamar:</strong> {{ $unit['jumlah_kamar'] }}</p>
              <p>{{ $unit['deskripsi'] }}</p>
  
              <div class="row g-2">
                @foreach($unit['images'] as $img)
                <div class="col-md-4">
                  <img src="{{ $img }}" class="img-fluid rounded" alt="unit image">
                </div>
                @endforeach
              </div>
  
              <div class="row mt-3">
                <div class="col-md-4">
                  <label>Check-in</label>
                  <input type="date" class="form-control" name="tanggal_check_in" id="checkin_{{ $unit['id'] }}">
                  @error('tanggal_check_in')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                <div class="col-md-4">
                  <label>Check-out</label>
                  <input type="date" name="tanggal_check_out" class="form-control" id="checkout_{{ $unit['id'] }}">
                  @error('tanggal_check_out')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                <div class="col-md-4">
                  <label>Jumlah Hari</label>
                  <input type="text" class="form-control" name="jumlah_hari" id="jumlah_hari_{{ $unit['id'] }}" readonly>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Booking</button>
              </div>
            </div>
          </form>
        </div>
        @endforeach

      </div>
    </div>
  </section>
</div>

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

    // Hitung jumlah hari
    document.querySelectorAll("input[type='date']").forEach(function (input) {
      input.addEventListener("change", function () {
        let unitId = this.id.split("_")[1];
        let checkin = document.getElementById("checkin_" + unitId).value;
        let checkout = document.getElementById("checkout_" + unitId).value;
        let jumlahHariInput = document.getElementById("jumlah_hari_" + unitId);

        if (checkin && checkout) {
          let start = new Date(checkin);
          let end = new Date(checkout);
          let diff = (end - start) / (1000 * 3600 * 24);

          jumlahHariInput.value = diff > 0 ? diff : '';
          if (diff <= 0) alert("Tanggal check-out harus lebih besar dari check-in!");
        }
      });
    });

    // Map Leaflet
    var map = L.map('map').setView([{{ $data['latitude'] }}, {{ $data['longitude'] }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
    }).addTo(map);

    L.marker([{{ $data['latitude'] }}, {{ $data['longitude'] }}])
      .addTo(map)
      .bindPopup("<b>{{ $data['name_property'] }}</b><br>{{ $data['kota'] }}, {{ $data['negara'] }}")
      .openPopup();
  });
</script>
@endsection


@endsection
