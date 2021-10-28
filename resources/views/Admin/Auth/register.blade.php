<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login | Page</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/favicon.png')}}">
    <style>
            .alert {
            padding: 5px 30px 5px 0px;
            margin-bottom: -20px;
            border: 1px solid transparent;
            border-radius: 4px;
            }
        </style>
        </head>

    <body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<p class="lead">Register your account</p>
                                @if($message = Session::get('error'))
                                <div class="alert alert-danger text-center alert-dismissible" role="alert">{{$message}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>   
                                </div>
                                @endif
								@if($message = Session::get('success'))
                                <div class="alert alert-success text-center alert-dismissible" role="alert">{{$message}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>   
                                </div>
                                @endif
							</div>
							<form class="form-auth-small" method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="text" name="first_name" class="form-control" value="{{old('first_name') }}" id="signin-email" placeholder="First Name" required>
									@error('first_name') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
                                <div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="text" name="last_name" class="form-control" id="signin-email" value="{{old('last_name') }}" placeholder="Last Name" required>
									@error('last_name') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email" name="email" class="form-control" id="signin-email" value="{{old('email') }}" placeholder="Email" required>
									@error('email') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="text" name="club_name" class="form-control" value="{{old('club_name') }}" id="signin-password" placeholder="Club Name" required>
									@error('club_name') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" name="password" class="form-control" value="{{old('password') }}" id="signin-password" placeholder="Password" required>
									@error('password') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" name="password_confirmation" class="form-control" value="{{old('password') }}" id="signin-password" placeholder="Confirm Password" required>
									@error('password_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block">SignUp</button>
								<div class="bottom">
									Already a Member?<span class="helper-text"><a href="{{ route('login') }}">Login</a></span>
								</div>
							</form>
						</div>
					</div>
	
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
</body>

</html>
