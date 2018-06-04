@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.warehouse_edit') }}</h3><br>
        <form class="form-horizontal" action="{{ route('warehouse_update', ['warehouse_id' => $warehouse->id]) }}" method="post" enctype="multipart/form-data">
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            {{ csrf_field() }}
            <fieldset>
                {!! getTextFormGroup('text', 'name', $errors, 1, $warehouse) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection