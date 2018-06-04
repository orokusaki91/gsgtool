<legend>{{ __('headings.client_information') }}</legend>
{!! getTextFormGroup('text', 'name', $errors, 1, $client) !!}
{!! getSelectFormGroup('select', 'main_company_id', $errors, 0, $client, $companies) !!}
{!! getSelectFormGroupDB('select_db', 'staff_type', $errors, 0, $client ? $client->staff_type : null, $staff_types, 'role_name') !!}
{!! getTextFormGroup('text', 'username', $errors, 0, $client) !!}
{!! getTextFormGroup('text', 'password', $errors, 0, $client) !!}
{!! getFileFormGroup('file', 'logo', $errors, 0, $client, 0, 0) !!}
{!! getTextFormGroup('text', 'address_1', $errors, 0, $client) !!}
{!! getTextFormGroup('text', 'zip_code', $errors, 0, $client) !!}
{!! getTextFormGroup('text', 'city', $errors, 0, $client) !!}
{!! getTextFormGroup('text', 'phone', $errors, 0, $client) !!}
{!! getTextFormGroup('text', 'email', $errors, 0, $client) !!}
{!! getTextFormGroup('text', 'contact', $errors, 0, $client) !!}
{!! getTextareaFormGroup('textarea', 'info', $errors, 0, $client) !!}
