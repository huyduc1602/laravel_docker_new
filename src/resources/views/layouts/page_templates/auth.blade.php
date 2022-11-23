<div class="row g-0 flex-nowrap">
  @include('layouts.navbars.sidebar')
  <div class="main-panel">
    @include('layouts.navbars.navs.auth')
    @yield('content')
  </div>
</div>