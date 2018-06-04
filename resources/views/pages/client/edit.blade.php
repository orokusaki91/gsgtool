@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-horizontal" action="{{ route('client_update', ['client_id' => $client->id]) }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                @include('pages.client._form')
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection