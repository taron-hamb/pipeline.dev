@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">Login</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel-body">
								<div id="errors" style="display: none">
									<div class="alert alert-danger">
										<strong>Whoops!</strong>  Incorrect email or password !
									</div>
								</div>

								<form id="login_form" class="form-horizontal" role="form" method="post" action="">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">

									<div class="form-group">
										<label class="col-md-4 control-label">E-Mail Address</label>
										<div class="col-md-6">
											<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}">
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label">Password</label>
										<div class="col-md-6">
											<input type="password" id="password" class="form-control" name="password">
										</div>
									</div>
									<div class="row">
										<button id="login" type="button" class="btn btn-primary center-block">Login</button>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
