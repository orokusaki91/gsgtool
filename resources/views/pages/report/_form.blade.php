{!! getSelectFormGroupDB('select_db', 'client_id', $errors, 1, $report ? $report->client_id : null, $clients, 'name', 0) !!}
{!! getDateFormGroup('date', 'date', $errors, 1, $report, 1) !!}
{!! getTextareaFormGroup('textarea', 'description', $errors, 1, $report) !!}