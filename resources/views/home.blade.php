@extends('layouts.main')
@section('content')
<div class="main-content">

  <!--start banner-->
  <section class="py-5" id="home">
    <div class="container py-4 px-4 px-lg-0">
      <div class="row align-items-center justify-content-center g-4">
        <div class="col-12 col-xl-6 order-xl-first order-last">
          {{-- <pre>{{ var_dump(session()->all()) }}</pre> --}}
          <h1 class="fw-bold mb-3 banner-heading">Improved Business Solutions for Your Organization.</h1>
          <h5 class="mb-0 banner-paragraph">We are a group of talented designers who specialize in developing
            websites using Bootstrap.</h5>
          <div class="d-flex flex-column flex-lg-row align-items-center gap-3 mt-5">
            <a href="javascript:;"
              class="btn btn-lg btn-grd btn-grd-primary d-flex align-items-center rounded-5 gap-2 raised">
              <i class="material-icons-outlined">speed</i>Get Started
            </a>
            <a href="javascript:;" class="btn btn-lg btn-light d-flex align-items-center rounded-5 gap-2 raised">
              <i class="material-icons-outlined">play_circle_outline</i>Watch Video
            </a>
          </div>
        </div>
        <div class="col-12 col-xl-6 text-center">
          <img src="landing/assets/images/banners/01.png" class="img-fluid" width="560" alt="">
        </div>
      </div><!--end row-->
    </div>
  </section>
  <!--end banner-->

</div>
@endsection