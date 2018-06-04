<div class="modal-background"></div>
<div id="staffModal" class="modal-card">

	<?php
	if($user->profile_picture){
		?>
	<div class="info">
		<h4>
			<?=__('validation.attributes.profile_picture')?>
		</h4>
		<div id="profile-picture">
			<img src="<?=$user->profile_picture?>">
		</div>
	</div>
	<?php
	}
	?>

	<div class="info">
		<h4>Personal data</h4>
		<div class="row">
			<?php
			if($user->firstname){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.firstname')?>
				</div>
				<div class="value">
					<?=$user->firstname?>
				</div>
			</div>
			<?php
			}
			if($user->lastname){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.lastname')?>
				</div>
				<div class="value">
					<?=$user->lastname?>
				</div>
			</div>
			<?php
			}
			if($user->nickname){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.nickname')?>
				</div>
				<div class="value">
					<?=$user->nickname?>
				</div>
			</div>
			<?php
			}
			?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.user_role')?>
				</div>
				<div class="value">
					<?=$user->role()->role_name?>
				</div>
			</div>
		</div>
	</div>

	<div class="info">
		<h4>ID card</h4>
		<div class="row">
			<?php
			if($user->general){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.general')?>
				</div>
				<div class="value">
					<?=date('d-m-Y', strtotime($user->general))?>
				</div>
			</div>
			<?php
			}
			if($user->service_number){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.service_number')?>
				</div>
				<div class="value">
					<?=$user->service_number?>
				</div>
			</div>
			<?php
			}
			if($user->birthdate){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.birthdate')?>
				</div>
				<div class="value">
					<?=date('d-m-Y', strtotime($user->birthdate))?>
				</div>
			</div>
			<?php
			}
			if($user->address_1){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.address_1')?>
				</div>
				<div class="value">
					<?=$user->address_1?>
				</div>
			</div>
			<?php
			}
			if($user->address_2){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.address_2')?>
				</div>
				<div class="value">
					<?=$user->address_2?>
				</div>
			</div>
			<?php
			}
			if($user->zip_code){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.zip_code')?>
				</div>
				<div class="value">
					<?=$user->zip_code?>
				</div>
			</div>
			<?php
			}
			if($user->city){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.city')?>
				</div>
				<div class="value">
					<?=$user->city?>
				</div>
			</div>
			<?php
			}
			if($user->country){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.country')?>
				</div>
				<div class="value">
					<?=$countries[$user->country]?>
				</div>
			</div>
			<?php
			}
			if($user->canton){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.canton')?>
				</div>
				<div class="value">
					<?=$canton[$user->canton]?>
				</div>
			</div>
			<?php
			}
			?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.official_address')?>
				</div>
				<div class="value">
					<?=$user->official_address ? 'Yes' : 'No'?>
				</div>
			</div>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.post_address')?>
				</div>
				<div class="value">
					<?=$user->post_address ? 'Yes' : 'No'?>
				</div>
			</div>
		</div>
	</div>

	<div class="info">
		<h4>Contact</h4>
		<div class="row">
			<?php
			if($user->phone){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.phone')?>
				</div>
				<div class="value">
					<?=$user->phone?>
				</div>
			</div>
			<?php
			}
			if($user->mobile){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.mobile')?>
				</div>
				<div class="value">
					<?=$user->mobile?>
				</div>
			</div>
			<?php
			}
			if($user->email){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.email')?>
				</div>
				<div class="value">
					<?=$user->email?>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>

	<div class="info">
		<h4>Administrative data</h4>
		<div class="row">
			<?php
			if($user->ahv){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.ahv')?>
				</div>
				<div class="value">
					<?=$user->ahv?>
				</div>
			</div>
			<?php
			}
			if($user->apartment){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.apartment')?>
				</div>
				<div class="value">
					<?=$user->apartment?>
				</div>
			</div>
			<?php
			}
			if($user->marital_status){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.marital_status')?>
				</div>
				<div class="value">
					<?=$maritalStatus[$user->marital_status]?>
				</div>
			</div>
			<?php
			}
			if($user->wedding_date && $user->marital_status ==1){
				?>
				<div class="col-xs-4 col-sm-3">
					<div class="property">
						<?=__('validation.attributes.wedding_date')?>
					</div>
					<div class="value">
						<?=date('d-m-Y', strtotime($user->wedding_date))?>
					</div>
				</div>
				<?php
			}
			if($user->nationality){
				?>
				<div class="col-xs-4 col-sm-3">
					<div class="property">
						<?=__('validation.attributes.nationality')?>
					</div>
					<div class="value">
						<?=$countries[$user->nationality]?>
					</div>
				</div>
				<?php
			}
			if($user->work_permit && $user->nationality != 'CH'){
				?>
					<div class="col-xs-4 col-sm-3">
						<div class="property">
							<?=__('validation.attributes.work_permit')?>
						</div>
						<div class="value">
							<?=$workPermit[$user->work_permit]?>
						</div>
					</div>
					<?php
			}
			if($user->work_permit_date && $user->nationality != 'CH'){
				?>
						<div class="col-xs-4 col-sm-3">
							<div class="property">
								<?=__('validation.attributes.work_permit_date')?>
							</div>
							<div class="value">
								<?=date('d-m-Y', strtotime($user->work_permit_date))?>
							</div>
						</div>
						<?php
			}
			?>
		</div>
	</div>

	<div class="info">
		<h4>Bank data</h4>
		<div class="row">
			<?php
			if($user->acc_type){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.acc_type')?>
				</div>
				<div class="value">
					<?=$accType[$user->acc_type]?>
				</div>
			</div>
			<?php
			}
			if($user->iban){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.iban')?>
				</div>
				<div class="value">
					<?=$user->iban?>
				</div>
			</div>
			<?php
			}
			if($user->number_bank && $user->acc_type == 1){
				?>
				<div class="col-xs-4 col-sm-3">
					<div class="property">
						<?=__('validation.attributes.number_bank')?>
					</div>
					<div class="value">
						<?=$user->number_bank?>
					</div>
				</div>
				<?php
			}
			if($user->number_post && $user->acc_type == 2){
				?>
					<div class="col-xs-4 col-sm-3">
						<div class="property">
							<?=__('validation.attributes.number_post')?>
						</div>
						<div class="value">
							<?=$user->number_post?>
						</div>
					</div>
					<?php
			}
			?>
		</div>
	</div>

	<div class="info">
		<h4>Skills and qualifications</h4>
		<div class="row">
			<?php
			if($user->current_job){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.current_job')?>
				</div>
				<div class="value">
					<?=$currentJob[$user->current_job]?>
				</div>
			</div>
			<?php
			}
			if($user->spoken_language){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.spoken_language')?>
				</div>
				<?php
					$languages = '';
					foreach(explode(',', $user->spoken_language) as $spoken_language){
						$languages .= $spokenLanguage[$spoken_language]. ', ';
					}
					$languages = rtrim($languages, ', ');
					?>
					<div class="value">
						<?=$languages?>
					</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>

	<div class="info">
		<h4>Other info</h4>
		<div class="row">
			<?php
			if($user->auto){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.auto')?>
				</div>
				<div class="value">
					<?=$defaultSelect[$user->auto]?>
				</div>
			</div>
			<?php
			}
			if($user->driving_license){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.driving_license')?>
				</div>
				<div class="value">
					<?=$defaultSelect[$user->driving_license]?>
				</div>
			</div>
			<?php
			}
			if($user->height){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.height')?>
				</div>
				<div class="value">
					<?=$user->height?>
				</div>
			</div>
			<?php
			}
			if($user->trousers_size){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.trousers_size')?>
				</div>
				<div class="value">
					<?=$trousersSize[$user->trousers_size]?>
				</div>
			</div>
			<?php
			}
			if($user->t_shirt_size){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.t_shirt_size')?>
				</div>
				<div class="value">
					<?=$TShirtSize[$user->t_shirt_size]?>
				</div>
			</div>
			<?php
			}
			if($user->shoe_size){
				?>
			<div class="col-xs-4 col-sm-3">
				<div class="property">
					<?=__('validation.attributes.shoe_size')?>
				</div>
				<div class="value">
					<?=$user->shoe_size?>
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
