@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.report_edit') }}</h3>
        <form class="form-horizontal" action="{{ route('report_update', ['report_id' => $report->id]) }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                @include('pages.report._form')
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection