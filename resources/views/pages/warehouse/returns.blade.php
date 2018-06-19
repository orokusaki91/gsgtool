@extends('layouts.app')

@section('content')
    <div class="container">
    	@if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div><br>
        @endif
        <h3>{{ __('headings.warehouse_create') }}</h3><br>
        <form class="form-horizontal" action="{{ route('warehouse_returns_store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
				{!! getSelectFormGroupDB('select_db', 'staff', $errors, 1, null, $staff, ['firstname', 'lastname'], 0) !!}
				{!! getSelectFormGroupDB('select_db', 'warehouse_product', $errors, 1, null, [], 'name', 0) !!}
				{!! getSelectFormGroup('select', 'warehouse_size', $errors, 0, null, []) !!}
                {!! getTextFormGroup('text', 'warehouse_qty', $errors, 1, null, '(max. 0)') !!}
				{!! getSelectFormGroup('select', 'warehouse_depreciation', $errors, 1, null, getArray('warehouse_depreciation')) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection

@section('per_page_scripts')
	<script>
		$('#staff').select2().change(function () {
			$.ajax({
				url: '{{ route('warehouse_ajax_get_products') }}',
				data: {staff_id: $(this).val()},
				method: 'get',
				success: function (data) {
					var whProducts = data.whProducts;
					$('#warehouse_product').find('option:gt(0)').remove();
					for (i = 0; i < whProducts.length; i++) {
						var product = whProducts[i];
						$('<option>', {
							value: product.id,
							text: product.name
						}).appendTo($('#warehouse_product'));
					}
				}
			});
		});

		$('#warehouse_product').select2().change(function () {
			var staff = $('#staff').val();
			$.ajax({
				url: '{{ route('warehouse_ajax_get_sizes') }}',
				data: {warehouse_id: $(this).val(), staff_id: staff},
				method: 'get',
				success: function (data) {
					$('#warehouse_size').find('option:gt(0)').remove();
					var whSizes = data.whSizes;

					var el = $('label[for="warehouse_qty"]').find('span');
					var text = el.text().replace(new RegExp("\\d+", "g"), data.sumQty);
					el.text(text);

					for (var key in whSizes) {
						$('<option>', {
							value: key,
							text: whSizes[key]
						}).appendTo($('#warehouse_size'));
					}
				}
			});
		});

		$('#warehouse_size').select2().change(function () {
			var warehouse = $('#warehouse_product').val();
			$.ajax({
				url: '{{ route('warehouse_ajax_get_qty') }}',
				data: {size_id: $(this).val(), warehouse_id: warehouse},
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