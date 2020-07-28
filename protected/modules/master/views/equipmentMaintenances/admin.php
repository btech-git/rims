<?php
/* @var $this EquipmentMaintenancesController */
/* @var $model EquipmentMaintenances */

$this->breadcrumbs=array(
	'Product',
	'Equipment Maintenances'=>array('admin'),
	'Manage Equipment Maintenances',
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
	$('#equipment-maintenances-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.equipmentMaintenances.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentMaintenances/create';?>"><span class="fa fa-plus"></span>New Equipment Maintenance</a>
			<?php }?>
						<h1>Manage Equipment Maintenances</h1>

						<div class="search-bar">
							<div class="clearfix button-bar">
							<!--<div class="left clearfix bulk-action">
								<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
								<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
								<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
							<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
							<div class="clearfix"></div>
<div class="search-form" style="display:none">
							<?php $this->renderPartial('_search',array(
								'model'=>$model,
							)); ?>
							</div><!-- search-form -->
						</div>
						</div>

						<div class="grid-view">
						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'equipment-maintenances-grid',
							'dataProvider'=>$model->search(),
							'filter'=>$model,
							'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
							'pager'=>array(
							   'cssFile'=>false,
							   'header'=>'',
							),
							'columns'=>array(
															array (
										'class' 		 => 'CCheckBoxColumn',
										'selectableRows' => '2',	
										'header'		 => 'Selected',	
										'value' => '$data->id',				
										),
									
								//'equipment_id',
								array('name'=>'equipment_id','value'=>'$data->equipment->name'),
								//'equipment_task_id',
								array('name'=>'equipment_task_id','value'=>'$data->equipmentTask->task'),
								//	'equipment_detail_id',
								array('name'=>'equipment_detail_id','value'=>'$data->equipmentDetail->equipment_code'),
								//array('name'=>'employee_id','value'=>'$data->employee->name'),
								'employee_id',
								'maintenance_date',
								/*
								'next_maintenance_date',
								'check_date',
								'checked',
								'notes',
								'equipment_condition',
								'status',
								*/
								array(
									'class'=>'CButtonColumn',
									'template'=>'{edit}',
									'buttons'=>array
									(
										'edit' => array
										(
											'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.equipmentMaintenances.update"))',
											'url'=>'Yii::app()->createUrl("master/equipmentMaintenances/update", array("id"=>$data->id))',
										),
										
									),
								),
							),
						)); ?>
						</div>
					</div>
				</div>