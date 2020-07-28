<fieldset>
<legend>Vehicle Info</legend>
<div class="row">
		

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Customer Name :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->customer->name; ?></label>
			</div>
		</div>

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Machine Number :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->machine_number; ?></label>
			</div>
		</div>

	</div>

	<div class="row">
		

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Frame Number :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->frame_number; ?></label>
			</div>
		</div>

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Car Make :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->carMake->name; ?></label>
			</div>
		</div>

	</div>

	<div class="row">
		

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Car Model :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->carModel->name; ?></label>
			</div>
		</div>

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Car SubModel :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->carSubModel->name; ?></label>
			</div>
		</div>

	</div>
	<div class="row">
		

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Car Model :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->carModel->name; ?></label>
			</div>
		</div>

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Car SubModel :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->carSubModel->name; ?></label>
			</div>
		</div>

	</div>
	<div class="row">
		

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Color :</label>
			</div>
			<div class="small-8 columns">
				<label for="">
					<?php $color = Colors::model()->findByPk($vehicle->color_id); ?>
				<?php echo $color->name; ?></label>
			</div>
		</div>

		<div class="large-6 columns">
			<div class="small-4 columns">
				<label for="">Chasis Code:</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $vehicle->chasis_code; ?></label>
			</div>
		</div>

	</div>
</fieldset>