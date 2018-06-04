@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.theft_edit') }}</h3><br>
        <form class="form-horizontal" action="{{ route('theft_update', ['theft_id' => $theft->id]) }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                @include('pages.theft._form')
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection