<div class="form-group">
    <div class="col-md-1"></div>
    <label class="col-md-4 control-label text-left" for="<?=$field?>"><?=__('validation.attributes.'. $field). $requiredIcon?></label>
    <div class="col-md-6">
        <select id="<?=$field?>" name="<?=$field. $multiple?>" class="form-control" <?=$multipleAttr?>>
            <?php
            if(!$required && !$multiple){
                ?>
                <option value="0"><?=trans('global.choose')?></option>
                <?php
            }
            foreach($datas as $k => $data){
                if(gettype($select) == 'string' || gettype($select) == 'integer') {
                    $selected = $k == $select ? ' selected' : '';
                }elseif(gettype($select) == 'array'){
                    $selected = in_array($k, $select) ? ' selected' : '';
                }
                ?>
                <option value="<?=$k?>"<?=$selected?>><?=$data?></option>
                <?php
            }
            ?>
        </select>
        <?php
        if($errors->has($field)) {
            ?>
            <span style="color:red;"><?=$errors->first($field)?></span>
            <?php
        }
        ?>
    </div>
</div>