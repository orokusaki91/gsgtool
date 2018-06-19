@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ __('headings.warehouse_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('warehouse_input_update', ['warehouse' => $warehouse->id]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
                @if($warehouse->has_sizes)
                    {!! getSelectFormGroup('select', 'warehouse_size', $errors, 1, null, getArray('warehouse_size')) !!}
                @endif
                {!! getTextFormGroup('text', 'warehouse_qty', $errors, 1, null) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection