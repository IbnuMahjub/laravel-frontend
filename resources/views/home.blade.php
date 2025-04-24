@extends('layouts.main')

@section('content')
<div class="main-content">

  <div class="bg-dark text-white py-2">
    <marquee behavior="scroll" direction="left">🏡 Temukan Hunian Idamanmu | Harga Terbaik & Lokasi Strategis | Booking Sekarang! ✨</marquee>
  </div>
  
{{-- @dd(session()->all()) --}}

 {{-- <pre>{{ var_dump(session()->all()) }}</pre> --}}
  <section class="py-5" id="villa-list">
    <div class="container py-4 px-4 px-lg-0">
      <div class="card__container">
        @foreach ($data as $villa)
            <article class="card__article">
                <img src="{{ $villa['image'] }}" alt="image" class="card__img">

                <div class="card__data">
                  <span class="card__description">{{ $villa['name_category'] }}</span>
                  <h2 class="card__title">{{ $villa['name_property'] }}</h2>
                  <a href="/properties/{{ $villa['slug'] }}" class="card__button">Read More</a>
                </div>
            </article>
        @endforeach
        
      </div>
    </div>
  </section>

</div>
@endsection
