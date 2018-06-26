@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <form class="form-horizontal" action="{{ route('warehouse_staff_transactions') }}" method="get">
            <fieldset>
                {!! getSelectFormGroupDB('select_db', 'staff_id', $errors, 0, $staff_id ? $staff_id : null, $staff, ['firstname', 'lastname'], 0) !!}
                <button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.submit') }}</button>
            </fieldset>
        </form>
        <h3>{{ __('headings.warehouse_transactions_list') }}</h3>
        @if($whProducts->count() > 0)
			<table id="myTable">
	            <thead>
	                <tr>
	                	<th></th>
	                    <th>{{ __('validation.attributes.name') }}</th>
	                    <th>{{ __('validation.attributes.quantity') }}</th>
	                </tr>
	            </thead>
		        <tbody id="report_table">
		        	@php $products = []; @endphp
                	@foreach($whProducts as $whProduct)
						<tr class="tableCenter">
							@if($whProduct->has_sizes)
								<td class="details-control">{{ __('global.open') }}</td>
							@else
								<td></td>
							@endif
	                        <td>{{ $whProduct->name }}</td>
	                        <td>{{ abs($whProduct->transactions()->where('user_id', $staff_id)->sum('warehouse_qty')) }}</td>
	                    </tr>
	                    @if(!in_array($whProduct, $products) && $whProduct->has_sizes)
							<tr class="is-hidden sub-table">
								<td>
									<table>
										<thead>
											<th>{{ __('validation.attributes.warehouse_size') }}</th>
											<th>{{ __('global.owns') }}</th>
										</thead>
										<tbody>
											@php $sizes = []; @endphp
											@foreach($whProduct->transactions as $whTransaction)
												@if(!in_array($whTransaction->warehouse_size, $sizes))
													@php 
														$sumQty = abs($whTransaction->where('warehouse_type', '!=', 1)
																				->where('user_id', $staff_id)
																				->where('warehouse_size', $whTransaction->warehouse_size)
																				->sum('warehouse_qty')); 
													@endphp
													@if($sumQty > 0)
														<tr>
															<td>{{ getArray('warehouse_size')[$whTransaction->warehouse_size] }}</td>
															<td>{{ $sumQty }}</td>
														</tr>
													@endif
												@endif
												@php
													$sizes[] = $whTransaction->warehouse_size;
												@endphp
											@endforeach
										</tbody>
									</table>
								</td>
								<td></td>
								<td></td>
							</tr>
	                    @endif
	                    @php $products[] = $whProduct; @endphp
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
    $('#myTable tbody').on('click', 'td.details-control', function () {
        var subTable = $(this).closest('tr').next('.sub-table');
     	subTable.toggle();
    });
    </script>
@stop
