@extends('layouts.app') @section('content')
<div class="container">
	<div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
		<div class="row">
			<div class="iconmelon" style="margin: 0 auto">
				<img class="img-responsive" src="{{ asset('images/logo.png') }}" width="400">
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title text-center">{{ __('global.gsg_tool') }}<br><a href='http://globalsecuritygroup.ch/'>{{ __('messages.login_go_back') }}</a></div>
				<div class="panel-title text-center"></div>
			</div>
			<!-- errors & messages -->
			<div class="panel-body">
				<form name="loginform" id="form" class="form-horizontal" action="{{ route('login') }}" method="POST">
					@csrf
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="login_input_username" type="text" class="form-control" name="username" placeholder="{{ __('validation.attributes.username') }}" />
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="login_input_password" type="password" class="form-control" name="password" autocomplete="off" placeholder="{{ __('validation.attributes.password') }}" />
					</div>
					<div class="row">
						<div class="col-8">
							@if ($errors->has('username'))
							<p style="color: red;"><strong>{{ $errors->first('username') }}</strong></p>
							@endif @if ($errors->has('password'))
							<p style="color: red;"><strong>{{ $errors->first('password') }}</strong></p>
							@endif
						</div>
						<div class="col-4">
							<div class="form-group">
								<!-- Button -->
								<div class="col-sm-12 controls text-center">
									<input id="btn-login" type="submit" class="submit-btn btn btn-primary" name="login" value="{{ __('buttons.login') }}" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
