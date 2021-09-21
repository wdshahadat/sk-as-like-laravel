<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php getTitle() ?></title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php _(asset('assets/fontawesome-free/css/all.min.css')) ?>">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?php _(asset('assets/css/icheck-bootstrap.min.css')) ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php _(asset('assets/css/adminlte.min.css')) ?>">
	<link rel="stylesheet" href="<?php _(asset('assets/css/toastr.min.css')) ?>">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="<?php _(asset('/'))?>" class="h1"><b>SK Custom</b> <b><br>MVC</a>
			</div>
			@yield('card-body')
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?php _(asset('assets/js/jquery.min.js')) ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php _(asset('assets/js/bootstrap.bundle.min.js')) ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php _(asset('assets/js/adminlte.js')) ?>"></script>
	<script src="<?php _(asset('assets/js/toastr.min.js')) ?>"></script>
	<script src="<?php _(asset('assets/js/app.js')) ?>"></script>
	<script>
		let notification = '<?php _(notification()) ?>';
		if(notification) {
			alertMessage(JSON.parse(notification))
		}
	</script>
</body>

</html>
