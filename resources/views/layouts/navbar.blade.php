<nav class="navbar navbar-expand-xl align-items-center gap-3 container px-4 px-lg-0">
  <div class="logo-header d-none d-xl-flex align-items-center gap-2">
    <div class="logo-icon">
      <img src="{{ asset('landing/assets/images/avatar.png') }}" class="logo-img" width="45" alt="">
    </div>
    <div class="logo-name">
      <h5 class="mb-0">MRXNUNU</h5>
    </div>
  </div>
  <div class="btn-toggle d-xl-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
    <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
  </div>

  <div class="offcanvas offcanvas-start w-260" tabindex="-1" id="offcanvasNavbar">
    <div class="offcanvas-header border-bottom h-70">
      <div class="d-flex align-items-center gap-2">
        <div class="">
          <img src="{{ asset('landing/assets/images/logonunu.png') }}" class="logo-icon" width="45" alt="logo icon">
        </div>
        <div class="">
          {{-- <h4 class="logo-text">Maxton</h4> --}}
        </div>
      </div>
      <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
        <i class="material-icons-outlined">close</i>
      </a>
    </div>
    <div class="offcanvas-body p-0 primary-menu">
      <ul class="navbar-nav align-items-center mx-auto gap-0 gap-xl-1">
        <li class="nav-item">
          <a class="nav-link" href="/">
            <div class="parent-icon"><i class="material-icons-outlined">home</i>
            </div>
            <div class="menu-title">Home</div>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="#About">
            <div class="parent-icon"><i class="material-icons-outlined">info</i>
            </div>
            <div class="menu-title">About</div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#Services">
            <div class="parent-icon"><i class="material-icons-outlined">work_outline</i>
            </div>
            <div class="menu-title">Services</div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#Portfolio">
            <div class="parent-icon"><i class="material-icons-outlined">photo_camera</i>
            </div>
            <div class="menu-title">Portfolio</div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#Team">
            <div class="parent-icon"><i class="material-icons-outlined">people_alt</i>
            </div>
            <div class="menu-title">Team</div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#Pricing">
            <div class="parent-icon"><i class="material-icons-outlined">euro</i>
            </div>
            <div class="menu-title">Pricing</div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#Contact">
            <div class="parent-icon"><i class="material-icons-outlined">call</i>
            </div>
            <div class="menu-title">Contact</div>
          </a>
        </li>

        <li class="nav-item dropdown d-none d-xxl-block">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
            <div class="parent-icon"><i class='material-icons-outlined'>task</i>
            </div>
            <div class="menu-title">Pages</div>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="javascript:;"><i
                  class='material-icons-outlined'>email</i>Email</a></li>
            <li><a class="dropdown-item" href="javascript:;"><i class='material-icons-outlined'>chat</i>Chat
                Box</a></li>
            <li><a class="dropdown-item" href="javascript:;"><i
                  class='material-icons-outlined'>folder</i>File Manager</a></li>
            <li><a class="dropdown-item" href="javascript:;"><i class='material-icons-outlined'>task</i>Todo</a>
            </li>
            <li><a class="dropdown-item" href="javascript:;"><i
                  class='material-icons-outlined'>description</i>Invoice</a></li>
            <li class="nav-item dropend">
              <a class="dropdown-item dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"><i
                  class='material-icons-outlined'>layers</i>Pages</a>
              <ul class="dropdown-menu submenu">
                <li class="nav-item dropend"><a class="dropdown-item dropdown-toggle dropdown-toggle-nocaret"
                    href="javascript:;"><i class='material-icons-outlined'>navigate_next</i>Error</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:;"><i
                          class='material-icons-outlined'>navigate_next</i>403 Error</a></li>
                    <li><a class="dropdown-item" href="javascript:;"><i
                          class='material-icons-outlined'>navigate_next</i>404 rror</a></li>
                    <li><a class="dropdown-item" href="javascript:;"><i
                          class='material-icons-outlined'>navigate_next</i>505 rror</a></li>
                    <li><a class="dropdown-item" href="javascript:;"><i
                          class='material-icons-outlined'>navigate_next</i>Coming Soon</a></li>
                    <li><a class="dropdown-item" href="javascript:;"><i
                          class='material-icons-outlined'>navigate_next</i>Blank Page</a></li>
                  </ul>
                </li>
                <li><a class="dropdown-item" href="javascript:;"><i
                      class='material-icons-outlined'>navigate_next</i>User Profile</a></li>
                <li><a class="dropdown-item" href="javascript:;"><i
                      class='material-icons-outlined'>navigate_next</i>Timeline</a></li>
                <li><a class="dropdown-item" href="javascript:;"><i
                      class='material-icons-outlined'>navigate_next</i>FAQ</a></li>
                <li><a class="dropdown-item" href="javascript:;"><i
                      class='material-icons-outlined'>navigate_next</i>Pricing</a></li>
              </ul>
            </li>
          </ul>
        </li> --}}
      </ul>
    </div>
  </div>
  <div class="">
    @if (session('user'))
        <a href="/dashboard" class="btn btn-grd btn-grd-primary raised d-flex align-items-center rounded-5 gap-2 px-4" type="button">
          <i class="material-icons-outlined">home</i>Dashboard
        </a>
        @else
        <a href="/login" class="btn btn-grd btn-grd-primary raised d-flex align-items-center rounded-5 gap-2 px-4" type="button">
          <i class="material-icons-outlined">account_circle</i>Login
        </a>
    @endif
    
  </div>
</nav>