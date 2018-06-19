{!! getSelectFormGroupDB('select_db', 'client_id', $errors, 1, $workingTime ? $workingTime->client->id : null, $clients, 'name', 0) !!}
{!! getDateFormGroup('date', 'check_in', $errors, 1, $workingTime, 1) !!}
{!! getDateFormGroup('date', 'check_out', $errors, 1, $workingTime, 1) !!}
{!! getSelectFormGroup('select', 'pause', $errors, 1, $workingTime, getArray('pause')) !!}
{!! getTextareaFormGroup('textarea', 'comment', $errors, 0, $workingTime) !!}
