@extends('layouts.main')

@section('content')
<div class="main-content">
  <section class="villa-list py-5">
    <div class="container">
      
      <div class="row g-4">
        <!-- Villa Card -->
        <div class="col-md-6">
          <div class="card villa-card shadow-lg border-0">
            <div class="position-relative">
              <img src="{{ $data['image'] ?? asset('images/default.jpg') }}" class="card-img-top img-fluid rounded-top villa-image" alt="Villa Image">
              <span class="badge bg-primary position-absolute top-0 start-0 m-3 fs-6 category-badge">
                {{ $data['name_category'] }}
              </span>
            </div>
            <div class="card-body">
              <h3 class="card-title villa-title">{{ $data['name_property'] }}</h3>
              <p class="text-white mb-1"><i class="bi bi-geo-alt"></i> {{ $data['alamat'] }}, {{ $data['kecamatan'] }}, {{ $data['kota'] }}, {{ $data['negara'] }}</p>
              <p class="mb-0"><strong>Koordinat:</strong> {{ $data['latitude'] }}, {{ $data['longitude'] }}</p>
            </div>
          </div>
        </div>

        <!-- Map Section -->
        <div class="col-md-6">
          <div class="card shadow-lg border-0">
            <div class="card-body">
              <div id="map" style="height: 400px;" class="rounded"></div>
            </div>
          </div>
        </div>


        <!-- Unit Section -->
        @foreach($data['units'] as $unit)
        <div class="col-12 mb-4">
          {{-- <img src="{{ $unit['images'][0] }}?v={{ time() }}"> --}}

          <form action="/booking" method="POST">
            @csrf
            <input type="hidden" name="property_id" value="{{ $data['id'] ?? '' }}">
            <input type="hidden" name="unit_id" value="{{ $unit['id'] ?? '' }}">
            <input type="hidden" name="name_property" value="{{ $unit['name_property'] ?? '' }}">
            <input type="hidden" name="harga_unit" value="{{ $unit['harga_unit'] ?? '' }}">
            <input type="hidden" name="jumlah_kamar" value="{{ $unit['jumlah_kamar'] ?? '' }}">
            <input type="hidden" name="user_id" value="{{ session('user.id', '') }}">
            <input type="hidden" name="username" value="{{ session('user.username', '') }}">

            <div class="card unit-card shadow-sm border-0">
              <div class="row g-0">
                <!-- Left: Images -->
                <div class="col-md-5 p-3">
                  <div class="position-relative text-center">
                    <img id="mainImage_{{ $unit['id'] }}" src="{{ $unit['images'][0] }}" class="img-fluid w-300 mb-3 unit-image" alt="unit image utama" style="width: 500px; height: 500px; object-fit: cover;">

                    <!-- Thumbnail kecil -->
                    <div class="d-flex justify-content-end flex-wrap gap-2 position-absolute bottom-0 end-0 p-2" style="background: rgba(255, 255, 255, 0.8); border-radius: 8px;">
                      @foreach($unit['images'] as $img)
                      <img src="{{ $img }}" onclick="changeImage('{{ $unit['id'] }}', '{{ $img }}')" class="img-thumbnail thumbnail-img" style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;" loading="lazy" alt="thumb">
                      @endforeach
                    </div>
                  </div>
                </div>

                <!-- Right: Details & Form -->
                <div class="col-md-7 p-4">
                  <h4 class="mb-2 unit-title">{{ $unit['tipe'] }} - Rp{{ number_format($unit['harga_unit'], 0, ',', '.') }}/malam</h4>
                  <p class="mb-2"><strong>Jumlah Kamar:</strong> {{ $unit['jumlah_kamar'] }}</p>
                  <p class="text-white">{{ $unit['deskripsi'] }}</p>

                  <div class="row g-3 mb-3">
                    <div class="col-md-4">
                      <label class="form-label">Check-in</label>
                      <input type="date" class="form-control" name="tanggal_check_in" id="checkin_{{ $unit['id'] }}">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Check-out</label>
                      <input type="date" name="tanggal_check_out" class="form-control" id="checkout_{{ $unit['id'] }}">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Jumlah Hari</label>
                      <input type="text" class="form-control" name="jumlah_hari" id="jumlah_hari_{{ $unit['id'] }}" readonly>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary mt-2">Booking</button>
                </div>
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
  function changeImage(unitId, imgUrl) {
    const mainImg = document.getElementById('mainImage_' + unitId);
    if (mainImg) {
      mainImg.src = imgUrl;
    }
  }
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
