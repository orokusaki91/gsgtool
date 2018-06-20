<div class="form-group">
    <div class="col-md-1"></div>
    <label class="col-md-4 control-label text-left" for="<?=$field?>"><?=__('validation.attributes.'. $field) . $required?>
        <?php if ($extension): ?>
            <span><?= $extension ?></span>
        <?php endif ?>
    </label>
    <div class="col-md-6">
        <input id="<?=$field?>" value="<?=$value?>" name="<?=$field?>" type="<?=$type?>" class="form-control input-md">
        <span style="color:red;" class="form-error"><?=$errors->has($field) ? $errors->first($field) : ''?></span>
    </div>
</div>