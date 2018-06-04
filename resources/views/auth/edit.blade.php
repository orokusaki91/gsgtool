@extends('layouts.app') @section('content')
<div class="container">
	<form class="form-horizontal" action="{{ route('profile_update') }}" method="post" enctype="multipart/form-data">
		@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
		@endif
		<div class="row">
			<div class="btn-toolbar-right edit">
				<a href="{{ route('document_list', ['document_type' => 'staff_document']) }}" class="btn btn-info">{{ __('buttons.documents') }}</a>
				<a href="{{ route('staff_vacation_personal') }}" class="btn btn-info">{{ __('buttons.vacation') }}</a>
			</div>
		</div>
		{{ csrf_field() }}
		<fieldset>
			@include('pages.staff._form')
			<button type="submit" class="submit-btn btn btn-primary">{{ __('buttons.save') }}</button>
		</fieldset>
	</form>
</div>
@endsection @section('per_page_scripts') @include('pages.staff._form_scripts') @endsection
