{{-- @extends('layouts.main')

@section('content')
<div class="container">
    <h2>Pembayaran untuk {{ $data['name_property'] }}</h2>
    <p>Kode Pemesanan: <strong>{{ $data['kode_pemesanan'] }}</strong></p>
    <p>Total Harga: <strong>Rp {{ number_format($data['total_harga'], 0, ',', '.') }}</strong></p>

    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>

    <form id="payment-form" method="POST" action="{{ route('midtrans.callback') }}">
        @csrf
        <input type="hidden" name="json" id="json_callback">
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function() {
        snap.pay("{{ $snapToken }}", {
            onSuccess: function(result) {
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
            },
            onPending: function(result) {
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
            }
        });
    };
</script>
@endsection --}}


@extends('layouts.main')

@section('content')

{{-- sandbox --}}
<script type="text/javascript"
     src="https://app.sandbox.midtrans.com/snap/snap.js"
     data-client-key="{{ config('midtrans.client_key') }}">
</script>

{{-- productions --}}
{{-- <script type="text/javascript"
     src="https://app.midtrans.com/snap/snap.js"
     data-client-key="{{ config('midtrans.client_key') }}">
</script> --}}


<div class="container">
  <div class="row">
    <div class="card mb-4" style="width: 18rem;">
      <div class="card-body">
        <h2>Pembayaran untuk {{ $data['name_property'] }}</h2>
        <p>Kode Pemesanan: <strong>{{ $data['kode_pemesanan'] }}</strong></p>
        <p>Total Harga: <strong>Rp {{ number_format($data['total_harga'], 0, ',', '.') }}</strong></p>

        
        <div class="d-flex justify-content-between mt-4">
          <button class="btn btn-success" id="pay-button">Bayar Sekarang</button>
          <a href="/" class="btn btn-danger">Batal</a>
      </div>
      </div>
  </div>
  </div>
</div>

@section('scripts')
    <script type="text/javascript">
  var payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', function () {
    window.snap.pay('{{ $snapToken }}', {
      onSuccess: function(result){
        window.location.href = '/invoice/{{ $data['kode_pemesanan'] }}';
        alert("payment success!"); console.log(result);
      },
      onPending: function(result){
        alert("wating your payment!"); console.log(result);
      },
      onError: function(result){
        /* You may add your own implementation here */
        alert("payment failed!"); console.log(result);
      },
      onClose: function(){
        /* You may add your own implementation here */
        alert('you closed the popup without finishing the payment');
      }
    })
  });
</script>
@endsection

@endsection