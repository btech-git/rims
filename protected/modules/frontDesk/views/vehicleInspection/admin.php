<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */

$this->breadcrumbs=array(
	'Vehicle Inspections'=>array('admin'),
	'Vehicle List',
);

/*$this->menu=array(
	array('label'=>'List VehicleInspection', 'url'=>array('index')),
	array('label'=>'Create VehicleInspection', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
/*$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});*/
$('.search-form form').submit(function(){
	$('#vehicle-inspection-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
			<div id="maincontent">
				<div class="clearfix page-action">
					<!--<a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/master/vehicle/create';?>"><span class="fa fa-plus"></span>New Vehicle</a>-->
					<h1>Vehicle List</h1>

					<div class="search-bar">
						<div class="clearfix button-bar">
							<div class="left clearfix bulk-action">
				   		</div>
							<div class="row">
								<div class="medium-8 columns">
									<?php $form=$this->beginWidget('CActiveForm', array(
										'action'=>Yii::app()->createUrl($this->route),
										'method'=>'get',
										'htmlOptions'=>array('id'=>'search_heading-range'),
										)
									); 
									?>
									<div class="row">
										<div class="medium-4 columns">
											<?php 
											echo CHtml::dropDownList('RegistrationTransaction[status]', $vehicle->status, 
												array(
													''=>'All',
													'Registration'=>'Registration',
													'Pending'=>'Pending',
													'Available'=>'Available',
													'On Progress'=>'On Progress',
													'Finished'=>'Finished'
													),  array("style"=>"margin-bottom:0px;")
												);
												?>
											</div>
											<div class="medium-4 columns">
												<?php 
													// Date range search inputs
													/*$attribute = 'transaction_date';
													for ($i = 0; $i <= 1; $i++)
													{
													    echo ($i == 0 ? Yii::t('main', 'From:') : Yii::t('main', 'To:'));
													    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
													        'id'=>CHtml::activeId($model, $attribute.'_'.$i),
													        'model'=>$model,
													        'attribute'=>$attribute."[$i]",
													    )); 
													}*/
													?>
													<?php $attribute = 'transaction_date'; ?>
													<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
														'id'=>CHtml::activeId($vehicle, $attribute.'_0'),
														'model'=>$vehicle,
														'attribute'=>$attribute."_from",
														'options'=>array('dateFormat'=>'yy-mm-dd'),
														'htmlOptions'=>array(
															'style'=>'margin-bottom:0px;',
															'placeholder'=>'Transaction Date From'
															),
														)
													); 
													?>									
												</div>
												<div class="medium-4 columns">

													<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
														'id'=>CHtml::activeId($vehicle, $attribute.'_1'),
														'model'=>$vehicle,
														'attribute'=>$attribute."_to",
														'options'=>array('dateFormat'=>'yy-mm-dd'),
														'htmlOptions'=>array(
															'style'=>'margin-bottom:0px;',
															'placeholder'=>'Transaction Date To'
															),
														)
													); 
													?>									
												</div>
											</div>
											<?php $this->endWidget(); ?>
										</div>
										<div class="medium-2 columns">
											<a onClick="$('.search-form').slideToggle(600);$('.bulk-action').toggle(); $(this).toggleClass('active');
											if($(this).hasClass('active')){
												$(this).text('');
												$('#RegistrationTransaction_status').hide();
												$('#RegistrationTransaction_transaction_date_0').hide();
												$('#RegistrationTransaction_transaction_date_1').hide();
											}else {
												$(this).text('Advanced Search');
												$('#RegistrationTransaction_status').show();
												$('#RegistrationTransaction_transaction_date_0').show();
												$('#RegistrationTransaction_transaction_date_1').show();
											} return false;" href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
								</div>
							</div>
						</div>

						<div class="search-form" style="display:none">
							<?php $this->renderPartial('_search2',array(
								'model'=>$vehicle,
							)); ?>
						</div><!-- search-form -->
					</div>

					<?php
						$this->widget('ext.groupgridview.GroupGridView', array(
						   	'id' => 'vehicle-inspection-grid',
						   	// 'dataProvider' => $vehicleDataProvider,
						   	'dataProvider' => $vehicle->search(),
						   	'filter' => $vehicle,
						   	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						   	'pager'=>array(
							   'cssFile'=>false,
							   'header'=>'',
							),
						    'mergeColumns' => 'plate_number',
						   	'columns'=>array(
								//'id',
						   		array('name'=>'plate_number', 'value'=>'$data->vehicle->plate_number'),
								'transaction_number',
								'work_order_number',
                                array(
                                    'header' => 'Tanggal',
                                    'name' => 'transaction_date',
                                    'filter' => false,
                                    'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)'
                                ),
								array(
			        				'header'=>'Inspections',
			        				'type'=>'html',
			               			'value'=> function($data) {
			                    		$inspections = array();
			                    		$inspectionModel = VehicleInspection::model()->findAllByAttributes(array('work_order_number' => $data->work_order_number));
			                    		$html = '';
			                    		$html .= '
			                        		<table>
			                        	';
			                    		foreach ($inspectionModel as $inspection) {
			                        		$inspections[] = $inspection->inspection->name . '<br>';
			                        		$html .= '
			                        			<tr>
			                        				<td>' . $inspection->inspection->name . '</td>
			                        				<td>' . $inspection->inspection_date . '</td>
			                        				<td>' . $inspection->status . '</td>
			                        				
			                        			</tr>
			                        		';
			                        	}
			                        	
			                        	return $html;
			                        }
			                    ),
								array(
									'class'=>'CButtonColumn',
									'template'=>'{inspection}',
									'buttons'=>array
									(
										'inspection' => array
										(
											'label'=>'inspection',
											'url'=>'Yii::app()->createUrl("frontDesk/vehicleInspection/inspection", array("vehicleId"=>$data->vehicle->id,"wonumber"=>$data->work_order_number))',
											'visible'=>'Yii::app()->user->checkAccess("frontDesk.vehicleInspection.inspection")'
										),
									),
								),
							),
						));
					?>
				</div>
			</div>
			<!-- end maincontent -->

<?php 
  Yii::app()->clientScript->registerScript('search',"

        $('#RegistrationTransaction_status,#RegistrationTransaction_transaction_date_1').change(function(){
        	// if ($('#RegistrationTransaction_transaction_date_0').val().lenght != 0) {
	            $.fn.yiiGridView.update('vehicle-inspection-grid', {
	                data: $('#search_heading-range').serialize()
	            });
        	// }
            return false;
        });

		
    ");
?>

			<?php /*$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'vehicle-inspection-grid',
						'dataProvider'=>$vehicleDataProvider,
						'filter'=>$vehicle,
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'columns'=>array(
							//'id',
							array('name'=>'plate_number', 'value'=>'CHTml::link($data->plate_number, array("view", "id"=>$data->id))', 'type'=>'raw'),
							'machine_number',
							'frame_number',
							array('name'=>'car_make','value'=>'$data->carMake->name'),
							array('name'=>'car_model','value'=>'$data->carModel->name'),
							array('name'=>'car_sub_model','value'=>'$data->carSubModel->name'),
							//'vehicle_id',
							//'inspection_id',
							//'inspection_date',
							//'work_order_number',
							//'status',
							array(
								'class'=>'CButtonColumn',
								'template'=>'{inspection}',
								'buttons'=>array
								(
									'inspection' => array
									(
										'label'=>'inspection',
										'url'=>'Yii::app()->createUrl("frontDesk/vehicleInspection/inspection", array("vehicleId"=>$data->id))',
									),
								),
							),
						),
					));*/ ?>