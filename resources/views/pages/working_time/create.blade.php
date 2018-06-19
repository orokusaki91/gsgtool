@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.event_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('working_time_store') }}" method="post">
            {{ csrf_field() }}
            <fieldset>
                {!! getSelectFormGroupDB('select_db', 'user_id', $errors, 1, $workingTime ? $workingTime->user->id : null, $users, ['firstname', 'lastname'], 0) !!}
                @include('pages.working_time._form')
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection