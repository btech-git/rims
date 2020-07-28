<?php
/* @var $this EquipmentsController */
/* @var $model Equipments */

$this->breadcrumbs=array(
	'Product',
	'Equipments'=>array('admin'),
	'Manage Equipments',
);

$this->menu=array(
	array('label'=>'List Equipments', 'url'=>array('index')),
	array('label'=>'Create Equipments', 'url'=>array('create')),
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
	$('#equipments-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



	
			<div id="maincontent">
					<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.equipments.create")) { ?>
					<div class="button-group right">
						<a class="button success" href="<?php echo Yii::app()->baseUrl.'/master/equipments/create';?>"><span class="fa fa-plus"></span>New Equipment</a> 
			<?php }?>
		<?php if (Yii::app()->user->checkAccess("master.equipments.index")) { ?>
						<a class="button success" href="<?php echo Yii::app()->baseUrl.'/master/equipments/index';?>"><span class="fa fa-plus"></span>Equipment List</a>
			<?php }?>

					</div>
						<h1>Manage Equipments</h1>
			
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

				<?php
				//echo "<pre>";	print_r($model); exit;
				$this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'equipments-grid',
					'dataProvider'=>$model->search(),
					// 'summaryText' => '',
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
					   'cssFile'=>false,
					   'header'=>'',
					),
					'filter'=>$model,
					'columns'=>array(
						array(
								'class' 		 => 'CCheckBoxColumn',
								'selectableRows' => '2',	
								'header'		 => 'Selected',	
								'value' => '$data->id',				
							),
						//array('name'=>'branch_id', 'value'=>'$data->branch->name'),
						array(
							'header'=>'Branch',
							'name'=>'branch_id', 
							'value'=>'$data->branch->name',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('Equipments[branch_id]', 'branch_name', CHtml::listData(Branch::model()->findAll(),'id','name'), array('empty' => '[--Select--]')),
						),
						//array('name'=>'equipment_type_id', 'value'=>'$data->equipmentType->name'),
						array(
							'header'=>'Equipment Type', 
							'name'=>'equipment_type_id', 
							'value'=>'$data->equipmentType->name',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('Equipments[equipment_type_id]', 'equipment_type_name', CHtml::listData(EquipmentType::model()->findAll(),'id','name'), array('empty' => '[--Select--]')),
						),
						//array('name'=>'equipment_sub_type_id', 'value'=>'$data->equipmentSubType->name'),
						array(
							'header'=>'Equipment Sub Type', 
							'name'=>'equipment_sub_type_id', 
							'value'=>'$data->equipmentSubType->name',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('Equipments[equipment_sub_type_id]', 'equipment_sub_type_name', CHtml::listData(EquipmentSubType::model()->findAll(),'id','name'), array('empty' => '[--Select--]')),
						),
						array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
						array(
								'header'=>'Maintenance',
								'name'=>'id',
								'value'=>array($model,'getLink'),
								'type'=>'raw',
								'filter'=>'',
							),
						array(
							'header'=>'Status',
							'name'=>'status', 
							'value'=>'$data->status',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('Equipments[status]', 'equipments_status', 
								array(
									''=>'Select',
									'Active' => 'Active',
									'Inactive' => 'Inactive',
								)
							),
						),
						array(
							'class'=>'CButtonColumn',
							'template'=>'{edit}',
							'buttons'=>array
							(
								'edit' => array
								(
									'label'=>'edit',
									'url'=>'Yii::app()->createUrl("master/equipments/update", array("id"=>$data->id))',
								),
								
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>