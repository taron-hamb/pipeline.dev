<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<meta name="csrf_token" content="{{ csrf_token() }}" />
	<script>
		$(document).ready(function(){

			$("#login").click(function(event){
				event.preventDefault();
				var email = $('input[id="email"]').val();
				var password = $('input[id="password"]').val();
				var data = null;
				$.ajax({
					type: 'POST',
					url: "https://api.pipedrive.com/v1/authorizations?api_token=bc176df1022909573150c3f54fd522e0baf5c363",
					data:{
						email: email,
						password: password
					},
					success: function(result){
						data = result.additional_data.user.profile;
					},
					error: function(error){
						console.log(error);
					},
					async: false
				});
				if(data != null){
					var login = null;
					$.ajax({
						url: '/login',
						type: 'POST',
						beforeSend: function (xhr) {
							var token = $('meta[name="csrf_token"]').attr('content');

							if (token) {
								return xhr.setRequestHeader('X-CSRF-TOKEN', token);
							}
						},
						data: {
							email: data.email,
							name: data.name
						},
						success: function (result) {
							login = result;
						},
						error: function (error) {
							login = error;
						},
						async: false
					});

					console.log(login);
					if(login == 'success'){
						window.location.href = '/';
					}
				}else{
					console.log(data);
				}
//
//				console.log(data);
			});


//			$("#register").click(function(){
//				var name = $(input[type='name']).val();
//				var email = $(input[type='email']).val();
//				var active_flag = $(input[type='active_flag']).val();
//				$.ajax({
//					type: 'POST',
//					url: "https://api.pipedrive.com/v1/users?api_token=bc176df1022909573150c3f54fd522e0baf5c363",
//					data:{name:name,email:email,active_flag:active_flag},
//					success: function(result){
//						console.log(result);
//						console.log(result.status)
//					},
//					error:function(result){
//						console.log(result);
//					}
//				});
//			});
		});

	</script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						{{--<li><a href="{{ url('/auth/register') }}">Register</a></li>--}}
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
