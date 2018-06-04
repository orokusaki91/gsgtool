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
                <a href="{{ route('event_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
                <a href="{{ route('event_old') }}" class="btn btn-info">{{ __('buttons.old') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.event_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.start') }}</th>
                <th>{{ __('validation.attributes.end') }}</th>
                <th>{{ __('validation.attributes.client') }}</th>
                <th>{{ __('validation.attributes.number') }}</th>
                <th>{{ __('validation.attributes.reserve') }}</th>
                <th>{{ __('global.users') }}</th>
                <th>{{ __('global.edit') }}</th>
                <th>{{ __('global.close') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($events as $event)
                <tr class="tableCenter">
                    <td>{{ rtrim($event->start, ':00') }}</td>
                    <td>{{ rtrim($event->end, ':00') }}</td>
                    <td>{{ $event->client->name }}</td>
                    <td>{{ $event->number }}</td>
                    <td>{{ $event->reserve }}</td>
                    <td><a href="{{ route('event_users', ['event_id' => $event->id]) }}"><i class="fas fa-users"></i></a></td>
                    <td><a href="{{ route('event_edit', ['event_id' => $event->id]) }}"><i class="fas fa-edit"></i></a></td>
                    <td>
                        @if($event->end < date('Y-m-d H:i:s'))
                        <a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_close') }}', '{{ __('buttons.close')}}', '{{ route('event_close', ['event_id' => $event->id]) }}')"><i class="fas fa-times"></i></a>
                        @endif
                    </td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_delete') }}', '{{ __('buttons.delete')}}', '{{ route('event_delete', ['event_id' => $event->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection