@include('layouts._pdf_header')
<table class="client-tablePdf">
	<thead>
		<tr>
			<th>{{ __('validation.attributes.name') }}</th>
			<th>{{ __('validation.attributes.address_1') }}</th>
			<th>{{ __('validation.attributes.city') }}</th>
			<th>{{ __('validation.attributes.email') }}</th>
			<th>{{ __('validation.attributes.phone') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($clients as $client)
		<tr class="client-tr">
			<td>{{ $client->name }}</td>
			<td>{{ $client->address_1 }}</td>
			<td>{{ $client->city }}</td>
			<td>{{ $client->email }}</td>
			<td>{{ $client->phone }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@include('layouts._pdf_footer')
