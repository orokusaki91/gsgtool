<div class="form-group">
    <div class="col-md-1"></div>
    <label class="col-md-4 control-label text-left"><?=__('validation.attributes.'. $field). $required?></label>
    <div class="col-md-6 text-center">
        <input id="<?=$field?>" name="<?=$field. $multiple?>" type="file" class="form-control input-md" <?=$multipleAttr?>>
        <?php
        foreach($errors->all() as $error){
            if(strpos($error, 'file of type') !== false){
                ?>
                <span style="color:red;"><?=$error?></span>
                <?php
                break;
            }
        }
        if($errors->has($field)) {
            ?>
            <span style="color:red;"><?=$errors->first($field)?></span>
            <?php
        }
        ?>
    </div>
</div>