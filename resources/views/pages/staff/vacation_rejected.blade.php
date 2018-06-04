@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <h3>{{ __('headings.vacation_rejected') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.user') }}</th>
                <th>{{ __('validation.attributes.type') }}</th>
                <th>{{ __('validation.attributes.start') }}</th>
                <th>{{ __('validation.attributes.end') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vacationRejected as $vacation)
                <tr class="tableCenter">
                    <td>{{ $vacation->user->firstname. ' '. $vacation->user->lastname }}</td>
                    <td>{{ __('labels.vacation_type.'. $vacation->type) }}</td>
                    <td>{{ $vacation->start }}</td>
                    <td>{{ $vacation->end }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.vacation_delete') }}', '{{ __('buttons.delete')}}', '{{ route('staff_vacation_delete', ['vacation_id' => $vacation->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('layouts._confirmation_modal')
@endsection