<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
	<div id="clientShowPdf">
		<div class="container">
			<header>
				<div class="logoPdf">
					<img src="https://s3.eu-central-1.amazonaws.com/gsgtool/gsgtool/logo.png" height="100"/>
				</div>
				<div class="dateHeader">
					{{ date('d-m-Y') }}
				</div>
			</header>

			<h4>Personal data</h4>
			<table>
				<tbody>
					@foreach(getClientsPersonalDataColumns() as $column)
					<tr>
						@php $dbField = $client->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							@if($column == 'staff_type')
								<td>{{ $client->staffType->role_name }}</td>
							@elseif($column == 'main_company_id')
								<td>{{ $client->mainCompany() }}</td>
							@else
								<td>{{ $client->$column }}</td>
							@endif
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			
			<h4>Address</h4>
			<table>
				<tbody>
					@foreach(getClientsAddressColumns() as $column)
					<tr>
						@php $dbField = $client->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							<td>{{ $client->$column }}</td>
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<h4>Contact</h4>
			<table>
				<tbody>
					@foreach(getClientsContactColumns() as $column)
					<tr>
						@php $dbField = $client->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							<td>{{ $client->$column }}</td>
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<h4>Info</h4>
			<table>
				<tbody>
					@foreach(getClientsInfoColumns() as $column)
					<tr>
						@php $dbField = $client->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							<td>{{ $client->$column }}</td>
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<div class="dateFooter">
				{{ date('d-m-Y') }}
			</div>
			<div class="signature">
				{{ __('global.signature') }}
			</div>
		</div>
	</div>
</body>

</html>
