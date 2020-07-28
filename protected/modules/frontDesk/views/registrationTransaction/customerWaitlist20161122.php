<h1>Customer Waitlist</h1>
<?php 
/*$this->renderPartial('_search_wl'); 

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#registration-transaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
*/?>

<div class="waitlist">
	<table class="detail">
		<thead>
			<tr>
				<th>Plate#</th>
				<th>Car Make</th>
				<th>Car Model</th>
				<th>Car Year</th>
				<th>WO #</th>
				<th>Position</th>
				<th>Duration</th>
				<th>Insurance</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($models as $i => $model): ?>
				<tr>
				<td><?php echo $model->vehicle != null ? $model->vehicle->plate_number : ' '; ?></td>
				<td><?php echo $model->vehicle->carMake != null ? $model->vehicle->carMake->name: ' '; ?></td>
				<td><?php echo $model->vehicle->carModel != null ? $model->vehicle->carModel->name: ' '; ?></td>
				<td><?php echo $model->vehicle != null ? $model->vehicle->year: ' '; ?></td>
				<td><?php echo $model->work_order_number != null ? $model->work_order_number: ' '; ?></td>
				<td><?php echo $model->status != null ? $model->status: '-'; ?></td>
				<?php 
				if($model->repair_type == 'GR'){
					$regServices = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$model->id,'is_body_repair'=>0));
				}
				else
				{
					$regServices = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$model->id,'is_body_repair'=>1));
				}
				
							$duration = 0;
  						foreach ($regServices as $key => $regService) {
  							$duration += $regService->service->flat_rate_hour;
  						}
  			?>
				<td><?php echo $duration; ?></td>
				<td><?php echo $model->insuranceCompany != null ? $model->insuranceCompany->name: '-'; ?></td>
				<td>
					<?php /*echo CHtml::button('detail', array('class' => 'hello','disabled'=>count($regServices) == 0 ? true : false,
									'onclick'=>'$("#detail-'.$i.'").toggle();
								')); */?>
									
					<?php 
						echo CHtml::tag('button', array(
						    // 'name'=>'btnSubmit',
							'disabled'=>count($regServices) == 0 ? true : false,
					        'type'=>'button',
					        'class' => 'hello button expand',
					        'onclick'=>'$("#detail-'.$i.'").toggle();'
					      ), '<span class="fa fa-caret-down"></span> Detail'
					    );
					    ?>
				</td>
			</tr>
			<tr>
				<td id="detail-<?php echo $i?>" class="hide" colspan=9>
						<table>
							<thead>
								<tr>
									<th>Service</th>
									<th>Start</th>
									<th>End</th>
									<th>Duration</th>
									<th>Working By</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($regServices as $key => $regService) : ?>
									<tr>
										<td><?php echo $regService->service->name; ?></td>
										<td><?php echo $regService->start; ?></td>
										<td><?php echo $regService->end; ?></td>
										<td><?php echo $regService->service->flat_rate_hour; ?></td>
										
										<td><?php $first = true;
													$rec = "";
													$eDetails = RegistrationServiceEmployee::model()->findAllByAttributes(array('registration_service_id'=>$regService->id));
													foreach($eDetails as $eDetail)
													{
														$employee = Employee::model()->findByPk($eDetail->employee_id);
														if($first === true)
														{
															$first = false;
														}
														else
														{
															$rec .= ', ';
														}
														$rec .= $employee->name;

													}
													echo $rec;
										 ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<h3>Mechanics</h3>
<hr />	
<?php $employees = Employee::model()->findAll(); ?>

<div class="row">	
		<div class="large-2 columns">

			<table >	
				<thead>
					<tr>
						<th>Name</th>
						<th>Availability</th>
					</tr>
				</thead>
				<tbody>	
					<?php foreach ($employees as $key => $employee): ?>
						<tr>
							<td>	<?php echo 	$employee->name; ?></td>
							<td>	<?php echo 	$employee->availability; ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
	</div>
</div>
<hr>
<h3>Time Counter</h3>
<a name="timecounter"></a><a name="1"></a><a name="2"></a><a name="3"></a><a name="4"></a><a name="5"></a>
<div class="time-counter">
	<div class="detail">
	<?php 
		// $current_url=Yii::app()->request->requestUri;
		// $active_tab=parse_url($current_url,PHP_URL_FRAGMENT);
		$active_tab = !empty($_GET['RegistrationTransaction']['tab_type'])?$_GET['RegistrationTransaction']['tab_type']:'';
		// echo $active_tab;
	?>
		<?php 
				$this->widget('zii.widgets.jui.CJuiTabs', array(
			    'tabs' => array(
			        'Epoxy'=>array('id'=>'epoxy','content'=>$this->renderPartial(
                                        '_viewEpoxy',
                                        array('epoxyDatas'=>$epoxyDatas),TRUE)),
			        'Cat'=>array('id'=>'paint','content'=>$this->renderPartial(
                                        '_viewPaint',
                                        array('paintDatas'=>$paintDatas),TRUE)),
			        'Finishing'=>array('id'=>'finishing','content'=>$this->renderPartial(
                                        '_viewFinishing',
                                        array('finishingDatas'=>$finishingDatas),TRUE)),
			       
			        'Dempul'=>array('id'=>'dempul','content'=>$this->renderPartial(
                                        '_viewDempul',
                                        array('dempulDatas'=>$dempulDatas),TRUE)),
			        'Cuci'=>array('id'=>'washing','content'=>$this->renderPartial(
                                        '_viewWashing',
                                        array('washingDatas'=>$washingDatas),TRUE)),
			        'Opening'=>array('id'=>'opening','content'=>$this->renderPartial(
                                        '_viewOpening',
                                        array('openingDatas'=>$openingDatas),TRUE)),
			  ),                       
			 
			    // additional javascript options for the tabs plugin
			    'options' => array(
			        'collapsible' => TRUE,
			        'active' =>$active_tab,
        		),
        		// set id for this widgets
			    // 'id'=>'view_tab',
			));
	?>
	</div>
</div>

<?php 
	$customer = new Customer('search');
	$customerCriteria = new CDbCriteria;
	//$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
	$customerCriteria->compare('name',$customer->name,true);
	$customerCriteria->compare('email',$customer->email.'%',true,'AND', false);
	$customerCriteria->compare('customer_type',$customer->customer_type,true);

	$customerDataProvider = new CActiveDataProvider('Customer', array(
	'criteria'=>$customerCriteria,
	));?>


	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'customer-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'Customer',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
			),)
	);
	?> 

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'customer-grid',
		'dataProvider'=>$customerDataProvider,
		'filter'=>$customer,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
			'cssFile'=>false,
			'header'=>'',
			),
		'selectionChanged'=>'js:function(id){
			jQuery("#customer-dialog").dialog("close");
			jQuery.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCustomer', array('id'=> '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					jQuery("#RegistrationTransaction_customer_name").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_epoxy").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_dempul").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_finishing").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_opening").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_paint").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_washing").val(data.name);
				},
			});
		}',
		'columns'=>array(
			//'id',
			//'code',
			'customer_type',
			'name',
			'email',
			),
		)
	);
	?>

	<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>