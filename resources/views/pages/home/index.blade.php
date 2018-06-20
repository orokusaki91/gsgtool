@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h3>{{ __('headings.event_list') }}</h3>
        <table id="eventsTable">
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
                    </tr>
                @endforeach
            </tbody>
        </table>
		<!-- News -->
        <h3>{{ __('headings.news_list') }}</h3>
        <table id="newsTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('global.files') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($documents as $document)
                @if(!Auth()->user()->isAdmin())
                    @php($ids = explode(',', $document->user_ids))
                    @if(!in_array(Auth()->user()->id, $ids))
                        @continue
                    @endif
                @endif
                <tr class="tableCenter">
                    <td>{{ $document->name }}</td>
                    <td><a href="javascript:void(0)" onclick="defModal('{{ route('document_ajax', ['document_type' => 'news', 'document_id' => $document->id]) }}')"><i class="fas fa-file"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    <div id="defModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection