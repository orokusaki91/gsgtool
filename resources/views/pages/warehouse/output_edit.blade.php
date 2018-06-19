@extends('layouts.app')

@section('content')
    <div class="container">
    	@if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div><br>
        @endif
        <h3>{{ __('headings.warehouse_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('warehouse_output_update', ['warehouse' => $warehouse->id]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
				{!! getSelectFormGroupDB('select_db', 'user_id', $errors, 1, null, $staff, ['firstname', 'lastname'], 0) !!}
				@if($warehouse->has_sizes)
					{!! getSelectFormGroup('select', 'warehouse_size', $errors, 1, null, $whSizes) !!}
				@endif
                {!! getTextFormGroup('text', 'warehouse_qty', $errors, 1, null, '(max. ' . $sumQty . ')') !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection

@section('per_page_scripts')
	<script>
		$('#warehouse_size').select2().change(function () {
			$.ajax({
				url: '{{ route('warehouse_ajax_sum_qty') }}',
				data: {size_id: $(this).val(), warehouse_id: '{{ $warehouse->id }}'},
				method: 'get',
				success: function (data) {
					var el = $('label[for="warehouse_qty"]').find('span');
					var text = el.text().replace(new RegExp("\\d+", "g"), data.sum);
					el.text(text);
				}
			});
		});
	</script>
@stop