@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h3>{{ __('headings.user_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('global.accept') }}</th>
                <th>{{ __('global.reserve') }}</th>
                <th>{{ __('global.delete') }}</th>
                <th>{{ __('global.delete') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($users as $user)
                <tr class="tableCenter">
                    <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
                    <td>{{ $user->service_number }}</td>
                    <td>{{ $user->address_1 }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->roles[0]->role_name }}</td>
                    <td>
                        @if($event->hasUser($user->id))
                            <a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_unaccept') }}', '{{ __('buttons.accept')}}', '{{ route('event_user_unaccept', ['event_id' => $event->id, 'user_id' => $user->id]) }}')"><i class="fas fa-times"></i></a>
                        @else
                            <a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_user_accept') }}', '{{ __('buttons.accept')}}', '{{ route('event_user_store', ['event_id' => $event->id, 'user_id' => $user->id]) }}')"><i class="fas fa-check"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection