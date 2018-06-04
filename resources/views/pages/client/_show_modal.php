<div class="modal-background"></div>
<div id="clientModal" class="modal-card">

	<?php
	if($client->logo){
		?>
	<div class="info">
		<h4>
			<?=__('validation.attributes.logo')?>
		</h4>
		<div id="logo">
			<img src="<?=$client->logo?>">
		</div>
	</div>
	<?php
	}
	?>

	<div class="info">
		<h4>Personal data</h4>
		<div class="row">
			<?php
			if($client->name){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.name')?>
				</div>
				<div class="value">
					<?=$client->name?>
				</div>
			</div>
			<?php
			}
			if($client->username){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.username')?>
				</div>
				<div class="value">
					<?=$client->username?>
				</div>
			</div>
			<?php
			}
			if($client->main_company_id){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.main_company_id')?>
				</div>
				<div class="value">
					<?=$client->mainCompany()?>
				</div>
			</div>
			<?php
			}
			if($client->staff_type){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.staff_type')?>
				</div>
				<div class="value">
					<?=$client->staffType->role_name?>
				</div>
			</div>
		</div>
	</div>

	<div class="info">
		<h4>Address</h4>
		<div class="row">
			<?php
			}
			if($client->address_1){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.address_1')?>
				</div>
				<div class="value">
					<?=$client->address_1?>
				</div>
			</div>
			<?php
			}
			if($client->zip_code){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.zip_code')?>
				</div>
				<div class="value">
					<?=$client->zip_code?>
				</div>
			</div>
			<?php
			}
			if($client->city){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.city')?>
				</div>
				<div class="value">
					<?=$client->city?>
				</div>
			</div>
		</div>
	</div>

	<div class="info">
		<h4>Contact</h4>
		<div class="row">
			<?php
			}
			if($client->phone){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.phone')?>
				</div>
				<div class="value">
					<?=$client->phone?>
				</div>
			</div>
			<?php
			}
			if($client->email){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.email')?>
				</div>
				<div class="value">
					<?=$client->email?>
				</div>
			</div>
			<?php
			}
			if($client->contact){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.contact')?>
				</div>
				<div class="value">
					<?=$client->contact?>
				</div>
			</div>
		</div>
	</div>

	<div class="info">
		<h4>Info</h4>
		<div class="row">
			<?php
			}
			if($client->info){
				?>
			<div class="col-xs-12">
				<div class="value">
					<?=$client->info?>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>

	<div class="modal-card-actions">
		<button onclick="closeDefModal()" type="button" class="btn btn-info"><?=__('buttons.cancel')?></button>
		<a href="<?=$pdfUrl?>" class="btn btn-info">
			<?=__('buttons.save_as_pdf')?>
		</a>
	</div>
	<div class="close-modal" onclick="closeDefModal()">&times;</div>
</div>
