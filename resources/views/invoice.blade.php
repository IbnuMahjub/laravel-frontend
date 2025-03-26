@extends('layouts.main')

@section('content')
<div class="main-content">
    <section class="py-5" id="villa-list">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Invoice</h3>
                        </div>
                        <div class="card-body">
                            <h5>Detail Pemesanan</h5>
                            <p><strong>Kode Pemesanan:</strong> {{ $data['kode_pemesanan'] }}</p>
                            <p><strong>Nama Property:</strong> {{ $data['name_property'] }}</p>
                            <p><strong>Harga per Unit:</strong> Rp {{ number_format($data['harga_unit'], 0, ',', '.') }}</p>
                            {{-- <p><strong>Jumlah Kamar:</strong> {{ $data['jumlah_kamar'] }}</p> --}}
                            <p><strong>Check-in:</strong> {{ $data['tanggal_check_in'] }}</p>
                            <p><strong>Check-out:</strong> {{ $data['tanggal_check_out'] }}</p>
                            <p><strong>Jumlah Hari:</strong> {{ $data['jumlah_hari'] }}</p>
                            <p><strong>Total Harga:</strong> Rp {{ number_format($data['total_harga'], 0, ',', '.') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-success">{{ $data['status'] }}</span></p>

                            <hr>

                            <h5>Invoice</h5>
                            @if(!empty($data['invoices']))
                                @foreach($data['invoices'] as $invoice)
                                    <p><strong>No Invoice:</strong> {{ $invoice['no_invoice'] }}</p>
                                    <p><strong>Total Harga:</strong> Rp {{ number_format($invoice['total_harga'], 0, ',', '.') }}</p>
                                    <p><strong>Status:</strong> <span class="badge bg-success">{{ $invoice['status'] }}</span></p>
                                    <p><strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($invoice['created_at'])) }}</p>
                                @endforeach
                            @else
                                <p>Tidak ada invoice tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
