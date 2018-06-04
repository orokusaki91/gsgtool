@if($document_type != 'receipt')
    <div class="row">
        @foreach($user_roles as $user_role)
            <div class="col-md-6">
                {!! getCheckboxFormGroup('checkbox', $user_role->role_name, $errors, $document) !!}
            </div>
        @endforeach
    </div>
    {!! getSelectFormGroupDB('select_db', 'users', $errors, 0, $document ? $document->user_ids : null, $users, ['firstname', 'lastname'], 1) !!}
@else
    {!! getSelectFormGroupDB('select_db', 'users', $errors, 1, $document ? $document->user_ids : null, $users, 'name', 1) !!}
@endif
{!! getTextFormGroup('text', 'name', $errors, 1, $document) !!}
{!! getTextareaFormGroup('textarea', 'text', $errors, 0, $document) !!}