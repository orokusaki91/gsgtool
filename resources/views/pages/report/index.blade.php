@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div><br>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div><br>
        @endif
        <div class="row">
            <div class="btn-toolbar-right">
                <a href="{{ route('report_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
                <a href="{{ route('report_pdf') }}" class="btn btn-info">{{ __('buttons.save_as_pdf') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.report_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.date') }}</th>
                <th>{{ __('validation.attributes.client_id') }}</th>
                <th>{{ __('validation.attributes.user_id') }}</th>
                <th>{{ __('validation.attributes.description') }}</th>
                <th>{{ __('global.edit') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($reports as $report)
                @if($report->client && $report->user)
                    <tr class="tableCenter">
                        <td>{{ rtrim($report->date, ':00') }}</td>
                        <td>{{ $report->client->name }}</td>
                        <td>{{ $report->user->firstname. ' '. $report->user->lastname }}</td>
                        <td>{{ $report->description }}</td>
                        @if(Auth()->user()->isAdmin() || $report->user_id == Auth()->user()->id)
                            <td><a href="{{ route('report_edit', ['report_id' => $report->id]) }}"><i class="fas fa-edit"></i></a></td>
                            <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.report_delete') }}', '{{ __('buttons.delete')}}', '{{ route('report_delete', ['report_id' => $report->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                        @endif
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    @include('layouts._confirmation_modal')
@endsection