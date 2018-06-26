@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <form class="form-horizontal" action="{{ route('warehouse_products_transactions') }}" method="get">
            <fieldset>
                {!! getSelectFormGroupDB('select_db', 'product_id', $errors, 0, $product_id ? $product_id : null, $whProducts, 'name', 0) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.submit') }}</button>
            </fieldset>
        </form>
        <h3>{{ __('headings.warehouse_transactions_list') }}</h3>
        @if($whTransactions->count() > 0)
			<table id="myTable">
	            <thead>
	                <tr>
	                    <th>{{ __('validation.attributes.staff') }}</th>
	                    <th>{{ __('validation.attributes.warehouse_size') }}</th>
	                    <th>{{ __('validation.attributes.quantity') }}</th>
	                </tr>
	            </thead>
		        <tbody id="report_table">
                	@foreach($whTransactions as $whTransaction)
                		@php 
                			$user = $whTransaction->user ? $whTransaction->user : ''; 
                			$size = $whTransaction->warehouse_size ? $whTransaction->warehouse_size : ''; 
                		@endphp
						<tr class="tableCenter">
							@if($user)
								<td>{{ $user->firstname . ' ' . $user->lastname }}</td>
								@if($size)
		                        	<td>{{ getArray('warehouse_size')[$size] }}</td>
		                        	<td>{{ abs($whTransaction->where('warehouse_type', '!=', 1)
		                        							->where('warehouse_size', $size)
		                        							->sum('warehouse_qty')) }}</td>
								@else
		                        	<td>{{ $size }}</td>
		                        	<td>{{ abs(App\WarehouseTransaction::where('warehouse_id', $whProduct->id)
				                        							->where('warehouse_type', '!=', 1)
				                        							->where('user_id', $user->id)
				                        							->sum('warehouse_qty')) }}</td>
								@endif
							@else
								<td>{{ __('labels.warehouse') }}</td>
								@if($size)
		                        	<td>{{ getArray('warehouse_size')[$size] }}</td>x
		                        	<td>{{ abs($whTransaction->where('warehouse_type', '=', 1)
			                        							->where('warehouse_size', $size)
			                        							->sum('warehouse_qty')) }}</td>
								@else
		                        	<td>{{ $size }}</td>
		                        	<td>{{ abs(App\WarehouseTransaction::where('warehouse_id', $whProduct->id)->sum('warehouse_qty')) }}</td>
								@endif
							@endif
		                </tr>
	                @endforeach
		        </tbody>
	        </table>
	    @else
        	<h3>{{ __('headings.no_results_found') }}</h3>
        @endif
    </div>
    @include('layouts._confirmation_modal')
@endsection

@section('per_page_scripts')
    <script>
    // Add event listener for opening and closing details
    $('#myTable tbody').on('click', 'td.details-control', function () {
        var subTable = $(this).closest('tr').next('.sub-table');
     	subTable.toggle();
    });
    </script>
@stop
