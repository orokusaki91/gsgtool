@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div><br>
        @endif
        <h3>{{ __('headings.'. $document_type. '_archived') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('global.delete') }}</th>
                <th>{{ __('global.un_archive') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($documents as $document)
                <tr class="tableCenter">
                    <td>{{ $document->name }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.'. $document_type. '_delete') }}', '{{ __('buttons.delete')}}', '{{ route('document_delete', ['document_type' => $document_type, 'document_id' => $document->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.'. $document_type. '_un_archive') }}', '{{ __('buttons.un_archive')}}', '{{ route('document_un_archive', ['document_type' => $document_type, 'document_id' => $document->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('layouts._confirmation_modal')
@endsection