@extends('dashboard.layouts.main')
@section('content')

<div class="card">
    <img src="{{ $property['image'] }}" class="img-fluid card-img-top" width="100" alt="">
    <div class="card-body p-4">
      <h3 class="">Welcome to Company</h3>
      <p>Contrary to popular belief, Lorem Ipsum is not simply random text.
        It has roots in a piece of classical Latin literature from 45 BC,
        making it over 2000 years old.</p>
      <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below
        for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by
        Cicero are also reproduced in their exact original form, accompanied
        by English versions from the 1914 translation by H. Rackham.</p>

      <div class="my-4 text-center">
        <p class="fs-5">Welcome to the future of work.</p>
        <a href="javascript:;" class="btn btn-grd btn-grd-danger border-0 btn-lg px-5">Start Exploring</a>
      </div>

      <div class="mt-5">
        <div class="text-center">
          <h5 class="mb-3">Explore top services</h5>
        </div>
        <div class="row row-cols-1 row-cols-lg-2 g-4">
          <div class="col">
            <div class="text-center">
              <img src="assets/images/gallery/21.png" class="img-fluid rounded" alt="">
              <h5 class="mb-0 mt-3">Logo Design</h5>
            </div>
          </div>
          <div class="col">
            <div class="text-center">
              <img src="assets/images/gallery/22.png" class="img-fluid rounded" alt="">
              <h5 class="mb-0 mt-3">Whiteboard & Animated</h5>
            </div>
          </div>
          <div class="col">
            <div class="text-center">
              <img src="assets/images/gallery/23.png" class="img-fluid rounded" alt="">
              <h5 class="mb-0 mt-3">Voice Over</h5>
            </div>
          </div>
          <div class="col">
            <div class="text-center">
              <img src="assets/images/gallery/24.png" class="img-fluid rounded" alt="">
              <h5 class="mb-0 mt-3">Wordpress</h5>
            </div>
          </div>
          <div class="col">
            <div class="text-center">
              <img src="assets/images/gallery/25.png" class="img-fluid rounded" alt="">
              <h5 class="mb-0 mt-3">Articles & Blog Posts</h5>
            </div>
          </div>
          <div class="col">
            <div class="text-center">
              <img src="assets/images/gallery/26.png" class="img-fluid rounded" alt="">
              <h5 class="mb-0 mt-3">Website Design</h5>
            </div>
          </div>
        </div><!--end row-->
      </div>
    </div>
  </div>

@section('scripts')
@endsection

@endsection
