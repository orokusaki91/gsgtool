<legend>{{ __('headings.login_information') }}</legend>
{!! getTextFormGroup('text', 'username', $errors, 1, $user) !!}
{!! getTextFormGroup('text', 'password', $errors, $user ? 0 : 1, $user) !!}
{!! getTextFormGroup('text', 're_password', $errors, $user ? 0 : 1, $user) !!}

<legend>{{ __('headings.profile_picture') }}</legend>
{!! getFileFormGroup('file', 'profile_picture', $errors, 0, $user, 0, 1) !!}

<legend>{{ __('headings.personal_data') }}</legend>
{!! getTextFormGroup('text', 'firstname', $errors, 1, $user) !!}
{!! getTextFormGroup('text', 'lastname', $errors, 1, $user) !!}
{!! getTextFormGroup('text', 'nickname', $errors, 0, $user) !!}
@if(Auth()->user()->isAdmin())
    {!! getSelectFormGroupDB('select_db', 'user_role', $errors, 1, $user ? $user->role()->id : null, $user_roles, 'role_name') !!}
@endif
<legend>{{ __('headings.id_card') }}</legend>
{!! getDateFormGroup('date', 'general', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'service_number', $errors, 0, $user) !!}
{!! getDateFormGroup('date', 'birthdate', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'address_1', $errors, 1, $user) !!}
{!! getTextFormGroup('text', 'address_2', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'zip_code', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'city', $errors, 0, $user) !!}
{!! getSelectFormGroup('select', 'country', $errors, 1, $user, $countries) !!}
{!! getSelectFormGroup('select', 'canton', $errors, 1, $user, getArray('canton')) !!}
{!! getCheckboxFormGroup('checkbox', 'official_address', $errors, $user) !!}
{!! getCheckboxFormGroup('checkbox', 'post_address', $errors, $user) !!}

<legend>{{ __('headings.contact') }}</legend>
{!! getTextFormGroup('text', 'phone', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'mobile', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'email', $errors, 1, $user) !!}

<legend>{{ __('headings.administrative_data') }}</legend>
{!! getTextFormGroup('text', 'ahv', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'apartment', $errors, 0, $user) !!}
{!! getSelectFormGroup('select', 'marital_status', $errors, 1, $user, getArray('marital_status')) !!}
{!! getDateFormGroup('date', 'wedding_date', $errors, 1, $user) !!}
{!! getSelectFormGroup('select', 'nationality', $errors, 1, $user, $countries) !!}
{!! getSelectFormGroup('select', 'work_permit', $errors, 1, $user, getArray('work_permit')) !!}
{!! getDateFormGroup('date', 'work_permit_date', $errors, 1, $user) !!}

<legend>{{ __('headings.bank_data') }}</legend>
{!! getSelectFormGroup('select', 'acc_type', $errors, 1, $user, getArray('acc_type')) !!}
{!! getTextFormGroup('text', 'iban', $errors, 0, $user) !!}
{!! getTextFormGroup('text', 'number_bank', $errors, 1, $user) !!}
{!! getTextFormGroup('text', 'number_post', $errors, 1, $user) !!}

<legend>{{ __('headings.skills_and_qualifications') }}</legend>
{!! getSelectFormGroup('select', 'current_job', $errors, 0, $user, getArray('current_job')) !!}
{!! getSelectFormGroup('select', 'spoken_language', $errors, 0, $user, getArray('spoken_language'), 1) !!}

<legend>{{ __('headings.other_info') }}</legend>
{!! getSelectFormGroup('select', 'auto', $errors, 0, $user, getArray('default_select')) !!}
{!! getSelectFormGroup('select', 'driving_license', $errors, 0, $user, getArray('default_select')) !!}
{!! getTextFormGroup('text', 'height', $errors, 0, $user) !!}
{!! getSelectFormGroup('select', 'trousers_size', $errors, 0, $user, getArray('trousers_size')) !!}
{!! getSelectFormGroup('select', 't_shirt_size', $errors, 0, $user, getArray('t_shirt_size')) !!}
{!! getTextFormGroup('text', 'shoe_size', $errors, 0, $user) !!}
@if(Auth()->user()->isAdmin() && $user && $user->isMainOrganizer())
    {!! getSelectFormGroupDB('select_db', 'users', $errors, 0, $user ? $user->users : null, $users, ['firstname', 'lastname'], 1) !!}
@endif