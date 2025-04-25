
@extends('dashboard.layouts.main')

@section('content')
    <div id="log">
        <h1>Log Notifikasi Order</h1>
        <div id="total-order"></div>
        <ul id="order-list"></ul>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/socket.io-client@2.1.1/dist/socket.io.js"></script>

    <script type="module">
        import Echo from 'https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.js';

        window.io = io;

        window.Echo = new Echo({
            broadcaster: 'socket.io',
            /*host: window.location.hostname + ':6001'*/
             host: 'https://apiproperty.mrxnunu.com:6001',
             encrypted: true
        });

        window.Echo.channel('messages')
            .listen('.newMessage', function (e) {
                console.log('Data diterima dari server:', e);

                document.getElementById('total-order').innerHTML = `<strong>Total Order (Paid):</strong> ${e.total}`;

                const list = document.getElementById('order-list');
                list.innerHTML = '';

                e.orders.forEach(order => {
                    const item = document.createElement('li');
                    item.textContent = `#${order.kode_pemesanan} - ${order.status} - ${order.username}`;
                    list.appendChild(item);
                });
            });
    </script>
@endsection
