@include('layouts._pdf_header')
<table class="theft-tablePdf">
	<thead>
		<tr>
			<th>{{ __('validation.attributes.date') }}</th>
			<th>{{ __('validation.attributes.user_id') }}</th>
			<th>{{ __('validation.attributes.client_id') }}</th>
			<th>{{ __('validation.attributes.firstname') }}</th>
			<th>{{ __('validation.attributes.lastname') }}</th>
			<th>{{ __('validation.attributes.birthdate') }}</th>
			<th>{{ __('validation.attributes.nationality') }}</th>
			<th>{{ __('validation.attributes.gender') }}</th>
			<th>{{ __('validation.attributes.goods') }}</th>
			<th>{{ __('validation.attributes.price') }}</th>
			<th>{{ __('validation.attributes.damaged') }}</th>
			<th>{{ __('validation.attributes.description') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($thefts as $theft) @if($theft->client && $theft->user)
		<tr class="tableCenter">
			<td>{{ rtrim($theft->date, ':00') }}</td>
			<td>{{ $theft->user->firstname. ' '. $theft->user->lastname }}</td>
			<td>{{ $theft->client->name }}</td>
			<td>{{ $theft->firstname }}</td>
			<td>{{ $theft->lastname }}</td>
			<td>{{ $theft->birthdate }}</td>
			<td>{{ $theft->nationality }}</td>
			<td>{{ $theft->gender }}</td>
			<td>{{ $theft->goods }}</td>
			<td>{{ $theft->price }}</td>
			<td>{{ $theft->damaged }}</td>
			<td>{{ $theft->description }}</td>
		</tr>
		@endif @endforeach
	</tbody>
</table>
@include('layouts._pdf_footer')
