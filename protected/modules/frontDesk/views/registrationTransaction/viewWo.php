<?php
/* @var $this WorkOrderController */
/* @var $model WorkOrder */

$this->breadcrumbs=array(
	'Work Orders'=>array('adminWo'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WorkOrder', 'url'=>array('admin')),
	// array('label'=>'Create WorkOrder', 'url'=>array('create')),
	// array('label'=>'Update WorkOrder', 'url'=>array('update', 'id'=>$model->id)),
	// array('label'=>'Delete WorkOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage WorkOrder', 'url'=>array('admin')),
);
?>

<h1>View WorkOrder #<?php echo $model->id; ?></h1>

<?php //$this->widget('zii.widgets.CDetailView', array(
	// 'data'=>$model,
	// 'attributes'=>array(
	// 	'id',
	// 	'work_order_number',
	// 	'work_order_date',
	// 	'registration_transaction_id',
	// 	'user_id',
	// 	'branch_id',
	// ),
//)); ?>
<?php //$model = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
	 <div class="row">
<div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Work Order #</span>
        </div>
        <div class="small-9 columns">
          <?php echo CHtml::activeTextField($model,'work_order_number',array('size'=>30,'maxlength'=>30,'readonly'=>'true','value'=>$model->work_order_number)); ?>
					
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Customer</span>
        </div>
        <div class="small-9 columns">
           <?php echo CHtml::activeTextField($model,'customer_name',array('size'=>30,'maxlength'=>30,'readonly'=>'true','value'=>$model->customer != NULL ? $model->customer->name : '')); ?>
        </div>
      </div>
    </div>
   </div>

   <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Work Order Date</span>
        </div>
        <div class="small-9 columns">
          <?php echo CHtml::activeTextField($model,'work_order_date',array('readonly'=>'true')); ?>
					
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">PIC</span>
        </div>
        <div class="small-9 columns">
          <?php echo CHtml::activeTextField($model,'pic_name',array('size'=>30,'maxlength'=>30,'readonly'=>'true','value'=>$model->pic != null ? $model->pic->name : '-')); ?>
        </div>
      </div>
    </div>
   </div>

	<div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Registration #</span>
        </div>
        <div class="small-9 columns">
          <?php echo CHtml::activeTextField($model,'registration_transaction_id',array('readonly'=>'true','value'=>$model->transaction_number)); ?>
					
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">User</span>
        </div>
        <div class="small-9 columns">
          <?php echo CHtml::activeTextField($model,'user_id',array('value'=>$model->user->username,'readonly'=>'true')); ?>
        </div>
      </div>
    </div>
   </div>
   <?php //$model = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
   <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Registration Date</span>
        </div>
        <div class="small-9 columns">
          <?php echo CHtml::activeTextField($model,'registration_transaction_date',array('readonly'=>'true','value'=>$model->transaction_date != NULL ? $model->transaction_date : '')); ?>
					
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Branch</span>
        </div>
        <div class="small-9 columns">
          <?php echo CHtml::activeTextField($model,'branch_id',array('value'=>$model->branch->name,'readonly'=>'true')); ?>
        </div>
      </div>
    </div>
   </div>
	
	<fieldset>
	  <legend>Vehicle</legend>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Plate Number</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo CHtml::activeTextField($model,'plate',array('readonly'=>'true','value'=>$model->vehicle != null ? $model->vehicle->plate_number : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Car Make</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo CHtml::activeTextField($model,'carMake',array('readonly'=>'true','value'=>$model->vehicle != null  ? $model->vehicle->carMake->name : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Machine Number</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo CHtml::activeTextField($model,'machine',array('readonly'=>'true','value'=>$model->vehicle != null  ? $model->vehicle->machine_number : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Car Model</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo CHtml::activeTextField($model,'carModel',array('readonly'=>'true','value'=>$model->vehicle != null  ? $model->vehicle->carModel->name : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Frame Number</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo CHtml::activeTextField($model,'frame',array('readonly'=>'true','value'=>$model->vehicle != null ? $model->vehicle->frame_number : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Car Sub Model</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo CHtml::activeTextField($model,'carSubModel',array('readonly'=>'true','value'=>$model->vehicle != null ? $model->vehicle->carSubModel->name : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Year</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo CHtml::activeTextField($model,'year',array('readonly'=>'true','value'=>$model->vehicle != null  ? $model->vehicle->year : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Chasis code</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo CHtml::activeTextField($model,'chasis',array('readonly'=>'true','value'=>$model->vehicle != null  ? $model->vehicle->chasis_code : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Color</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo CHtml::activeTextField($model,'color',array('readonly'=>'true','value'=>$model->vehicle != null  ? Vehicle::model()->getColor($model->vehicle,'color_id') : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Power CC</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo CHtml::activeTextField($model,'power',array('readonly'=>'true','value'=> $model->vehicle && $model->vehicle->power ? $model->vehicle->power : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    
	</fieldset>
	<fieldset>
		<legend>Details</legend>
		<table class="detail">
			<thead>
				<tr>
					<th>Service Name</th>
					<th>Product Used</th>
					<th>Start</th>
					<th>End</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($details as $key => $detail): ?>
					<tr>
						<td><?php echo $detail->service->name; ?></td>
						<td><?php $first = true;
									$rec = "";
									$smDetails = ServiceMaterial::model()->findAllByAttributes(array('service_id'=>$detail->service_id));
									foreach($smDetails as $smDetail)
									{
										$product = Product::model()->findByPk($smDetail->product_id);
										if($first === true)
										{
											$first = false;
										}
										else
										{
											$rec .= ', ';
										}
										$rec .= $product->name;

									}
									echo $rec;
						 ?></td>
						<td><?php echo $detail->start; ?></td>
						<td><?php echo $detail->end; ?></td>
						<td><?php 
							if($model->repair_type == 'GR')
							{
								echo $detail->status; 
							}
							else{
								if($detail->is_body_repair == 0)
									echo '';
								else
									echo $detail->status;
							}

							?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</fieldset>
