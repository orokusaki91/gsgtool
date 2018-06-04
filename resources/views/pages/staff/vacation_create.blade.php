@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.vacation_create') }}</h3>
        <form class="form-horizontal" action="{{ route('staff_vacation_store') }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            {{ csrf_field() }}
            @if(Auth()->user()->isAdmin())
                {!! getSelectFormGroupDB('select_db', 'user_id', $errors, 1, $vacation ? $vacation->user_id : null, $users, ['firstname', 'lastname'], 0) !!}
            @endif
            {!! getSelectFormGroup('select', 'type', $errors, 1, $vacation, getArray('vacation_type')) !!}
            {!! getDateFormGroup('date', 'start', $errors, 1, $vacation) !!}
            {!! getDateFormGroup('date', 'end', $errors, 1, $vacation) !!}
            <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
        </form>
    </div>
@endsection