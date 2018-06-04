@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.'. $document_type. '_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('document_store', ['document_type' => $document_type]) }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                @include('layouts.documents._form')
                {!! getFileFormGroup('file', 'documents', $errors, 1, $document, 1, 0) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection