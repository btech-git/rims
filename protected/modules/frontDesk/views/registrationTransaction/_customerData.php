<fieldset>
<legend>Customer Info</legend>
<div class="row">
		

		<div class="large-4 columns">
			<div class="small-4 columns">
				<label for="">Name :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $customer->name; ?></label>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="small-4 columns">
				<label for="">PIC :</label>
			</div>
			<div class="small-8 columns">
				<label for="">	<?php $first = true;
						$rec = "";
						$picDetails = CustomerPic::model()->findAllByAttributes(array('customer_id'=>$customer->id));
						foreach($picDetails as $picDetail)
						{
						
							if($first === true)
							{
								$first = false;
							}
							else
							{
								$rec .= ', ';
							}
							$rec .= $picDetail->name;

						}
						echo $rec;
			 ?></label>
			</div>
		</div>

		<div class="large-4 columns">
			
		</div>
	</div>

	<div class="row">
		

		<div class="large-4 columns">
			<div class="small-4 columns">
				<label for="">Vehicles :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php $first = true;
						$rec = "";
						$vehicleDetails = Vehicle::model()->findAllByAttributes(array('customer_id'=>$customer->id));
						foreach($vehicleDetails as $vehicleDetail)
						{
						
							if($first === true)
							{
								$first = false;
							}
							else
							{
								$rec .= ', ';
							}
							$rec .= $vehicleDetail->plate_number;

						}
						echo $rec;
			 ?></label>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="small-4 columns">
				<label for="">Email :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $customer->email; ?></label>
			</div>
		</div>

		<div class="large-4 columns">
			
		</div>
	</div>

	<div class="row">
		

		<div class="large-4 columns">
			<div class="small-4 columns">
				<label for="">Address :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $customer->address; ?></label>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="small-4 columns">
				<label for="">Province & City :</label>
			</div>
			<div class="small-8 columns">
				<label for=""><?php echo $customer->province != null ? $customer->province->name . ', '.$customer->city->name : '-'; ?></label>
			</div>
		</div>

		<div class="large-4 columns">
			
		</div>
	</div>
</fieldset>