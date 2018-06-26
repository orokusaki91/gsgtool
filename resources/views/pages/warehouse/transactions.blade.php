@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h3>{{ __('headings.warehouse_transactions_list') }}</h3>
        <div class="input-group input-daterange">
            <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="dd-mm-yyyy" placeholder="{{ __('global.from') }}">
            <div class="input-group-addon">{{ __('global.from') }}</div>
            <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="dd-mm-yyyy" placeholder="{{ __('global.from') }}">
        </div>
        <table id="transactionsTable">
            <thead>
                <tr>
                    <th>{{ __('validation.attributes.date') }}</th>
                    <th>{{ __('validation.attributes.name') }}</th>
                    <th>{{ __('buttons.input_output') }}</th>
                    <th>{{ __('buttons.output') }}</th>
                    <th>{{ __('validation.attributes.quantity') }}</th>
                    <th>{{ __('validation.attributes.warehouse_size') }}</th>
                    <th>{{ __('buttons.delete') }}</th>
                </tr>
            </thead>
            <tbody id="report_table">
                @foreach($whTransactions as $whTransaction)
                    <tr class="tableCenter">
                        <td>{{ \Carbon\Carbon::parse($whTransaction->created_at)->format('d-m-Y') }}</td>
                        <td>{{ $whTransaction->warehouse->name }}</td>
                        <td>{{ getArray('warehouse_type')[$whTransaction->warehouse_type] }}</td>
                        <td>{{ $whTransaction->user ? $whTransaction->user->firstname . ' ' . $whTransaction->user->lastname : '' }}</td>
                        <td>{{ abs($whTransaction->warehouse_qty) }}</td>
                        <td>{{ $whTransaction->warehouse_size ? $whTransaction->warehouse_size : '' }}</td>
                        <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.warehouse_transaction_delete') }}', '{{ __('buttons.delete')}}', '{{ route('warehouse_transactions_delete', ['warehouseTransaction' => $whTransaction->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('layouts._confirmation_modal')
@endsection

@section('per_page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
// Bootstrap datepicker
$('.input-daterange input').each(function() {
  $(this).datepicker('clearDates');
});

// Set up your table
table = $('#transactionsTable').DataTable({
    "scrollX": true,
    "bInfo" : false,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/"+'{{ __('global.data_table_lang') }}'+".json"
    }
});

// Extend dataTables search
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        var min = $('#min-date').val();
        var max = $('#max-date').val();
        var minDate = toDate(min);
        var maxDate = toDate(max);
        var createdAt = toDate(data[0]); // Our date column in the table

        if ((min == "" || max == "") || (moment(createdAt).isSameOrAfter(minDate) && moment(createdAt).isSameOrBefore(maxDate))) {
            return true;
        }

        return false;
    }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  table.draw();
});

$('#transactionsTable_filter').hide();
</script>
@stop
