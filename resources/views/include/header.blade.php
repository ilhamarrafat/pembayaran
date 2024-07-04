{{--header--}}
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{asset('template/assets/img/logo.png')}}" alt="">
        <h1 class="sitename" id="h1">
          Pondok Pesantren Manba'ul Anwar
        </h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{asset('template/hero')}}" class="">Home</a></li>
          <li><a href="{{asset('template/about')}}">Berita</a></li>
          <li><a href="{{asset('template/services')}}">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn-getstarted" href="{{route('login')}}">Login</a>
    </div>
  </header>