@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.6/sweetalert2.min.css">
@stop

@section('content')
    <div class="container">
        <h3>{{ __('headings.warehouse_create') }}</h3>
        <form class="form-horizontal" action="{{ route('warehouse_returns_store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
				{!! getSelectFormGroupDB('select_db', 'staff', $errors, 1, null, $staff, ['firstname', 'lastname'], 0) !!}
				{!! getSelectFormGroupDB('select_db', 'warehouse_product', $errors, 1, null, [], 'name', 0) !!}
				{!! getSelectFormGroup('select', 'warehouse_size', $errors, 1, null, []) !!}
                {!! getTextFormGroup('text', 'warehouse_qty', $errors, 1, null, '(max. 0)') !!}
				{!! getSelectFormGroup('select', 'warehouse_depreciation', $errors, 1, null, getArray('warehouse_depreciation')) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
            </fieldset>
        </form>
    </div>
@endsection

@section('per_page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.6/sweetalert2.all.min.js"></script>
<script>
	var spanEl = $('label[for="warehouse_qty"]').find('span');
	$('#staff').select2().change(function () {
		$.ajax({
			url: '{{ route('warehouse_ajax_get_products') }}',
			data: {staff: $(this).val()},
			method: 'get',
			success: function (data) {
				// reset products and sizes
				$('#warehouse_product, #warehouse_size').find('option:gt(0)').remove();
				// set max qty to 0 whenever we choose the staff
				var text = spanEl.text().replace(new RegExp("\\d+", "g"), 0);
				spanEl.text(text);
				// loop throuh products and populate warehouse product select
				var whProducts = data.whProducts;
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
		var size = $('#warehouse_size').val();
		$.ajax({
			url: '{{ route('warehouse_ajax_get_sizes') }}',
			data: {warehouse_product: $(this).val(), staff: staff, warehouse_size: size},
			method: 'get',
			success: function (data) {
				$('#warehouse_size').find('option:gt(0)').remove();

				// set new max qty to the product without size
				var text = spanEl.text().replace(new RegExp("\\d+", "g"), data.sumQty);
				spanEl.text(text);

				var whSizes = data.whSizes;
				// show or hide sizes depending on if there are any sizes or not
				Array.isArray(whSizes) ? 
							$('#warehouse_size').closest('.form-group').hide() : 
							$('#warehouse_size').closest('.form-group').show();
				// loop throuh sizes and populate warehouse sizes select
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
		var staff = $('#staff').val();
		$.ajax({
			url: '{{ route('warehouse_ajax_get_qty') }}',
			data: {staff: staff, warehouse_size: $(this).val(), warehouse_product: warehouse},
			method: 'get',
			success: function (data) {
				// set new max qty to product with the selected size
				var text = spanEl.text().replace(new RegExp("\\d+", "g"), data.sumQty);
				spanEl.text(text);
			}
		});
	});

	$('form').submit(function (e) {
		var formData = $('form').serialize();
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '{{ route('warehouse_returns_store') }}',
            dataType: 'json',
            data: formData, 
        	success: function(data){
        		$('span.form-error').text('');
        		if (data.status == false) {
            		swal(
			            '{{ __('headings.error') }}',
			            '{{ Session::get('error') }}',
			            'error'
			        );
			        return false;
            	}

                window.location.href = '{{ route('warehouse') }}';
            },
            error: function (data) {
        		$('span.form-error').text('');
            	$.each(data.responseJSON.errors, function (key, val) {
                    var input = $('form').find('[name="'+ key +'"]');
                    input.closest('div').children('span:last-child').text(val);
                });
	        }
        });
	});
</script>
@stop