@extends('layouts.app')

@section('content')
    <div class="container main">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="row">
            <div class="btn-toolbar-right">
				<a href="{{ route('staff_create') }}" class="btn btn-info">{{ __('buttons.create') }}</a>
				<a href="{{ route('staff_archived') }}" class="btn btn-info">{{ __('buttons.archive') }}</a>
				<a href="{{ route('document_list', ['document_type' => 'staff_document']) }}" class="btn btn-info">{{ __('buttons.documents') }}</a>
				<a href="{{ route('staff_vacation') }}" class="btn btn-info">{{ __('buttons.vacation') }}</a>
				<a href="{{ route('staff_pdf') }}" class="btn btn-info">{{ __('buttons.save_as_pdf') }}</a>
            </div>
        </div>
        <h3>{{ __('headings.staff_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.firstname') }}</th>
                <th>{{ __('validation.attributes.lastname') }}</th>
                <th>{{ __('validation.attributes.service_number') }}</th>
                <th>{{ __('validation.attributes.address_1') }}</th>
                <th>{{ __('validation.attributes.city') }}</th>
                <th>{{ __('validation.attributes.user_role') }}</th>
                <th>{{ __('global.documents') }}</th>
                <th>{{ __('global.edit') }}</th>
                <th>{{ __('global.delete') }}</th>
                <th>{{ __('global.archive') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="tableCenter">
                    <td><a href="javascript:void(0)" onclick="defModal('{{ route('staff_show', ['user_id' => $user->id]) }}')">{{ $user->firstname }}</a></td>
                    <td><a href="javascript:void(0)" onclick="defModal('{{ route('staff_show', ['user_id' => $user->id]) }}')">{{ $user->lastname }}</a></td>
                    <td>{{ $user->service_number }}</td>
                    <td>{{ $user->address_1 }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->role()->role_name }}</td>
                    <td><a href="{{ route('document_list', ['document_type' => 'staff_document', 'user_id' => $user->id]) }}"><i class="fas fa-file"></i></a></td>
                    <td><a href="{{ route('staff_edit', ['user_id' => $user->id]) }}"><i class="fas fa-edit"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.staff_delete') }}', '{{ __('buttons.delete')}}', '{{ route('staff_delete', ['user_id' => $user->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.staff_archive') }}', '{{ __('buttons.archive')}}', '{{ route('staff_archive', ['user_id' => $user->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="defModal" class="confirmation-modal" style="display: none"></div>
    @include('layouts._confirmation_modal')
@endsection