<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pembayaran</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  {{--css--}}

  {{--endcss--}}
</head>

<body class="index-page">

  {{--header--}}
  @include('include.header')
  {{--endheader--}}

  <main class="main">
    <!-- Hero Section -->
    <section id="home" class="hero section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
            <h2 class="">Selamat datang di Website</h2>
            <h4 class="">PONDOK PESANTREN MANBA'UL ANWAR</h4>
            <div class="d-flex">
              <a href="{{route('login')}}" class="btn-get-started">Pembayaran</a>
              </a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img text-center custom-hero-img" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{asset('template/assets/img/hero-img.png')}}" class="img-fluid animated custom-img" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">
      <div class="container" data-aos="zoom-in">
        <script type="{{asset('application/json')}}" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": "auto",
            "pagination": {
              "el": ".swiper-pagination",
              "type": "bullets",
              "clickable": true
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "spaceBetween": 40
              },
              "480": {
                "slidesPerView": 3,
                "spaceBetween": 60
              },
              "640": {
                "slidesPerView": 4,
                "spaceBetween": 80
              },
              "992": {
                "slidesPerView": 5,
                "spaceBetween": 120
              },
              "1200": {
                "slidesPerView": 6,
                "spaceBetween": 120
              }
            }
          }
        </script>
      </div>
    </section>
    <!-- About Section -->
    <section id="about" class="about section py-5">
      <!-- Section Title -->
      <div class="container section-title " data-aos="fade-up">
        <h2 class="text-center">Berita</h2>
      </div>
      <div class="container">
        <div class="row gy-4">
          <!-- Left Column: Berita Image with Caption -->
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
              @php
              $latestBerita = $beritas->first();
              @endphp
              @if ($latestBerita)
              <div class="col-md-12 mb-4">
                <div class="card h-100">
                  @if ($latestBerita->gambar)
                  <img src="{{ url('gambar/'.$latestBerita->gambar) }}" class="card-img-top" alt="{{ $latestBerita->judul }}" style="max-height: 200px; object-fit: cover;">
                  @endif
                  <div class="card-body">
                    <h5 class="card-title">{{ $latestBerita->judul }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($latestBerita->isi, 100) }}</p>
                  </div>
                </div>
              </div>
              @endif
            </div>
          </div>

          <!-- Right Column: Berita Terkini List -->
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h5 class="mb-2">Berita Terkini</h5>
            <ul class="list-group">
              @foreach ($beritas as $item)
              <li class="list-group-item d-flex align-items-center">
                <a href="{{ route('berita.tampil', ['slug' => $item->slug]) }}" class="d-flex align-items-center text-decoration-none w-100">
                  @if ($item->gambar)
                  <img src="{{ url('gambar/'.$item->gambar) }}" alt="{{ $item->judul }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                  @endif
                  <div>
                    <h6 class="mb-1">{{ $item->judul }}</h6>
                    <small>{{ \Illuminate\Support\Str::limit($item->isi, 50) }}</small>
                  </div>
                </a>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- /About Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="section why-us" data-builder="section">

    </section><!-- /Why Us Section -->
    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section">

      <img src="{{asset('template/assets/img/masjid.jpg')}}" alt="">

      <div class="container">

        <div class="row" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-9 text-center text-xl-start">
            <!-- <h3>Call To Action</h3> -->
            <!-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> -->
          </div>
          <div class="col-xl-3 cta-btn-container text-center">
            <!-- <a class="cta-btn align-middle" href="#">Call To Action</a> -->
          </div>
        </div>

      </div>

    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Kontak</h2>
        <p>Hubungi admin</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-7">
            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Kantror Sektretariat</h3>
                  <p>Jln. Dieng KM 05, Desa Krasak Mojotengah Wonosobo</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Hubungi Kami</h3>
                  <p>+62 821-1747-6767</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email</h3>
                  <p>manba'ulanwar@gmail.com</p>
                </div>
              </div><!-- End Info Item -->

              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.284217169208!2d109.91492827419901!3d-7.321937972000527!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e700a9c4dd76fb5%3A0xabe7525cea87c206!2sPondok%20Pesantren%20Manba&#39;ul%20Anwar!5e0!3m2!1sid!2sid!4v1728916877330!5m2!1sid!2sid" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="col-lg-5">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <label for="name-field" class="pb-2">Nama</label>
                  <input type="text" name="name" id="name-field" class="form-control" required="">
                </div>
                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">Subjek</label>
                  <input type="text" class="form-control" name="subject" id="subject-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="message-field" class="pb-2">Pesan</label>
                  <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section>
    <!-- /Contact Section -->

  </main>
  {{--footer--}}
  @include('include.footer')
  {{--endfooter--}}

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  {{--javacript--}}
  @include('include.script')
  @include('include.style')
  {{--endjavacript--}}
</body>

</html>