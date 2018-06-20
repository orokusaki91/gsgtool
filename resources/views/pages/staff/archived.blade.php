@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <h3>{{ __('headings.archived_staff_list') }}</h3>
        <table id="myTable">
            <thead>
            <tr>
                <th>{{ __('validation.attributes.firstname') }}</th>
                <th>{{ __('validation.attributes.lastname') }}</th>
                <th>{{ __('validation.attributes.service_number') }}</th>
                <th>{{ __('validation.attributes.address_1') }}</th>
                <th>{{ __('validation.attributes.city') }}</th>
                <th>{{ __('validation.attributes.user_role') }}</th>
                <th>{{ __('global.delete') }}</th>
                <th>{{ __('global.un_archive') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="tableCenter">
                    <td>{{ $user->firstname }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->service_number }}</td>
                    <td>{{ $user->address_1 }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->role()->role_name }}</td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.staff_delete') }}', '{{ __('buttons.delete')}}', '{{ route('staff_delete', ['user_id' => $user->id]) }}')"><i class="fas fa-trash-alt"></i></a></td>
                    <td><a href="javascript:void(0)" onclick="confirmationModal('{{ __('messages.staff_un_archive') }}', '{{ __('buttons.un_archive')}}', '{{ route('staff_un_archive', ['user_id' => $user->id]) }}')"><i class="fas fa-file-archive"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('layouts._confirmation_modal')
@endsection