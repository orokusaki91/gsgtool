<div class="form-group">
    <div class="col-md-1"></div>
    <label class="col-md-4 control-label text-left" for="<?=$field?>"><?=__('validation.attributes.'. $field). $requiredIcon?></label>
    <div class="col-md-6">
        <select id="<?=$field?>" name="<?=$field. $multiple?>" class="form-control" <?=$multipleAttr?>>
                <option value="0"><?=__('global.choose')?></option>';
            
            <?php
            // if(!$required && !$multiple){
            // }
            foreach($datas as $data){
                if(gettype($select) == 'string' || gettype($select) == 'integer') {
                    $selected = $data->id == $select ? ' selected' : '';
                }elseif(gettype($select) == 'array'){                    
                    $selected = in_array($data->id, $select) ? ' selected' : '';
                }
                ?>
                <option value="<?=$data->id?>"<?=$selected?>>
                <?php
                if(gettype($name_columns) == 'string' || gettype($name_columns) == 'integer') {
                    echo $data->$name_columns;
                }elseif(gettype($name_columns) == 'array'){
                    foreach($name_columns as $name_column){
                        echo $data->$name_column. ' ';
                    }
                }
                ?>
                </option>
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