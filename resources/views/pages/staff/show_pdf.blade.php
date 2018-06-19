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
	<div id="staffShowPdf">
		<div class="container">
			<header>
				<div class="logoPdf">
					<img src="https://s3.eu-central-1.amazonaws.com/gsgtool/gsgtool/logo.png" height="100"/>
				</div>
				<div class="dateHeader">
					{{ date('d-m-Y') }}
				</div>
			</header>
			<?php
			if($user->profile_picture){
				?>
				<div class="info">
					<h4>
						<?=__('validation.attributes.profile_picture')?>
					</h4>
					<div id="profile-picture">
						<img src="<?=$user->profile_picture?>" height="100"/>
					</div>
				</div>
				<?php
			}
			?>

			<h4>Personal data</h4>
			<table>
				<tbody>
					@foreach(getStaffPersonalDataColumns() as $column)
					<tr>
						@php $dbField = $user->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							@if($column == 'firstname' || $column == 'lastname' || $column == 'nickname')
								<td>{{ $user->$column }}</td>
							@else
								<td>{{ $user->role()->role_name }}</td>							
							@endif
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<h4>ID Card</h4>
			<table>
				<tbody>
					@foreach(getStaffIDCardColumns() as $column)
					<tr>
						@php $dbField = $user->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							@if($column == 'general' || $column == 'birthday')
								<td>{{ date('d-m-Y', strtotime($dbField)) }}</td>
							@elseif($column == 'country')
								<td>{{ $country[$dbField] }}</td>
							@elseif($column == 'canton')
								<td>{{ getArray($column)[$dbField] }}</td>
							@elseif($column == 'official_address' || $column == 'post_address')
								<td>{{ $dbField ? 'Yes' : 'No' }}</td>
							@else
								<td>{{ $dbField }}</td>
							@endif
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
					@foreach(getStaffContactColumns() as $column)
					<tr>
						@php $dbField = $user->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							<td>{{ $dbField }}</td>
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<h4>Administrative Data</h4>
			<table>
				<tbody>
					@foreach(getStaffAdministrativeDataColumns() as $column)
					<tr>
						@php $dbField = $user->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							@if($column == 'work_permit_date' || $column == 'wedding_date')
								<td>{{ date('d-m-Y', strtotime($dbField)) }}</td>
							@elseif($column == 'marital_status' || $column == 'work_permit')
								<td>{{ getArray($column)[$dbField] }}</td>
							@elseif($column == 'nationality')
								<td>{{ $country[$dbField] }}</td>
							@else
								<td>{{ $dbField }}</td>
							@endif
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<h4>Bank Data</h4>
			<table>
				<tbody>
					@foreach(getStaffBankDataColumns() as $column)
					<tr>
						@php $dbField = $user->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							@if($column == 'acc_type')
								<td>{{ getArray($column)[$dbField] }}</td>
							@else
								<td>{{ $dbField }}</td>
							@endif
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<h4>Skills And Qualifications</h4>
			<table>
				<tbody>
					@foreach(getStaffSkillsColumns() as $column)
					<tr>
						@php $dbField = $user->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							@if($column == 'current_job')
								<td>{{ getArray($column)[$dbField] }}</td>
							@elseif($column == 'spoken_language')
								@php
									$languages = '';
									foreach(explode(',', $user->spoken_language) as $spoken_language){
										$languages .= $spokenLanguage[$spoken_language]. ', ';
									}
								@endphp
								<td>{{ rtrim($languages, ', ') }}</td>
							@else
								<td>{{ $dbField }}</td>
							@endif
						@else
						 	@continue
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			<h4>Other Info</h4>
			<table>
				<tbody>
					@foreach(getStaffOtherInfo() as $column)
					<tr>
						@php $dbField = $user->$column; @endphp
						@if($dbField)
							<td>{{ __('validation.attributes.' . $column) }}</td>
							@if($column == 'trousers_size' || $column == 't_shirt_size')
								<td>{{ getArray($column)[$dbField] }}</td>
							@elseif($column == 'driving_license' || $column == 'auto')
								<td>{{ $defaultSelect[$dbField] }}</td>
							@else
								<td>{{ $dbField }}</td>
							@endif
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
