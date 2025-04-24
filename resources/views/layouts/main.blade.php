<!doctype html>
  
  {{-- <html lang="en" data-bs-theme="semi-dark"> --}}
  <html lang="en" data-bs-theme="{{ session('theme', 'blue-theme') }}">


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Property MRXNUNU | {{ $title }}</title>
  <link rel="icon" href="{{ asset('landing/assets/images/avatar.png') }}" type="image/png">
  <link href="{{ asset('landing/assets/css/pace.min.css')}}" rel="stylesheet">
  <script src="{{ asset('landing/assets/js/pace.min.js') }}"></script>

  <link href="{{ asset('landing/assets/plugins/OwlCarousel/css/owl.carousel.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('landing/assets/plugins/lightbox/dist/css/glightbox.min.css') }}">
  
  <!-- SweetAlert CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.min.css" rel="stylesheet">
  
  <!--bootstrap css-->
  <link href="{{ asset('landing/assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="{{ asset('landing/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/sass/main.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/assets/css/horizontal-menu.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/sass/dark-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/sass/semi-dark.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/sass/blue-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/sass/bordered-theme.css') }}" rel="stylesheet">

   <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <!-- Link CSS untuk Routing Machine -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

  <!-- Link JS untuk Leaflet -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- Link JS untuk Routing Machine -->
  <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

  <link rel="stylesheet" href="assets/css/my.css">

</head>

<body>

  <!--start header-->
  <header class="top-header" id="Parent_Scroll_Div">
    @include('layouts.navbar')
  </header>
  <!--end top header-->


  <!--start main wrapper-->
  <main class="main-wrapper" data-bs-spy="scroll" data-bs-target="#Parent_Scroll_Div" data-bs-smooth-scroll="false" tabindex="0">
    @yield('content')
  </main>
  <!--end main wrapper-->


  <!--start footer -->
  <section class="page-footer py-5">
    <div class="container py-4 px-4 px-lg-0">
      <div class="row g-4">
        <div class="col-12 col-xl-4">
          <div class="footer-widget-1">
            <div class="footer-logo mb-4">
              <img src="{{ asset('landing/assets/images/nobg.png') }}" width="200" alt="">
            </div>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
              Explicabo voluptatem mollitia et repellat qui dolorum quasi.</p>
            <p class="mb-2"><strong>Address: </strong>B895 Sudan Street,<br> United Kingdom, Pin 569874</p>
            <p class="mb-2"><strong>Phone: </strong>+01-854-256-49</p>
            <p class="mb-0"><strong>Email: </strong>info@example.com</p>
            <div class="play-store-images d-flex align-items-center gap-3 mt-4">
               <a href="javascript:;">
                 <img src="{{ asset('landing/assets/images/google-play-store.png')}} " width="160" alt="">
               </a>
               <a href="javascript:;">
                <img src="{{ asset('landing/assets/images/apple-store.png') }}" width="160" alt="">
              </a>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-2">
          <div class="footer-widget-2">
            <div class="footer-links">
              <h5 class="mb-4">Useful Links</h5>
              <div class="d-flex flex-column gap-2">
                <a href="javascript:;">Home</a>
                <a href="javascript:;">About us</a>
                <a href="javascript:;">Services</a>
                <a href="javascript:;">Portfolio</a>
                <a href="javascript:;">Contact</a>
                <a href="javascript:;">Terms of service</a>
                <a href="javascript:;">Privacy policy</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-2">
          <div class="footer-widget-3">
            <div class="footer-links">
              <h5 class="mb-4">Our Services</h5>
              <div class="d-flex flex-column gap-2">
                <a href="javascript:;">Product Development</a>
                <a href="javascript:;">Graphic Design</a>
                <a href="javascript:;">Human resourse</a>
                <a href="javascript:;">Software Developer</a>
                <a href="javascript:;">Web Design</a>
                <a href="javascript:;">CRM Management</a>
                <a href="javascript:;">eCommerce website</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-4">
          <div class="footer-widget-4">
            <h5 class="mb-4">Our Newsletter</h5>
            <div class="d-flex flex-column gap-2">
              <p>Join our newsletter to get the most recent information about our goods and services!</p>
              <form>
                <div class="input-group subscribe-control">
                  <input type="text" class="form-control">
                  <button class="btn btn-grd btn-grd-primary px-4" type="button">Subscribe</button>
                </div>
              </form>
            </div>
            <h6 class="mb-3 mt-4">Follow Us</h6>
            <div class="d-flex align-items-center justify-content-start gap-3">
              <a href="javascript:;"
                class="wh-42 bg-grd-deep-blue text-white rounded-circle d-flex align-items-center justify-content-center"><i
                  class="bi bi-linkedin fs-5"></i></a>
              <a href="javascript:;"
                class="wh-42 bg-grd-info text-white rounded-circle d-flex align-items-center justify-content-center"><i
                  class="bi bi-facebook fs-5"></i></a>
              <a href="javascript:;"
                class="wh-42 bg-grd-danger text-white rounded-circle d-flex align-items-center justify-content-center"><i
                  class="bi bi-youtube fs-5"></i></a>
              <a href="javascript:;"
                class="wh-42 bg-grd-voilet text-white rounded-circle d-flex align-items-center justify-content-center"><i
                  class="bi bi-twitter-x fs-5"></i></a>
            </div>
          </div>
        </div>
  
      </div><!--end row-->
    </div>
  </section>
  <!--end footer section-->



  <!--Start Back To Top Button-->
     <a href="javaScript:;" class="back-to-top"><i class="material-icons-outlined">arrow_upward</i></a>
  <!--End Back To Top Button-->

  <!--start switcher-->
  <button class="btn btn-grd btn-grd-danger btn-switcher position-fixed top-50 d-flex align-items-center gap-2"
    type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
    <i class="material-icons-outlined">tune</i>Customize
  </button>

  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
    <div class="offcanvas-header border-bottom h-70">
      <div class="">
        <h5 class="mb-0">Theme Customizer</h5>
        <p class="mb-0">Customize your theme</p>
      </div>
      <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
        <i class="material-icons-outlined">close</i>
      </a>
    </div>
    <div class="offcanvas-body">
      <div>
        <p>Theme variation</p>

        <div class="row g-3">
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="BlueTheme" value="blue-theme">
            <label
              class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
              for="BlueTheme">
              <span class="material-icons-outlined">contactless</span>
              <span>Blue</span>
            </label>
          </div>
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="LightTheme" value="light">
            <label
              class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
              for="LightTheme">
              <span class="material-icons-outlined">light_mode</span>
              <span>Light</span>
            </label>
          </div>
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="DarkTheme" value="dark">
            <label
              class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
              for="DarkTheme">
              <span class="material-icons-outlined">dark_mode</span>
              <span>Dark</span>
            </label>
          </div>
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme" value="semi-dark">
            <label
              class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
              for="SemiDarkTheme">
              <span class="material-icons-outlined">contrast</span>
              <span>Semi Dark</span>
            </label>
          </div>
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme" value="bordered-theme">
            <label
              class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
              for="BoderedTheme">
              <span class="material-icons-outlined">border_style</span>
              <span>Bordered</span>
            </label>
          </div>
        </div><!--end row-->

      </div>
    </div>
  </div>
  <!--start switcher-->

  <!--bootstrap js-->
  <script src="{{ asset('landing/assets/js/bootstrap.bundle.min.js') }}"></script>

  <!--plugins-->
  <script src="{{ asset('landing/assets/js/jquery.min.js') }}"></script>

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.min.js"></script>

  <!--plugins-->
  <script src="{{ asset('landing/assets/plugins/OwlCarousel/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('landing/assets/plugins/OwlCarousel/js/owl.carousel2.thumbs.min.js') }}"></script>
  <script src="{{ asset('landing/assets/js/main.js') }}"></script>

  <script src="{{ asset('landing/assets/plugins/lightbox/dist/js/glightbox.min.js') }}"></script>
 
  {{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
      let themeRadios = document.querySelectorAll("input[name='theme-options']");
      themeRadios.forEach(input => {
        input.addEventListener("change", function () {
          let newTheme = this.id.replace("Theme", "-theme").toLowerCase();
          document.documentElement.setAttribute("data-bs-theme", newTheme);

          fetch("{{ url('/set-theme') }}", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ theme: newTheme })
          }).then(response => response.json())
            .then(data => console.log(data));
        });

        if ("{{ session('theme', 'blue-theme') }}" === input.id.replace("Theme", "-theme").toLowerCase()) {
          input.checked = true;
        }
      });
    });
  </script> --}}

  <script>
  document.querySelectorAll('input[name="theme-options"]').forEach((radio) => {
    radio.addEventListener('change', function() {
      let selectedTheme = this.value;

      fetch("{{ route('theme.update') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ theme: selectedTheme })
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
            document.documentElement.setAttribute("data-bs-theme", selectedTheme);
          }
        });
    });
  });
</script>



  @yield('scripts')

</body>

</html>