@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div><br>
        @endif
        <h3>{{ __('headings.archived_client_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('validation.attributes.address_1') }}</th>
                <th>{{ __('validation.attributes.city') }}</th>
                <th>{{ __('global.delete') }}</th>
                <th>{{ __('global.un_archive') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr class="tableCenter">
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->address_1 }}</td>
                    <td>{{ $client->city }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.client_delete') }}', '{{ __('buttons.delete')}}', '{{ route('client_delete', ['client_id' => $client->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.client_un_archive') }}', '{{ __('buttons.un_archive')}}', '{{ route('client_un_archive', ['client_id' => $client->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('layouts._confirmation_modal')
@endsection