@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div><br>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div><br>
        @endif
        <h3>{{ __('headings.user_list') }}</h3>
        <p>{{ __('validation.attributes.description') }}: {{ $user_events[0]->event->description }}</p>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('global.status') }}</th>
                <th>{{ __('global.accept') }}</th>
                <th>{{ __('global.reserve') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($user_events as $user_event)
                <tr class="tableCenter">
                    <td>{{ $user_event->user->firstname. " ". $user_event->user->lastname }}</td>
                    <td>{{ __('labels.event_status.'. $user_event->status) }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_accept') }}', '{{ __('buttons.accept')}}', '{{ route('event_user_accept', ['event_user' => $user_event->id]) }}')"><i class="fas fa-check"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_reserve') }}', '{{ __('buttons.reserve')}}', '{{ route('event_user_reserve', ['event_user' => $user_event->id]) }}')"><i class="far fa-check-square"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_delete') }}', '{{ __('buttons.delete')}}', '{{ route('event_user_delete', ['event_user' => $user_event->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection