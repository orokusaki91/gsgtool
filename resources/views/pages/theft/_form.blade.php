{!! getSelectFormGroupDB('select_db', 'client_id', $errors, 1, $theft ? $theft->client_id : null, $clients, 'name', 0) !!}
{!! getDateFormGroup('date', 'date', $errors, 1, $theft, 1) !!}
{!! getTextFormGroup('text', 'firstname', $errors, 1, $theft) !!}
{!! getTextFormGroup('text', 'lastname', $errors, 1, $theft) !!}
{!! getDateFormGroup('date', 'birthdate', $errors, 1, $theft) !!}
{!! getSelectFormGroup('select', 'nationality', $errors, 1, $theft, $countries) !!}
{!! getSelectFormGroup('select', 'gender', $errors, 1, $theft, getArray('gender')) !!}
{!! getTextFormGroup('text', 'goods', $errors, 1, $theft) !!}
{!! getTextFormGroup('text', 'price', $errors, 1, $theft) !!}
{!! getSelectFormGroup('select', 'damaged', $errors, 1, $theft, getArray('default_select')) !!}
{!! getTextareaFormGroup('textarea', 'description', $errors, 1, $theft) !!}