@extends('layouts.app') @section('content')
<div class="container main">
	@if(Session::has('success'))
	<div class="alert alert-success">{{ Session::get('success') }}</div>
	@endif
	<div class="row">
		<div class="btn-toolbar-right">
			@if(Auth()->user()->isAdmin())
			<a href="{{ route('staff_vacation_create') }}" class="btn btn-info">{{ __('buttons.create_vacation') }}</a>
			<a href="{{ route('staff_vacation_requested') }}" class="btn btn-info">{{ __('buttons.requested_vacation') }}</a>
			<a href="{{ route('staff_vacation_rejected') }}" class="btn btn-info">{{ __('buttons.rejected_vacation') }}</a> @endif
		</div>
	</div>
	<div id="calendar"></div>
	<h3>{{ __('headings.vacation_list') }}</h3>
	<table id="myTable">
		<thead>
			<tr>
				<th>{{ __('validation.attributes.user') }}</th>
				<th>{{ __('validation.attributes.type') }}</th>
				<th>{{ __('validation.attributes.start') }}</th>
				<th>{{ __('validation.attributes.end') }}</th>
				@if(Auth()->user()->isAdmin())
				<th>{{ __('global.edit') }}</th>
				<th>{{ __('global.delete') }}</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($vacationConfirmed as $vacation)
			<tr class="tableCenter">
				<td>{{ $vacation->user->firstname. ' '. $vacation->user->lastname }}</td>
				<td>{{ __('labels.vacation_type.'. $vacation->type) }}</td>
				<td>{{ date('d-m-Y', strtotime($vacation->start)) }}</td>
				<td>{{ date('d-m-Y', strtotime($vacation->end)) }}</td>
				@if(Auth()->user()->isAdmin())
				<td><a href="{{ route('staff_vacation_edit', ['vacation_id' => $vacation->id]) }}"><i class="fas fa-edit"></i></a></td>
				<td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.vacation_delete') }}', '{{ __('buttons.delete')}}', '{{ route('staff_vacation_delete', ['vacation_id' => $vacation->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@include('layouts._confirmation_modal') @endsection @section('per_page_scripts') {{-- Calendar --}}
<script>
	var objects = JSON.parse('{{ json_encode($arr) }}'.replace(/&quot;/g, '"'));
	console.log(objects);
	var arr = [];
	for (i = 0; i < objects.length; i++) {
		obj = objects[i];
		arr[i] = {
			title: obj.firstname + " " + obj.lastname,
			start: {
				date: obj.start,
				time: "00.00"
			},
			end: {
				date: obj.end,
				time: "23.59"
			},
			color: "yellow"
		};
	}
	$(document).ready(function() {
		$('#calendar').kalendar({
			events: arr,
			color: "blue",
			firstDayOfWeek: "Monday",
			eventcolors: {
				yellow: {
					background: "#FC0",
					text: "#000",
					link: "#000"
				}
			},
			dayHuman: [
				["{{ __('global.days.7') }}"],
				["{{ __('global.days.1') }}"],
				["{{ __('global.days.2') }}"],
				["{{ __('global.days.3') }}"],
				["{{ __('global.days.4') }}"],
				["{{ __('global.days.5') }}"],
				["{{ __('global.days.6') }}"]
			],
			monthHuman: [
				["JAN", "{{ __('global.months.1') }}"],
				["FEB", "{{ __('global.months.2') }}"],
				["MAR", "{{ __('global.months.3') }}"],
				["APR", "{{ __('global.months.4') }}"],
				["MAY", "{{ __('global.months.5') }}"],
				["JUN", "{{ __('global.months.6') }}"],
				["JUL", "{{ __('global.months.7') }}"],
				["AUG", "{{ __('global.months.8') }}"],
				["SEP", "{{ __('global.months.9') }}"],
				["OKT", "{{ __('global.months.10') }}"],
				["NOV", "{{ __('global.months.11') }}"],
				["DEC", "{{ __('global.months.12') }}"]
			],

		});
	});

</script>
@endsection
