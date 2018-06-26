<?php

function getArray($field){
    $arr = [];
    foreach(__('labels.'. $field) as $k => $v){
        $arr[$k] = $v;
    }
    return $arr;
}

function getTextFormGroup($file, $field, $errors, $required, $model, $extension = null){
    $value = '';
    if ($field != 'password' && $field != 're_password') {
        if($model) {
            $value = $model->$field;
        }
        if(old($field)){
            $value = old($field);
        }
    }
    $required = $required ? ' <font color="red">*</font>' : '';
    $extension = $extension ? $extension : '';
    $type = $field == 'password' || $field == 're_password' ? 'password' : 'text';
    ob_start();
    require base_path(). '/resources/views/layouts/forms/'. $file. '.php';
    $html = ob_get_clean();
    return $html;
}

function getSelectFormGroupDB($file, $field, $errors, $required, $select, $datas, $name_columns, $multiple = 0){
    if($select) {
        if($multiple) {
            $select = explode(',', $select);
        }
    }else{
        $select = '';
    }
    if(old($field)){
        $select = old($field);
    }
    $requiredIcon = $required ? ' <font color="red">*</font>' : '';
    $multipleAttr = $multiple ? 'multiple' : '';
    $multiple = $multiple ? '[]' : '';
    ob_start();
    require base_path(). '/resources/views/layouts/forms/'. $file. '.php';
    $html = ob_get_clean();
    return $html;
}

function getSelectFormGroup($file, $field, $errors, $required, $model, $datas, $multiple = 0){
    $select = '';
    if($model){
        $select = $model->$field;
        if($multiple){
            $select = explode(',', $select);
        }
    }
    if(old($field)){
        $select = old($field);
    }
    $requiredIcon = $required ? ' <font color="red">*</font>' : '';
    $multipleAttr = $multiple ? 'multiple' : '';
    $multiple = $multiple ? '[]' : '';
    ob_start();
    require base_path(). '/resources/views/layouts/forms/'. $file. '.php';
    $html = ob_get_clean();
    return $html;
}

function getDateFormGroup($file, $field, $errors, $required, $model, $time = 0){
    $value = '';
    if($model && $model->$field) {
        $value = $model->$field;
        $date_format = $time ? 'd-m-Y h:i' : 'd-m-Y';
        $value = date($date_format, strtotime($value));
    }
    if($errors->any()) {
        if(old($field)) {
            $value = old($field);
        }else{
            $value = '';
        }
    }
    $required = $required ? ' <font color="red">*</font>' : '';
    $class = $time ? 'datetime' : 'date';
    ob_start();
    require base_path(). '/resources/views/layouts/forms/'. $file. '.php';
    $html = ob_get_clean();
    return $html;
}

function getCheckboxFormGroup($file, $field, $errors, $model){
    $checked = 0;
    if($model && $model->$field) {
        $checked = 1;
    }
    if($errors->any()) {
        if (old($field) == 'on') {
            $checked = 1;
        } else {
            $checked = 0;
        }
    }
    $checked = $checked ? ' checked' : '';
    ob_start();
    require base_path(). '/resources/views/layouts/forms/'. $file. '.php';
    $html = ob_get_clean();
    return $html;
}

function getTextareaFormGroup($file, $field, $errors, $required, $model){
    $value = '';
    if($model) {
        $value = $model->$field;
    }
    if(old($field)){
        $value = old($field);
    }
    $required = $required ? ' <font color="red">*</font>' : '';
    ob_start();
    require base_path(). '/resources/views/layouts/forms/'. $file. '.php';
    $html = ob_get_clean();
    return $html;
}

function getFileFormGroup($file, $field, $errors, $required, $model, $multiple, $delete){
    $html = "";
    if($delete) {
        $html .= getCheckboxFormGroup('checkbox', 'delete_'. $field, $errors, $model);
    }
    $required = $required ? ' <font color="red">*</font>' : '';
    $multipleAttr = $multiple ? 'multiple' : '';
    $multiple = $multiple ? '[]' : '';
    ob_start();
    require base_path(). '/resources/views/layouts/forms/'. $file. '.php';
    $html .= ob_get_clean();
    return $html;
}

function getSelectedUsers($request){
    $users = '';
    if($request->users) {
        foreach ($request->users as $user) {
            $users .= $user . ',';
        }
    }
    $user_roles = App\Role::all();
    foreach($user_roles as $user_role){
        $role_name = $user_role->label;
        if($request->$role_name){
            $roles = App\UserRole::where('role_id', $user_role->id)->get();
            foreach($roles as $role){
                if(!in_array($role->user_id, explode(',', $users))) {
                    $users .= $role->user_id . ',';
                }
            }
        }
    }

    return rtrim($users, ',');
}

