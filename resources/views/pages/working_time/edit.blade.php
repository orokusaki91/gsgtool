@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.event_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('working_time_update', ['workingTime' => $workingTime->id]) }}" method="post">
            {{ csrf_field() }}
            <fieldset>
                @include('pages.working_time._form')
                @can('store_wt')
                    <a href="#">Store Working Time</a>
                @endcan
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection