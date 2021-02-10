<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Idle Management'=>array('indexMechanic'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('admin')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});
$('.search-form form').submit(function(){
	$('#registration-service-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

	/*$('#registration-service-grid a.registration-service-start').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});

	$('#registration-service-grid a.registration-service-finish').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});*/
");
?>

<div id="maincontent">
	<div class="clearfix page-action">
		<h1>Manage Service Progress</h1>

		<div>
			<?php
//				$duration = 0;
				$damage = "";
//            	$registrationServiceBodyRepairs = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$registrationService->registration_transaction_id, 'is_body_repair'=>1));
//        		foreach ($registrationServiceBodyRepairs as $rs) {
//            		$duration += $rs->hour;
//            	}
            	$registrationDamages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id'=>$registrationService->registration_transaction_id));
            	foreach ($registrationDamages as $key => $registrationDamage) {
            		$damage .= $registrationDamage->service->name;
            		$damage .= ",";
            	}
			?>
 			<table>
 				<tr>
 					<td>Plate Number: <?php echo $registrationService->registrationTransaction->vehicle->plate_number; ?></td>
 					<td>Status      : <?php echo $registrationService->registrationTransaction->status; ?></td>
 				</tr>
 				<tr>
 					<td>Work Order #: <?php echo $registrationService->registrationTransaction->work_order_number; ?></td>
 					<td>Total Duration: <?php //echo $duration . ' hr'; ?></td>
 				</tr>
 				<tr>
 					<td>Last Update By: <?php echo $registrationService->registrationTransaction->user->username; ?></td>
 					<td>Services : <?php echo $damage; ?></td>
 				</tr>
 			</table>
 		</div>

		<div class="search-bar">
			<div class="clearfix button-bar">

     		<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
     		<div class="clearfix"></div>
     		<div class="search-form" style="display:none">
     			<?php /*$this->renderPartial('_searchRegistrationService',array(
     				'registrationService'=>$registrationService,
     			));*/ ?>
     		</div><!-- search-form -->				
     		</div>
     	</div>
		<div class="grid-view">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'registration-service-grid',
				'dataProvider'=>$registrationServiceDataProvider,
				'filter'=>null,
				'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
					'cssFile'=>false,
					'header'=>'',
				),
				'columns'=>array(
					array(
					  	'header'=>"No",
						'value'=>'$this->grid->dataProvider->pagination->offset + $row+1',
					),
					array('name'=>'service_id', 'value'=>'$data->service->name'),
					array('header'=>'Category', 'value'=>'$data->service->serviceCategory->name'),
					array(
        				'header'=>'Product',
        				'type'=>'html',
               			'value'=> function($data) {
                    		$products = array();
                    		foreach ($data->service->serviceMaterials as $serviceMaterial) {
                        		$products[] = $serviceMaterial->product->name . '<br>';
                        	}
                        	return implode('', $products);
                        }
                    ),
                    array('header'=>'duration', 'value'=>'$data->hour'),
                    'start',
                    'end',
//                    'pause',
//                    'resume',
//                    'pause_time',
//                    array('header'=>'total_time', 'value'=>'$data->registrationTransaction->total_time', 'footer'=>' ' . $registrationService->registrationTransaction->getTotal($registrationService->registration_transaction_id)),
                    array(
						'header'=>'Service Status', 
						'value'=>'$data->status',
						'type'=>'raw',
						'filter'=>CHtml::dropDownList('RegistrationService[status]', $registrationService->status, 
							array(
								''=>'All',
								'Pending'=>'Pending',
								'Available'=>'Available',
								'On Progress'=>'On Progress',
								'Finished'=>'Finished'
							)
						),
					),
                    array(
						'class'=>'CButtonColumn',
						'template'=>'{start} {pause} {resume} {finish}',
						'buttons'=>array
						(
							'start' => array(
								'label'=>'Start',
								'url'=>'Yii::app()->createUrl("frontDesk/idleManagement/workOrderStartService", array("serviceId"=>$data->service_id,"registrationServiceId"=>'.$_GET["registrationServiceId"].'))',
								'options'=>array('class'=>'registration-service-start'),
								'click'=>"js:function(){
									var url = $(this).attr('href');
							        //  do your post request here
							        console.log(url);
							        $.post(url,function(html){
							            $.fn.yiiGridView.update('registration-service-grid');
							        });
							        return false;
								}",
								'visible'=>'$data->start==NULL or $data->start=="0000-00-00 00:00:00"'
							),
							'pause' => array(
								'label'=>'Pause',
								'url'=>'Yii::app()->createUrl("frontDesk/idleManagement/WorkOrderPauseService", array("serviceId"=>$data->service_id,"registrationServiceId"=>'.$_GET["registrationServiceId"].'))',
								'options'=>array('class'=>'registration-service-pause'),
								'click'=>"js:function(){
									var url = $(this).attr('href');
							        //  do your post request here
							        console.log(url);
							        $.post(url,function(html){
							            $.fn.yiiGridView.update('registration-service-grid');
							        });
							        return false;
								}",
								'visible'=>'(($data->start!=NULL and $data->start!="0000-00-00 00:00:00") and $data->resume >= $data->pause) and (($data->end==NULL or $data->end=="0000-00-00 00:00:00" and $data->resume >= $data->pause))'
							),
							'resume' => array(
								'label'=>'Resume',
								'url'=>'Yii::app()->createUrl("frontDesk/idleManagement/workOrderResumeService", array("serviceId"=>$data->service_id,"registrationServiceId"=>'.$_GET["registrationServiceId"].'))',
								'options'=>array('class'=>'registration-service-resume'),
								'click'=>"js:function(){
									var url = $(this).attr('href');
							        //  do your post request here
							        console.log(url);
							        $.post(url,function(html){
							            $.fn.yiiGridView.update('registration-service-grid');
							        });
							        return false;
								}",
								'visible'=>'($data->end==NULL or $data->end=="0000-00-00 00:00:00") and $data->resume < $data->pause'
							),
							'finish' => array(
								'label'=>'Finish',
								'url'=>'Yii::app()->createUrl("frontDesk/idleManagement/workOrderFinishService", array("serviceId"=>$data->service_id,"registrationServiceId"=>'.$_GET["registrationServiceId"].'))',
								'options'=>array('class'=>'registration-service-finish'),
								'click'=>"js:function(){
									var url = $(this).attr('href');
							        //  do your post request here
							        console.log(url);
							        $.post(url,function(html){
							            $.fn.yiiGridView.update('registration-service-grid');
							        });
							        return false;
								}",
								'visible'=>'($data->start!=NULL and $data->start!="0000-00-00 00:00:00") and $data->resume >= $data->pause and $data->status != "Finished"'
							),
						),
					),
