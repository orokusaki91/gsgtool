@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h3>{{ __('headings.event_archived') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.start') }}</th>
                <th>{{ __('validation.attributes.end') }}</th>
                <th>{{ __('validation.attributes.client') }}</th>
                <th>{{ __('global.un_archive') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($events as $event)
                <tr class="tableCenter">
                    <td>{{ rtrim($event->start, ':00') }}</td>
                    <td>{{ rtrim($event->end, ':00') }}</td>
                    <td>{{ $event->client->name }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_un_archive') }}', '{{ __('buttons.un_archive')}}', '{{ route('event_un_archive', ['event_id' => $event->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_delete') }}', '{{ __('buttons.delete')}}', '{{ route('event_delete', ['event_id' => $event->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection