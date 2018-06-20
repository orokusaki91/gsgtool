<div class="form-group">
    <div class="col-md-1"></div>
    <label class="col-md-4 control-label text-left" for="<?=$field?>"><?=__('validation.attributes.'. $field). $required?></label>
    <div class="col-md-6">
        <textarea id="<?=$field?>" name="<?=$field?>" class="form-control input-md"><?=$value?></textarea>
        <span style="color:red;" class="form-error"><?=$errors->has($field) ? $errors->first($field) : ''?></span>
    </div>
</div>