//					array(
//						'class'=>'CButtonColumn',
//						'template'=>'{view}{update}',
//						'buttons'=>array
//						(
//							'view' => array
//							(
//								'label'=>'View',
//								'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementServiceView", array("registrationServiceId"=>$data->id,"serviceId"=>$data->service_id,"registrationServiceId"=>'.$_GET["registrationServiceId"].'))',
//							),
//							'update' => array
//							(
//								'label'=>'Update',
//								'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementServiceUpdate", array("registrationServiceId"=>$data->id,"serviceId"=>$data->service_id,"registrationServiceId"=>'.$_GET["registrationServiceId"].'))',
//							),
//						),
//					),
				),
			)); ?>
		</div>
	</div>
</div>
<br /><br/>
<div>
    <h1>Products</h1>
	<table>
		<thead>
			<th>Product</th>
			<th>Quantity</th>
			<th>Quantity Movement</th>
			<th>Quantity Movement Left</th>
			<th>Quantity Receive</th>
			<th>Quantity ReceiveLeft</th>
			<th>Action</th>
		</thead>
		<tbody>

			<?php foreach ($registrationService->registrationTransaction->registrationProducts as $key => $rp): ?>
				<tr>
					<td><?php echo $rp->product->name; ?></td>
					<td><?php echo $rp->quantity; ?></td>
					<td><?php echo $rp->quantity_movement; ?></td>
					<td><?php echo $rp->quantity_movement_left; ?></td>
					<td><?php echo $rp->quantity_receive; ?></td>
					<td><?php echo $rp->quantity_receive_left; ?></td>
					<td>
						<?php echo CHtml::tag('button', array(
				        // 'name'=>'btnSubmit',
				        'type'=>'button',
				        'class' => 'hello button expand',
				        'onclick'=>'$("#detail-'.$key.'").toggle();'
				      ), '<span class="fa fa-caret-down"></span> Detail');?>
					</td>
				</tr>
				<tr>
					<td id="detail-<?php echo $key?>" class="hide" colspan=6>
						<?php 
						$mcriteria = new CDbCriteria;
						$mcriteria->together = 'true';
						$mcriteria->with = array('movementOutHeader');
						$mcriteria->condition="movementOutHeader.status ='Delivered' AND registration_product_id = ".$rp->id;
						 $getMovementDetails = MovementOutDetail::model()->findAll($mcriteria);
						//$getMovementDetails = MovementOutDetail::model()->findAllByAttributes(array('registration_product_id'=>$rp->id)); ?>
							<table>
								<thead>
									<tr>
										<th>Movement #</th>
										<th>Quantity Movement</th>
										<th>Quantity Received</th>
										<th>Quantity Received Left</th>
										<th>Quantity Receive</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<?php foreach ($getMovementDetails as $i => $md): ?>

									<tr>
										<td><?php echo $md->movementOutHeader->movement_out_no; ?>
										<input type="hidden" id="movementOut-<?php echo $i?>" value="<?php echo $md->movement_out_header_id; ?>">
										<input type="hidden" id="movementOutDetail-<?php echo $i?>" value="<?php echo $md->id; ?>">
										</td>
										<td><input type="text" id="quantityMovement-<?php echo $i?>" value="<?php echo $md->quantity ?>" readonly="true"></td>
										<td><input type="text" id="quantityReceived-<?php echo $i?>" value="<?php echo $md->quantity_receive ?>" readonly="true"></td>
										<td><input type="text" id="quantityReceivedLeft-<?php echo $i?>" value="<?php echo $md->quantity_receive_left ?>" readonly="true"></td>
										<td><?php if ($md->quantity_receive_left > 0 || $md->quantity_receive_left == ""): ?>
												<input type="text" id="quantity-<?php echo $i?>" onchange ="
													var move = +$('#quantityMovement-<?php echo $i?>').val();
													var quantity = +$('#quantity-<?php echo $i?>').val();
													if (quantity > move)
													{
														alert('Quantity Receive could not be greater than Quantity Movement');
														$('#quantity-<?php echo $i?>').val(' ');
													};
												">
											<?php else: ?>
												<input type="text" id="quantity-<?php echo $i?>" readonly="true">
												
											<?php endif ?>
										</td>
										<td>
											<?php echo CHtml::button('Receive', array(
											'id' => 'detail-button',
											'name' => 'Detail',
											'class'=>'button cbutton left',
											'disabled'=>$md->quantity_receive_left > 0 || $md->quantity_receive_left == "" ? false : true,
											'onclick' => ' 
												$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('receive', array('movementOutDetailId'=> $md->id,'registrationProductId'=>$rp->id,'quantity'=>'')) .'"+$("#quantity-'.$i.'").val(),
												data: $("form").serialize(),
												success: function(html) {
													
													alert("Success");
													location.reload();
												},})
											'
											)); ?>
			
										<!-- <a class="button cbutton left" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/registrationTransaction/receive',array('movementOutDetailId'=>$md->id,'registrationProductId'=>$rp->id));?>"><span class="fa fa-pencil"></span>receive</a> --></td>
									</tr>
								<?php endforeach ?>
								
							</table>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>