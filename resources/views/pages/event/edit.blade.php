@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.event_edit') }}</h3><br>
        <form class="form-horizontal" action="{{ route('event_update', ['event_id' => $event->id]) }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                @include('pages.event._form')
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection