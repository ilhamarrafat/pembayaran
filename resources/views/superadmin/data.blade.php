
@include('dadmin.style')
@section('Dashboard','data')
@include('dadmin.navbar')
@include('dadmin.sidebar')
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
          <nav class="navbar navbar-light bg-light">
          <div class="col-md-12">
              <button type="button" class="btn btn-warning col-md-2 mb-2">Cetak Data</button>
              <button type="button" class="btn btn-success col-md-1 mb-2">Excel</button>
              <button type="button" class="btn btn-warning col-md-1 mb-2">pdf</button>
              
                <div class="col-md-5 mb-2">

                <div class="form-floating">
      <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
      <label for="floatingTextarea">Comments</label>
                </div>
              </div>
              
              <!-- Main row -->
                        <!-- Left col -->
                          <!-- /.card -->
                          <!-- TABLE: LATEST ORDERS -->
                          <div class="card">
                            <div class="card-header border-transparent">
                              <h3 class="card-title">Data Santri</h3>
              
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
                                    <th>ID Santri</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Saldo</th>
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
                        <!-- /.row -->
                      </div>
                    </nav>   
    </section>
  </div>
  <footer class="main-footer">
    <div class="container copyright text-center mb-2">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Admin</strong> <span>All Rights Reserved</span></p>
    <div class="credits">
    Designed by <a>Admin</a>
    </div>
    </div>
  </footer>
@include('dadmin.script')