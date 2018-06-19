@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.event_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('event_store') }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                <div class="row">
                    @foreach($user_roles as $user_role)
                        <div class="col-md-6">
                            {!! getCheckboxFormGroup('checkbox', $user_role->label, $errors, $event) !!}
                        </div>
                    @endforeach
                </div>
                {!! getSelectFormGroupDB('select_db', 'client_id', $errors, 1, $event ? $event->client : null, $clients, 'name', 0) !!}
                @include('pages.event._form')
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection