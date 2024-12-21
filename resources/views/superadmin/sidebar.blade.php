  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Manba'ul Anwar</title>
      <meta content="" name="description">
      <meta content="" name="keywords">
      {{--css--}}
      @include('dadmin.style')
      {{--endcss--}}
  </head>
  <aside class="main-sidebar sidebar-dark-primary mb-20 ">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="{{asset('template/assets/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Dashboard</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('foto/' . Auth::user()->admin->foto) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
              </div>
              <div class="info">
                  <a>Hello,
                      <a>{{Auth::user()->name}}</a>
                  </a>
              </div>
          </div>
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                      <a href="{{url('dashboard/superadmin')}}" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('pembayaran.index')}}" class="nav-link">
                          <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                          <p>
                              Pembayaran
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('berita')}}" class="nav-link">
                          <i class="nav-icon fa fa-newspaper-o" style="font-size:20px"></i>
                          <p>
                              Berita
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('profile')}}" class="nav-link">
                          <i class="nav-icon far fa-address-card"></i>
                          <p>
                              Profile
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('data')}}" class="nav-link">
                          <i class="nav-icon fas fa-database"></i>
                          <p>
                              Data Santri
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                          <i class="nav-icon fa fa-sign-out"></i>
                          <p>Logout</p>
                      </a>
                  </li>

                  <script>
                      function confirmLogout() {
                          if (confirm('Apakah Anda yakin ingin keluar?')) {
                              window.location.href = "{{ route('logout') }}";
                          }
                      }
                  </script>
              </ul>
          </nav>
      </div>
      <!-- /.sidebar -->
  </aside>