<div class="modal-background"></div>
<div class="modal-card text-center">
    <h2 id="filesName"><?=$document->name?></h2>
    <p><?=$document->text?></p>
    <?php
    $files = explode('|,|', $document->documents);
    $count = count($files);
    $num = 1;
    foreach($files as $file){
        if($file) {
            if ($num == 1 || floor($num / 5) == $num / 5) {
                ?>
                <div class="row">
                <?php
            }
            ?>
            <div class="col-xs-6 col-md-3">
                <div class='file_main'>
                    <a style="display:inline-table;" href="<?=$file?>" target="_blank">
                        <img class='file' src="<?= asset('images/file.png') ?>" />
                        <div class='file_name'>
                            <?php
                            echo substr($file, strpos($file, $request->document_id . '-') + strlen($request->document_id) + 1);
                            ?>
                        </div>
                    </a>&nbsp;
                    <?php
                    if(Auth()->user()->isAdmin() && checkPreviousUri('/home')) {
                        ?>
                        <a id="filesDeleteFile" onclick="return confirm('<?= __('messages.file_delete') ?>')" href="/<?=$request->document_type?>/delete_file/<?=$request->document_id?>/<?=substr($file, strpos($file, $request->document_id . '-') - 5)?>" class="file_del">
                            <img src="<?=asset('images/x.png')?>">
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            if ($num == $count || floor($num / 4) == $num / 4) {
                ?>
                </div>
                <?php
            }
            $num++;
        }
    }
    if(auth()->user()->isAdmin() && checkPreviousUri('/home')) {
        ?>
        <form id="filesForm" class="form-horizontal" action="<?=$updateUrl?>" method="post"
              enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="col-md-4 control-label text-left"
                       for="delete_documents"><?= __('validation.attributes.delete_documents') ?></label>
				
                <div class="col-md-7 text-right check-box">
                    <input type="checkbox" name="delete_documents" id="delete_documents">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label text-left"><?= __('validation.attributes.documents') ?></label>

                <div class="col-md-7 text-center">
                    <input id="documents" name="documents[]" type="file" class="form-control input-md" multiple>
                </div>
            </div>
            <div class="modal-card-actions">
                <button onclick="closeDefModal()" type="button" class="btn btn-info"><?= __('buttons.close') ?></button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-info"><?= __('buttons.save') ?></button>
            </div>
        </form>
        <?php
    }else{
        ?>
        <button onclick="closeDefModal()" type="button" class="btn btn-info"><?= __('buttons.close') ?></button>
        <?php
    }
    ?>
</div>