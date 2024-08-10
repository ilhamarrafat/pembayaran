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
    <li class="nav-item">
      <a href="{{route('logout')}}" class="nav-link">
        <i class="nav-icon fas fa fa-sign-out"></i>
        <p>
          Logout
        </p>
      </a>
    </li>
  </div>
  <!-- /.sidebar -->
</aside>