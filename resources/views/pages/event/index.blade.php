@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div><br>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div><br>
        @endif
        @if(Auth::user()->isAdmin())
            <div class="row">
                <div class="btn-toolbar-right">
                    <a href="{{ route('event_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
                    <a href="{{ route('event_old') }}" class="btn btn-info">{{ __('buttons.old') }}</a>
                </div>
            </div>
        @endif
        <h3>{{ __('headings.event_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.start') }}</th>
                <th>{{ __('validation.attributes.end') }}</th>
                <th>{{ __('validation.attributes.client') }}</th>
                <th>{{ __('validation.attributes.number') }}</th>
                <th>{{ __('validation.attributes.reserve') }}</th>
                @if($user->hasAnyRole(['Security', 'Guard', 'Detective', 'Main Organizer']))
                    <th>{{ __('validation.attributes.signup') }}</th>
                @endif
                @if(Auth::user()->isAdmin())
                    <th>{{ __('global.users') }}</th>
                    <th>{{ __('global.edit') }}</th>
                    <th>{{ __('global.close') }}</th>
                    <th>{{ __('global.delete') }}</th>
                @endif
            </tr>
            </thead>
            <tbody id="report_table">
                @foreach($events as $event)
                    <tr class="tableCenter">
                        <td>{{ Carbon\Carbon::parse($event->start)->format('d.m.Y H:i') }}</td>
                        <td>{{ Carbon\Carbon::parse($event->end)->format('d.m.Y H:i') }}</td>
                        <td>{{ $event->client->name }}</td>
                        <td>{{ $event->number }}</td>
                        <td>{{ $event->reserve }}</td>
                        @if($user->hasAnyRole(['Security', 'Guard', 'Detective', 'Main Organizer']))
                            <td>
                                @if($event->event_users()->where('user_id', $user->id)->where('status', 2)->exists())
                                    <form action="{{ route('event_user_signout', ['event_id' => $event->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        <button><i class="fas fa-sign-out-alt"></i></button>
                                    </form>
                                @elseif($event->event_users()->where('user_id', $user->id)->exists())
                                    {{ __('labels.already_signed_in') }}
                                @else
                                    <form action="{{ route('event_user_signup', ['event_id' => $event->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        <button><i class="fas fa-user-plus"></i></button>
                                    </form>
                                @endif
                            </td>
                        @endif
                        @if(Auth::user()->isAdmin())
                            <td><a href="{{ route('event_users', ['event_id' => $event->id]) }}"><i class="fas fa-users"></i></a></td>
                            <td><a href="{{ route('event_edit', ['event_id' => $event->id]) }}"><i class="fas fa-edit"></i></a></td>
                            <td>
                                @if(Carbon\Carbon::now() > $event->end)
                                <a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_close') }}', '{{ __('buttons.close')}}', '{{ route('event_close', ['event_id' => $event->id]) }}')"><i class="fas fa-times"></i></a>
                                @endif
                            </td>
                            <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_delete') }}', '{{ __('buttons.delete')}}', '{{ route('event_delete', ['event_id' => $event->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection