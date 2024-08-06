@section('Dashboard','superadmin')
@include('dadmin.navbar')
@include('dadmin.body')
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
          <img src="{{asset('template/assets/Admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a>Hello,
              <a>{{Auth::user()->name}}</a>
          </a>
        </div>
      </div>
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
               <li class="nav-item menu-open">
            <a href="{{route('dashboard')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
              <li class="nav-item">
                <a href="{{route('pembayaran')}}" class="nav-link">
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
            <a href="{{route('data')}}" class="nav-link ">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Data
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
              <i class="nav-icon fa fa-envelope"></i>
              <p>
                Ajuan Keterlambatan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
              <i class="nav-icon fas fa fa-sign-out"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      </div>
    <!-- /.sidebar -->
  </aside>
@include('dadmin.style')
@include('dadmin.script')
