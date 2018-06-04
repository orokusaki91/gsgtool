@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div><br>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div><br>
        @endif
        <div class="row">
            <div class="btn-toolbar-right">
                <a href="{{ route('warehouse_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.warehouse_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('validation.attributes.quantity') }}</th>
                <th>{{ __('global.edit') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($warehouses as $warehouse)
                <tr class="tableCenter">
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->quantity }}</td>
                    <td><a href="{{ route('warehouse_edit', ['warehouse_id' => $warehouse->id]) }}"><i class="fas fa-edit"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.warehouse_delete') }}', '{{ __('buttons.delete')}}', '{{ route('warehouse_delete', ['warehouse_id' => $warehouse->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection