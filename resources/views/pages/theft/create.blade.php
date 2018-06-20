@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.theft_create') }}</h3>
        <form class="form-horizontal" action="{{ route('theft_store') }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                @include('pages.theft._form')
                {!! getFileFormGroup('file', 'documents', $errors, 0, $theft, 1, 0) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection