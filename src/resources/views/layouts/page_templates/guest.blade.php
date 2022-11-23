@include('layouts.navbars.navs.guest')
<div class="container-fluid">
  <div class="bg-image" 
  style="background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg');
         height: 100vh; 
         overflow: hidden;">
  <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    @yield('content')
  </div>
</div>
