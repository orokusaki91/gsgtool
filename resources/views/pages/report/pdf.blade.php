@include('layouts._pdf_header')
<table class="report-tablePdf">
	<thead>
		<tr>
			<th>{{ __('validation.attributes.date') }}</th>
			<th>{{ __('validation.attributes.client_id') }}</th>
			<th>{{ __('validation.attributes.user_id') }}</th>
			<th>{{ __('validation.attributes.description') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($reports as $report) @if($report->client && $report->user)
		<tr>
			<td>{{ rtrim($report->date, ':00') }}</td>
			<td>{{ $report->client->name }}</td>
			<td>{{ $report->user->firstname. ' '. $report->user->lastname }}</td>
			<td>{{ $report->description }}</td>
		</tr>
		@endif @endforeach
	</tbody>
</table>
@include('layouts._pdf_footer')
