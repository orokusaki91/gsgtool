@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="row">
            <div class="btn-toolbar-right">
                <a href="{{ route('warehouse_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
                <a href="{{ route('warehouse_returns') }}" class="btn btn-info">{{ __('buttons.returns') }}</a>
                <a href="{{ route('warehouse_transactions') }}" class="btn btn-info">{{ __('buttons.input_output') }}</a>
                <a href="{{ route('warehouse_staff_transactions') }}" class="btn btn-info">{{ __('buttons.staff') }}</a>
                <a href="{{ route('warehouse_products_transactions') }}" class="btn btn-info">{{ __('buttons.material') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.warehouse_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('validation.attributes.quantity') }}</th>
                <th>{{ __('global.input') }}</th>
                <th>{{ __('global.output') }}</th>
                <th>{{ __('global.edit') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($warehouses as $warehouse)
                <tr class="tableCenter">
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->wh_stock }}</td>
                    <td><a href="{{ route('warehouse_input', ['warehouse' => $warehouse->id]) }}"><i class="fas fa-sign-in-alt"></i></a></td>
                    <td><a href="{{ route('warehouse_output', ['warehouse' => $warehouse->id]) }}"><i class="fas fa-sign-out-alt"></i></a></td>
                    <td><a href="{{ route('warehouse_edit', ['warehouse' => $warehouse->id]) }}"><i class="fas fa-edit"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.warehouse_delete') }}', '{{ __('buttons.delete')}}', '{{ route('warehouse_delete', ['warehouse' => $warehouse->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
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