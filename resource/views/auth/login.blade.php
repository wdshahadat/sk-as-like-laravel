@extends('auth.container')

@section('card-body')
	<?php setTitle('Login') ?>
	<!-- /.card-body -->
		<div class="card-body">
			<p class="login-box-msg">Sign in to start your session</p>

			<form action="<?php _(route('/login')) ?>" method="post">
				<div class="input-group mb-3">
					<input type="email" name="email" class="form-control" placeholder="Email" value="<?php _(getOld('email')) ?>">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" name="password" class="form-control" placeholder="Password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-8">
						<div class="icheck-primary">
							<input type="checkbox" name="remember" id="remember">
							<label for="remember">
								Remember Me
							</label>
						</div>
					</div>
					<!-- /.col -->
					<div class="col-4">
						<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					</div>
					<!-- /.col -->
				</div>
			</form>

			<p class="mb-1">
				<a href="<?php _(route('forgot/password')) ?>">Forgot password</a>
			</p>
			<p class="mb-0">
				<a href="<?php _(route('register')) ?>" class="text-center">Register</a>
			</p>
		</div>
	<!-- /.card-body -->
@endsection
