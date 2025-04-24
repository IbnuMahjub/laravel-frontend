@extends('dashboard.layouts.main')
@section('content')
<div class="col d-flex align-items-stretch">
  <div class="card w-100 overflow-hidden rounded-4">
    <div class="card-body position-relative p-4">
      <div class="row">
        <div class="col-12 col-sm-7">
          <div class="d-flex align-items-center gap-3 mb-5">
            <img src="{{ !empty(session('user')['avatar']) ? session('user')['avatar'] : asset('vertical/assets/images/avatars/11.png') }}" class="rounded-circle bg-grd-info p-1" width="60" height="60" alt="user">
            <div class="">
              <p class="mb-0 fw-semibold">Welcome back</p>
              <h4 class="fw-semibold mb-0 fs-4 mb-0">{{ session('user')['name'] }}</h4>
              <pre>{{ var_dump(session()->all()) }}</pre>
            </div>
          </div>
          <div class="d-flex align-items-center gap-5">
            <div class="">
              <h4 class="mb-1 fw-semibold d-flex align-content-center">$65.4K<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
              </h4>
              <p class="mb-3">Today's Sales</p>
              <div class="progress mb-0" style="height:5px;">
                <div class="progress-bar bg-grd-success" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="vr"></div>
            <div class="">
              <h4 class="mb-1 fw-semibold d-flex align-content-center">78.4%<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
              </h4>
              <p class="mb-3">Growth Rate</p>
              <div class="progress mb-0" style="height:5px;">
                <div class="progress-bar bg-grd-danger" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-5">
          <div class="welcome-back-img pt-4">
             <img src="assets/images/gallery/welcome-back-3.png" height="180" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- @section('scripts')
    <script>
  function fetchNotifications() {
    $.ajax({
      url: '{{ route("notifications.fetch") }}', 
      type: 'GET',
      success: function (res) {
        
        $('#notif-count').text(res.count);

        let html = '';
        res.dataorder.forEach(order => {
          html += `
          <div>
            <a class="dropdown-item border-bottom py-2" href="javascript:;">
              <div class="d-flex align-items-center gap-3">
                <div class="user-wrapper bg-primary text-primary bg-opacity-10">
                  <span>${order.owner_property.substring(0, 2).toUpperCase()}</span>
                </div>
                <div>
                  <h5 class="notify-title">${order.owner_property} - Order</h5>
                  <p class="mb-0 notify-desc">${order.kode_pemesanan} - ${order.status}</p>
                  <p class="mb-0 notify-time">${order.waktu_pemesanan_human}</p>
                </div>
                <div class="notify-close position-absolute end-0 me-3">
                  <i class="material-icons-outlined fs-6">close</i>
                </div>
              </div>
            </a>
          </div>`;
        });
        $('#notif-list').html(html);
      }
    });
  }

  setInterval(fetchNotifications, 10000); // 10 detik
</script>

@endsection --}}

@endsection