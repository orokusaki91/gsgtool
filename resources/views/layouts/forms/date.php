<div class="form-group">
    <div class="col-md-1"></div>
    <label class="col-md-4 control-label text-left"><?=__('validation.attributes.'. $field). $required?></label>
    <div class="col-md-6">
        <input id="<?=$field?>" value="<?=$value?>" name="<?=$field?>" type="text" class="form-control <?=$class?>">
        <span class="input-group-addon">
            <span class="add-on"><i class="far fa-calendar-alt"></i></span>
        </span>
        <span style="color:red;" class="form-error"><?=$errors->has($field) ? $errors->first($field) : ''?></span>
    </div>
</div>