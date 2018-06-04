@include('layouts._pdf_header')
<table class="staff-tablePdf">
	<thead>
		<tr>
			<th>{{ __('validation.attributes.firstname') }}</th>
			<th>{{ __('validation.attributes.lastname') }}</th>
			<th>{{ __('validation.attributes.service_number') }}</th>
			<th>{{ __('validation.attributes.address_1') }}</th>
			<th>{{ __('validation.attributes.city') }}</th>
			<th>{{ __('validation.attributes.user_role') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
		<tr>
			<td>{{ $user->firstname }}</td>
			<td>{{ $user->lastname }}</td>
			<td>{{ $user->service_number }}</td>
			<td>{{ $user->address_1 }}</td>
			<td>{{ $user->city }}</td>
			<td>{{ $user->role()->role_name }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@include('layouts._pdf_footer')
