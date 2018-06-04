<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{ __('global.gsg_tool') }}</title>
	<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Styles -->
	<!--	<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
	<div id="app">
		@guest @else
		<nav id="navbar" class="navbar">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" rel="home" href="{{ route('home') }}" title="GSG Tool">
						<img src="{{ asset('images/smallLogo.png') }}">
					</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav collapse-nav">
                        <li><a href="{{ route('home') }}">{{ __('global.menu.home') }}</a></li>
                        @if(Auth()->user()->isAdmin())
                            <li><a href="{{ route('event') }}">{{ __('global.menu.event') }}</a></li>
                            <li><a href="{{ route('staff') }}">{{ __('global.menu.staff') }}</a></li>
                            <li><a href="{{ route('client') }}">{{ __('global.menu.client') }}</a></li>
                        @endif
                        @if(Auth()->user()->isMainOrganizer())
                            <li><a href="{{ route('staff_vacation_personal') }}">{{ __('global.menu.vacation') }}</a></li>
                        @endif
                        @if(Auth()->user()->isClient())
							<li><a href="{{ route('document_list', ['document_type' => 'receipt']) }}">{{ __('global.menu.receipt') }}</a></li>
                        @endif
						@if(Auth()->user()->isAdmin())
							<li><a href="{{ route('warehouse') }}">{{ __('global.menu.warehouse') }}</a></li>
						@endif
						@if(Auth()->user()->isAdmin() || Auth()->user()->isDetective() || Auth()->user()->isMainOrganizer())
							<li><a href="{{ route('theft') }}">{{ __('global.menu.theft') }}</a></li>
						@endif
                        <li><a href="{{ route('document_list', ['document_type' => 'plan']) }}">{{ __('global.menu.plan') }}</a></li>
                        <li><a href="{{ route('document_list', ['document_type' => 'news']) }}">{{ __('global.menu.news') }}</a></li>
                        <li><a href="{{ route('document_list', ['document_type' => 'media']) }}">{{ __('global.menu.media') }}</a></li>
						@if(Auth()->user()->isAdmin() || Auth()->user()->isGuard() || Auth()->user()->isDetective() || Auth()->user()->isMainOrganizer())
							<li><a href="{{ route('report') }}">{{ __('global.menu.report') }}</a></li>
						@endif
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" data-toggle="dropdown" class="user-nav">
                              <span class="glyphicon glyphicon-user"></span>
                              <strong>{{ Auth::user()->firstname ? Auth::user()->firstname : Auth::user()->name }}</strong>
                              <span class="glyphicon glyphicon-chevron-down"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<div class="navbar-login">
										<div class="row">
											<div class="col-xs-4">
												<p class="text-center">
													<img class="img-thumbnail" src="{{ asset('images/smallLogo.png') }}" style="height:70px" />
												</p>
											</div>
											@if(!Auth()->user()->isClient())
											<div class="col-xs-8">
												<p class="text-left"><strong>{{ Auth::user()->firstname. " ". Auth::user()->lastname }}</strong></p>
												<p class="text-left">
													<a href="{{ route('profile_edit') }}" class="btn btn-primary btn-block btn-sm">{{ __('buttons.edit_profile') }}</a>
												</p>
											</div>
											@endif
										</div>
									</div>
								</li>
								<li class="divider"></li>
								<li>
									<div class="navbar-login navbar-login-session">
										<div class="row">
											<div class="col-xs-12">
												<p>
													<a href="{{ route('logout') }}" class="btn btn-danger btn-block">{{ __('buttons.logout') }}</a>
												</p>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		@endguest
		<main>
			@yield('content')
		</main>
		<div class="push-footer"></div>
		<a href="javascript:void(0)" id="back-to-top" title="Back to top"></a>
	</div>
	<footer>
		<div class="container text-center">
			<a href="{{ route('imprint') }}" class="link">{{ __('global.imprint') }}</a>
		</div>
	</footer>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="{{ asset('js/functions.js') }}"></script>
	<script src="{{ asset('js/calendar.js') }}"></script>

	{{-- Select2 --}}
	<script type="text/javascript">
		$(document).ready(function() {
			$('select').select2({
				placeholder: '{{ __('global.choose') }}',
				minimumSelectionLength: 1
			});
		});
	</script>

	{{-- Date Picker --}}
	<script type="text/javascript">
		$(".date").datetimepicker({
			format: 'dd-mm-yyyy',
			todayBtn: true,
			minView: 2,
			autoclose: true
		});
    </script>

	{{-- Datetime Picker --}}
	<script type="text/javascript">
		$(".datetime").datetimepicker({
			format: 'dd-mm-yyyy hh:ii',
			todayBtn: true,
			autoclose: true
		});
    </script>

    {{-- DataTables --}}
    <script type="text/javascript">
        $(document).ready( function () {
            $('#myTable').DataTable({
                "scrollX": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/"+'{{ __('global.data_table_lang') }}'+".json"
                }
            });
        } );
    </script>
	
	<script>
		$(document).ready( function () {
			var height = $("footer").outerHeight();
			$("#app").css("margin-bottom", "-" + height + "px");
			$(".push-footer").css("height", height + "px");
		});
	</script>
	
	<script>
		$(document).ready(function () {
			if ($("#back-to-top").length) {
				var scrollTrigger = 500, // px
					backToTop = function () {
						var scrollTop = $(window).scrollTop();
						if (scrollTop > scrollTrigger) {
							$("#back-to-top").addClass("show");
						} else {
							$("#back-to-top").removeClass("show");
						}
					};
				backToTop();
				$(window).on("scroll", function () {
					backToTop();
				});
				$("#back-to-top").on("click", function (e) {
					e.preventDefault();
					$("html, body").animate({
						scrollTop: 0
					}, 1000);
				});
			}
		});
	</script>

    @yield('per_page_scripts')
</body>
</html>
