@section('Dashboard','superadmin')
@include('dadmin.navbar')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
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
            <a href="{{route('dashboard')}}" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
              <li class="nav-item">
                <a href="{{route('pembayaran')}}" class="nav-link active">
                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                  <p>
                    Pembayaran
                  </p>
                </a>
                </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

        <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
      
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                                 <div class="card-header border-transparent">
                                   <h3 class="card-title">Latest Orders</h3>
                   
                                   <div class="card-tools">
                                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                       <i class="fas fa-minus"></i>
                                     </button>
                                     <button type="button" class="btn btn-tool" data-card-widget="remove">
                                       <i class="fas fa-times"></i>
                                     </button>
                                   </div>
                                 </div>
                                 <!-- /.card-header -->
                                 <div class="card-body p-0">
                                   <div class="table-responsive">
                                     <table class="table m-0">
                                       <thead>
                                       <tr>
                                         <th>Order ID</th>
                                         <th>Item</th>
                                         <th>Status</th>
                                         <th>Popularity</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       <tr>
                                         <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                         <td>Call of Duty IV</td>
                                         <td><span class="badge badge-success">Shipped</span></td>
                                         <td>
                                           <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                         <td>Samsung Smart TV</td>
                                         <td><span class="badge badge-warning">Pending</span></td>
                                         <td>
                                           <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                         <td>iPhone 6 Plus</td>
                                         <td><span class="badge badge-danger">Delivered</span></td>
                                         <td>
                                           <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                         <td>Samsung Smart TV</td>
                                         <td><span class="badge badge-info">Processing</span></td>
                                         <td>
                                           <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                         <td>Samsung Smart TV</td>
                                         <td><span class="badge badge-warning">Pending</span></td>
                                         <td>
                                           <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                         <td>iPhone 6 Plus</td>
                                         <td><span class="badge badge-danger">Delivered</span></td>
                                         <td>
                                           <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                         <td>Call of Duty IV</td>
                                         <td><span class="badge badge-success">Shipped</span></td>
                                         <td>
                                           <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                         </td>
                                       </tr>
                                       </tbody>
                                     </table>
                                   </div>
                                   <!-- /.table-responsive -->
                                 </div>
                                 <!-- /.card-body -->
                                 <div class="card-footer clearfix">
                                   <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                                   <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                                 </div>
                                 <!-- /.card-footer -->
                               </div>
                               <!-- /.card -->
                </div>
          </div>
    </div>
  </div>
    </div>
@include('dadmin.style')
@include('dadmin.script')
</body>