function getStringForUploadedDocuments($request, $model, $path){
    $string = '';
    if($model->documents){
        $string = $model->documents. '|,|';
    }
    foreach($request->documents as $file) {
        $hash = rand(1000, 9999);
        $route = $file->storeAs($path, $hash. '-'. $model->id . '-' . preg_replace('/\s+/', '_', $file->getClientOriginalName()));
        $string .= 'https://s3.eu-central-1.amazonaws.com/gsgtool/'. $route. '|,|';
    }
    $string = rtrim($string, '|,|');
    $string = str_replace(' ', '', $string);
    return $string;
}

function changeUserParametersAndPutInDB($request, $user = null){
    if($request->official_address){
        $request->merge(['official_address' => 1]);
    }else{
        $request->merge(['official_address' => 0]);
    }

    if($request->post_address){
        $request->merge(['post_address' => 1]);
    }else{
        $request->merge(['post_address' => 0]);
    }

    if($request->general){
        $request->merge(['general' => date('Y-m-d', strtotime($request->general))]);
    }

    if($request->birthdate){
        $request->merge(['birthdate' => date('Y-m-d', strtotime($request->birthdate))]);
    }

    if($request->wedding_date){
        $request->merge(['wedding_date' => date('Y-m-d', strtotime($request->wedding_date))]);
    }

    if($request->work_permit_date){
        $request->merge(['work_permit_date' => date('Y-m-d', strtotime($request->work_permit_date))]);
    }

    if($request->spoken_language) {
        $str = "";
        foreach ($request->spoken_language as $lang) {
            $str .= $lang . ',';
        }
        $request->merge(['spoken_language' => rtrim($str,",")]);
    }

    if($request->users) {
        $users = '';
        foreach ($request->users as $user_ids) {
            $request->merge(['users' => $users .= $user_ids . ',']);
        }
        $request->merge(['users' => rtrim($users, ',')]);
    }else{
        $request->merge(['users' => '']);
    }

    if($user){
        if ($request->password) {
            $request->merge(['password' => bcrypt($request->password)]);
        } else {
            $request->merge(['password' => $user->password]);
        }

        $user->update($request->all());

        if ($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->storeAs('/profile_pictures', $user->id. '-'. $file->getClientOriginalName());
            $user->profile_picture = 'https://s3.eu-central-1.amazonaws.com/gsgtool/'. $path;
            $user->save();
        }

        $userRoles = App\UserRole::where('user_id', $user->id)->first();
        if($userRoles) {
            $userRoles->role_id = $request->user_role;
            $userRoles->save();
        }
    }else{
        $request->merge(['password' => bcrypt($request->password)]);

        $user = App\User::create($request->all());

        if ($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->storeAs('/profile_pictures', $user->id. '-'. $file->getClientOriginalName());
            $profile_picture = 'https://s3.eu-central-1.amazonaws.com/gsgtool/'.$path;
        }

        if(isset($profile_picture)){
            $user->profile_picture = $profile_picture;
        }else{
            $user->profile_picture = '';
        }
        $user->save();

        App\UserRole::create(['user_id' => $user->id, 'role_id' => $request->user_role]);
    }

    if($request->delete_profile_picture){
        $user->profile_picture = '';
        $user->save();
    }
}

function getDocumentType($document_type){
    $classes = [
        'plan' => 'Plan',
        'news' => 'News',
        'media' => 'Media',
        'staff_document' => 'StaffDocument',
        'receipt' => 'Receipt',
        'theft' => 'Theft',
    ];
    return 'App\\'. $classes[$document_type];
}


function getMainOrganizerUsers($user) {
    return $user->users ? explode(',', $user->users) : [];
}

function checkPreviousUri($string) {
    return str_replace(url('/'), '', url()->previous()) != $string;
}


function getStaffPersonalDataColumns() {
    return ['firstname', 'lastname', 'nickname', 'general'];
}

function getStaffIDCardColumns() {
    return ['general', 'service_number', 'birthdate', 'address_1', 'address_2', 'zip_code', 'city', 'country', 'canton', 'official_address', 'post_address'];
}

function getStaffContactColumns() {
    return ['phone', 'mobile', 'email'];
}

function getStaffAdministrativeDataColumns() {
    return ['ahv', 'apartment', 'marital_status', 'wedding_date', 'nationality', 'work_permit', 'work_permit_date'];
}

function getStaffBankDataColumns() {
    return ['acc_type', 'iban', 'number_bank', 'number_post'];
}

function getStaffSkillsColumns() {
    return ['current_job', 'spoken_language'];
}

function getStaffOtherInfo() {
    return ['auto', 'driving_licence', 'height', 'trousers_size', 't_shirt_size', 'shoe_size'];
}

function getClientsPersonalDataColumns() {
    return ['name', 'username', 'address', 'zip_code', 'city'];
}

function getClientsAddressColumns() {
    return ['address_1', 'zip_code', 'city'];
}

function getClientsContactColumns() {
    return ['phone', 'email', 'contact'];
}

function getClientsInfoColumns() {
    return ['info'];
}