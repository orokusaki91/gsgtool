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
                <a href="{{ route('event_user_create', ['event_id' => $event->id]) }}" class="btn btn-info">{{ __('buttons.add_users') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.user_list') }}</h3>
        <p>{{ __('validation.attributes.description') }}: {{ $event->description }}</p>
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
            @foreach($event->event_users as $user)
                <tr class="tableCenter">
                    <td>{{ $user->firstname. " ". $user->lastname }}</td>
                    <td>{{ __('labels.event_status.'. $user->pivot->status) }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_accept') }}', '{{ __('buttons.accept')}}', '{{ route('event_user_accept', ['event_id' => $event->id, 'user_id' => $user->id]) }}')"><i class="fas fa-check"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_reserve') }}', '{{ __('buttons.reserve')}}', '{{ route('event_user_reserve', ['event_id' => $event->id, 'user_id' => $user->id]) }}')"><i class="far fa-check-square"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_delete') }}', '{{ __('buttons.delete')}}', '{{ route('event_user_delete', ['event_id' => $event->id, 'user_id' => $user->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection