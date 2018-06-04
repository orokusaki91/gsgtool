@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="row">
            <div class="btn-toolbar">
                <a href="{{ route('staff_vacation_create') }}" class="btn btn-info">{{ __('buttons.create_vacation') }}</a><br><br>
            </div>
        </div>
        <h3>{{ __('headings.vacation_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.type') }}</th>
                <th>{{ __('validation.attributes.start') }}</th>
                <th>{{ __('validation.attributes.end') }}</th>
                <th>{{ __('global.message') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vacations as $vacation)
                <tr class="tableCenter">
                    <td>{{ __('labels.vacation_type.'. $vacation->type) }}</td>
                    <td>{{ date('d-m-Y', strtotime($vacation->start)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($vacation->end)) }}</td>
                    <td>{{ __('messages.vacation.'. $vacation->approved) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection