
<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <Head title="register">
        @include('include.style')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="register-page bg-body-secondary">
    <div class="register-box">
      <div class="register-logo">
        <a href=""><b>Regristrasi</b></a>
      </div>
      <!-- /.register-logo -->
      <div class="card">
        <div class="card-body register-card-body">
          <p class="register-box-msg">Register a new membership</p>
          <form method="post" action="{{route('register.store')}}" >
          @csrf
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Name" id="name" name="name"/>
              <div class="input-group-text">
                <span class="bi bi-person"></span>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" id="email" name="email" class="form-control" placeholder="Email"  @error('email') is invalid @enderror/>
              <div class="input-group-text">
                <span class="bi bi-envelope"></span>
              </div>
              @error('email')
                <small class="btn-btn danger">{{$message}}</small>
              @enderror
            </div>
            <div class="input-group mb-3">
              <input
                type="password" id="password" name="password" class="form-control" placeholder="Password" @error('password') is invalid @enderror/>
              <div class="input-group-text">
                <span class="bi bi-lock-fill"></span>
              </div>
              @error('password')
                <small class="btn-btn danger">{{$message}}</small>
              @enderror
            </div>
            <!--begin::Row-->
            <div class="row">
              <div class="col-8">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="flexCheckDefault"
                  />
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree to the term
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary">Sign Up</button>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </form>
          <div class="social-auth-links text-center mb-3 d-grid gap-2">
            <p>- OR -</p>
            <a href="#" class="btn btn-primary">
              <i class="bi bi-facebook me-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-danger">
              <i class="bi bi-google me-2"></i> Sign in using Google+
            </a>
          </div>
          <!-- /.social-auth-links -->

          <p class="mb-0">
            <a href="{{route('login')}}" class="text-center">
              I already have a membership
            </a>
          </p>
        </div>
        <!-- /.register-card-body -->
      </div>
    </div>
    <!-- /.register-box -->

    <Scripts path={path} />
    <!--end::Script-->
  </body><!--end::Body-->
</html>
