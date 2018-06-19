@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.warehouse_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('warehouse_input_update', ['warehouse' => $warehouse->id]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
                {!! getTextFormGroup('text', 'warehouse_qty', $errors, 1, null) !!}
				{!! getSelectFormGroup('select', 'warehouse_size', $errors, 0, null, getArray('warehouse_size')) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection