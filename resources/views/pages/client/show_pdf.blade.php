<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
	<div id="clientShowPdf">
		<div class="container">
			<header>
				<div class="logoPdf">
					<img src="https://s3.eu-central-1.amazonaws.com/gsgtool/gsgtool/logo.png" />
				</div>
				<div class="dateHeader">
					{{ date('d-m-Y') }}
				</div>
			</header>
			<div class="info">
				<h4>Personal data</h4>
				<div class="row">
					<?php
			if($client->name){
				?>
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
				<h4>Phone</h4>
				<div class="row">
					<?php
			}
			if($client->phone){
				?>
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
					<div class="col-xs-3">
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
			<div class="dateFooter">
				{{ date('d-m-Y') }}
			</div>
			<div class="signature">
				{{ __('global.signature') }}
			</div>
		</div>
	</div>
</body>

</html>
