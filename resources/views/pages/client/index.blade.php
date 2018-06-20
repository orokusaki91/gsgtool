@extends('layouts.app')

@section('content')

    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="row">
            <div class="btn-toolbar-right">
                <a href="{{ route('client_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
                <a href="{{ route('client_archived') }}" class="btn btn-info">{{ __('buttons.archive') }}</a>
                <a href="{{ route('document_list', ['document_type' => 'receipt']) }}" class="btn btn-info">{{ __('buttons.receipt') }}</a>
                <a href="{{ route('client_pdf') }}" class="btn btn-info">{{ __('buttons.save_as_pdf') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.client_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('validation.attributes.address_1') }}</th>
                <th>{{ __('validation.attributes.city') }}</th>
                <th>{{ __('global.receipts') }}</th>
                <th>{{ __('global.edit') }}</th>
                <th>{{ __('global.delete') }}</th>
                <th>{{ __('global.archive') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr class="tableCenter">
                    <td><a href="javascript:void(0)" onclick="defModal('{{ route('client_show', ['client_id' => $client->id]) }}')">{{ $client->name }}</a></td>
					<td>{{ $client->address_1 }}</td>
                    <td>{{ $client->city }}</td>
                    <td><a href="{{ route('document_list', ['document_type' => 'receipt', 'user_id' => $client->id]) }}"><i class="fas fa-file"></i></a></td>
                    <td><a href="{{ route('client_edit', ['client_id' => $client->id]) }}"><i class="fas fa-edit"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.client_delete') }}', '{{ __('buttons.delete')}}', '{{ route('client_delete', ['client_id' => $client->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.client_archive') }}', '{{ __('buttons.archive')}}', '{{ route('client_archive', ['client_id' => $client->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="defModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection