@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.working_time_edit') }}</h3>
        <form class="form-horizontal" action="{{ route('working_time_update', ['workingTime' => $workingTime->id]) }}" method="post">
            {{ csrf_field() }}
            <fieldset>
                @include('pages.working_time._form')
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection