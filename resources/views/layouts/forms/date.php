<div class="form-group">
    <div class="col-md-1"></div>
    <label class="col-md-4 control-label text-left"><?=__('validation.attributes.'. $field). $required?></label>
    <div class="col-md-6">
        <input id="<?=$field?>" value="<?=$value?>" name="<?=$field?>" type="text" class="form-control <?=$class?>">
        <span class="input-group-addon">
            <span class="add-on"><i class="far fa-calendar-alt"></i></span>
        </span>
        <?php
        if($errors->has($field)) {
            ?>
            <span style="color:red;"><?=$errors->first($field)?></span>
            <?php
        }
        ?>
    </div>
</div>