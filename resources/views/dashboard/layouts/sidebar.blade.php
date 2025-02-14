<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <a href="/" class="logo-icon">
      <img src="{{ asset('vertical/assets/images/logo-icon.png') }}" class="logo-img" alt="">
    </a>
    <a href="/" class="logo-name flex-grow-1">
      <h5 class="mb-0">Maxton</h5>
    </a>
    <div class="sidebar-close">
      <span class="material-icons-outlined">close</span>
    </div>
  </div>
  <div class="sidebar-nav">
    <!--navigation-->
    <ul class="metismenu" id="sidenav">
      <li>
        <a href="/dashboard">
          <div class="parent-icon"><i class="material-icons-outlined">home</i></div>
          <div class="menu-title">Dashboard</div>
        </a>
      </li>
      <li class="menu-label">UI Elements</li>
      <li class="{{ request()->is('property*') || request()->is('category*') || request()->is('unit*') ? 'mm-active' : '' }}">
        <a href="javascript:;" class="has-arrow">
          <div class="parent-icon"><i class="material-icons-outlined">description</i></div>
          <div class="menu-title">Master Data</div>
        </a>
        <ul class="{{ request()->is('property*') || request()->is('category*') || request()->is('unit*') ? 'mm-show' : '' }}">
          <li class="{{ request()->is('category*') ? 'active' : '' }}">
            <a href="/category"><i class="material-icons-outlined">category</i>Category</a>
          </li>
          <li class="{{ request()->is('property*') ? 'active' : '' }}">
            <a href="/property"><i class="material-icons-outlined">room_preferences</i>Property</a>
          </li>
          <li class="{{ request()->is('unit*') ? 'active' : '' }}">
            <a href="/unit"><i class="material-icons-outlined">bed</i>Unit</a>
          </li>
        </ul>     
      </li>
    </ul>
    <!--end navigation-->
  </div>
</aside>