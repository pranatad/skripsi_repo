<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>PDAM</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- LINEARICONS -->
		<link rel="stylesheet" href="/formlogin/fonts/linearicons/style.css">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="/formlogin/css/style.css">
	</head>

	<body>

		<div class="wrapper" style="background-image: url('/formlogin/3.jpg');background-size:cover">
			<div class="inner">
				<img src="/formlogin/images/image-.png" alt="" class="image-1">
				<form autocomplete="off" method="post" action="/login">
					@csrf
					<h3>LOGIN SYSTEM</h3>
					<h3>SISTEM INFORMASI MONITORING PERANGKAT SMART WATER METER PDAM</h3>
					<div class="form-holder">
						<span class="lnr lnr-user"></span>
						<input type="text" class="form-control" name="username" autocomplete="new-password" placeholder="Username">
					</div>
					<div class="form-holder">
						<span class="lnr lnr-lock"></span>
						<input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Password">
					</div>
					<button>
						<span>LOGIN</span>
					</button>
				</form>
				<img src="/formlogin/images/image-.png" alt="" class="image-2">
			</div>
			
		</div>
		
		<script src="/formlogin/js/jquery-3.3.1.min.js"></script>
		<script src="/formlogin/js/main.js"></script>
		@include('sweetalert::alert')
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

