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
                <a href="{{ route('working_time_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.event_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.start') }}</th>
                <th>{{ __('validation.attributes.end') }}</th>
                <th>{{ __('validation.attributes.user') }}</th>
                <th>{{ __('validation.attributes.client') }}</th>
                <th>{{ __('validation.attributes.numer') }}</th>
                <th>{{ __('validation.attributes.pause') }}</th>
                <th>{{ __('global.comment') }}</th>
                <th>{{ __('global.edit') }}</th>
                @if(Auth::user()->isAdmin())
                    <th>{{ __('global.delete') }}</th>
                @endif
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($workingTimes as $workingTime)
                <tr class="tableCenter">
                    <td>{{ Carbon\Carbon::parse($workingTime->check_in)->format('d.m.Y H:i') }}</td>
                    <td>{{ Carbon\Carbon::parse($workingTime->check_out)->format('d.m.Y H:i') }}</td>
                    <td>{{ $workingTime->user->firstname }} {{ $workingTime->user->lastname }}</td>
                    <td>{{ $workingTime->client->firstname }} {{ $workingTime->client->lastname }}</td>
                    <td>{{ Carbon\Carbon::parse($workingTime->check_out)->diff(Carbon\Carbon::parse($workingTime->check_in))->format('%H:%I') }}</td>
                    <td>{{ __('labels.pause.' . $workingTime->pause) }}</td>
                    <td>{{ $workingTime->comment }}</td>
                    <td><a href="{{ route('working_time_edit', ['workingTime' => $workingTime->id]) }}"><i class="fas fa-edit"></i></a></td>
                    @if(Auth::user()->isAdmin())
                        <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.event_delete') }}', '{{ __('buttons.delete')}}', '{{ route('working_time_delete', ['workingTime' => $workingTime->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection