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
                <a href="{{ route('theft_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
                <a href="{{ route('theft_pdf') }}" class="btn btn-info">{{ __('buttons.save_as_pdf') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.theft_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.date') }}</th>
                <th>{{ __('validation.attributes.user_id') }}</th>
                <th>{{ __('validation.attributes.client_id') }}</th>
                <th>{{ __('validation.attributes.firstname') }}</th>
                <th>{{ __('validation.attributes.lastname') }}</th>
                <th>{{ __('validation.attributes.birthdate') }}</th>
                <th>{{ __('validation.attributes.nationality') }}</th>
                <th>{{ __('validation.attributes.gender') }}</th>
                <th>{{ __('validation.attributes.goods') }}</th>
                <th>{{ __('validation.attributes.price') }}</th>
                <th>{{ __('validation.attributes.damaged') }}</th>
                <th>{{ __('validation.attributes.description') }}</th>
                <th>{{ __('global.files') }}</th>
                <th>{{ __('global.edit') }}</th>
                <th>{{ __('global.delete') }}</th>
            </tr>
            </thead>
            <tbody id="report_table">
            @foreach($thefts as $theft)
                @if($theft->client && $theft->user)
                    <tr class="tableCenter">
                        <td>{{ rtrim($theft->date, ':00') }}</td>
                        <td>{{ $theft->user->firstname. ' '. $theft->user->lastname }}</td>
                        <td>{{ $theft->client->name }}</td>
                        <td>{{ $theft->firstname }}</td>
                        <td>{{ $theft->lastname }}</td>
                        <td>{{ $theft->birthdate }}</td>
                        @php($nationality = $theft->nationality)
                        <td>{{ $countries[$nationality] }}</td>
                        <td>{{ __('labels.gender.'. $theft->gender) }}</td>
                        <td>{{ $theft->goods }}</td>
                        <td>{{ $theft->price }}</td>
                        <td>{{ __('labels.default_select.'. $theft->damaged) }}</td>
                        <td>{{ $theft->description }}</td>
                        <td><a href="javascript:void(0)" onclick="filesModal('{{ route('theft_ajax', ['document_id' => $theft->id]) }}')"><i class="fas fa-file"></i></a></td>
                        @if(Auth()->user()->isAdmin() || $theft->user_id == Auth()->user()->id)
                            <td><a href="{{ route('theft_edit', ['theft_id' => $theft->id]) }}"><i class="fas fa-edit"></i></a></td>
                            <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.theft_delete') }}', '{{ __('buttons.delete')}}', '{{ route('theft_delete', ['theft_id' => $theft->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                        @endif
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="filesModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection