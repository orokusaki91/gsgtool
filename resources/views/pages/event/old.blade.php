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
                <a href="{{ route('event_archived') }}" class="btn btn-info">{{ __('buttons.archived') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.event_old') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.start') }}</th>
                <th>{{ __('validation.attributes.end') }}</th>
                <th>{{ __('validation.attributes.client') }}</th>
                <th>{{ __('global.archive') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($events as $event)
                <tr class="tableCenter">
                    <td>{{ rtrim($event->start, ':00') }}</td>
                    <td>{{ rtrim($event->end, ':00') }}</td>
                    <td>{{ $event->client->name }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_archive') }}', '{{ __('buttons.archive')}}', '{{ route('event_archive', ['event_id' => $event->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_delete') }}', '{{ __('buttons.delete')}}', '{{ route('event_delete', ['event_id' => $event->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection