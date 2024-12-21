<!DOCTYPE html>
<html lang="en">

<head>
	<title>Resgister</title>
	@include('include.style')
</head>
<!--end::Head-->
<!--begin::Body-->

<body>
	@if ($errors->any())
	<div>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="{{asset('template/assets/img/logo.png')}}" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Register</h1>
							<form method="POST" action="{{route('register')}}" class="needs-validation" novalidate="" autocomplete="off">
								@csrf
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Name</label>
									<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
									<div class="invalid-feedback">
										Name diperlukan
									</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required @error('email') is invalid @enderror>
									<div class="invalid-feedback">
										Email diperlukan
									</div>
									@error('email')
									<small class="btn-btn danger">{{$message}}</small>
									@enderror
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required @error('password') is invalid @enderror>
									<div class="invalid-feedback">
										Password diperlukan
									</div>
									@error('password')
									<small class="btn-btn danger">{{$message}}</small>
									@enderror
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="role_id" id="role_id">
									<label class="form-check-label" for="role_id">
									</label>
									<p class="form-text text-muted mb-3">
										Dengan mendaftar, Anda setuju dengan syarat dan ketentuan kami.
									</p>
									<div class="align-items-center d-flex">
										<button type="submit" class="btn btn-primary ms-auto">
											Register
										</button>
									</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Sudah punya akun? <a href="{{route('login')}}" class="text-dark">Login</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2024 &mdash; ppma
					</div>
				</div>
			</div>
		</div>
	</section>
	@include('include.script')
</body>

</html>