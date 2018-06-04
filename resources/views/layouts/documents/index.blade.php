@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div><br>
        @endif
        @if(Auth()->user()->isAdmin())
            <div class="row">
                <div class="btn-toolbar-right">
                    <a href="{{ route('document_create', ['document_type' => $document_type]) }}" class="btn btn-info">{{ __('buttons.create_'. $document_type) }}</a>
                    <a href="{{ route('document_archived', ['document_type' => $document_type]) }}" class="btn btn-info">{{ __('buttons.archive') }}</a>
                </div>
            </div>
        @endif
        <h3>{{ __('headings.'. $document_type. '_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th>{{ __('global.files') }}</th>
                @if(Auth()->user()->isAdmin())
                    <th>{{ __('global.edit') }}</th>
                    <th>{{ __('global.delete') }}</th>
                    <th>{{ __('global.archive') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($documents as $document)
                @if(!Auth()->user()->isAdmin())
                    @php($ids = explode(',', $document->user_ids))
                    @if(!in_array(Auth()->user()->id, $ids))
                        @continue
                    @endif
                @endif
                <tr class="tableCenter">
                    <td>{{ $document->name }}</td>
                    <td><a href="javascript:void(0)" onclick="defModal('{{ route('document_ajax', ['document_type' => $document_type, 'document_id' => $document->id]) }}')"><i class="fas fa-file"></i></a></td>
                    @if(Auth()->user()->isAdmin())
                        <td><a href="{{ route('document_edit', ['document_type' => $document_type, 'document_id' => $document->id]) }}"><i class="fas fa-edit"></i></a></td>
                        <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.'. $document_type. '_delete') }}', '{{ __('buttons.delete')}}', '{{ route('document_delete', ['document_type' => $document_type, 'document_id' => $document->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                        <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.'. $document_type. '_archive') }}', '{{ __('buttons.archive')}}', '{{ route('document_archive', ['document_type' => $document_type, 'document_id' => $document->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="defModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection