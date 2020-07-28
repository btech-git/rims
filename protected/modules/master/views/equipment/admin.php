<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Equipment'=>array('admin'),
	'Manage Equipment ',
);

// $this->menu=array(
// 	array('label'=>'List Equipment', 'url'=>array('index')),
// 	array('label'=>'Create Equipment', 'url'=>array('create')),
// );

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
	$('#service-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

	
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.equipment.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/equipment/create';?>" data-reveal-id="color"><span class="fa fa-plus"></span>New Equipment</a>
			<?php }?>
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

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'equipment-grid',
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
							array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
							'purchase_date',
							'maintenance_schedule',
							'period',
							'status',
							array(
							'class'=>'CButtonColumn',
							'template'=>'{edit} {hapus}',
							'buttons'=>array
							(
								'edit'=> array (
									'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.equipment.update"))',
									'url' =>'Yii::app()->createUrl("master/equipment/update",array("id"=>$data->id))',
								),
							'hapus' => array(
     						'label' => 'delete',
								'visible'=>'(Yii::app()->user->checkAccess("master.equipment.delete"))',
     						'url' => 'Yii::app()->createUrl("/master/equipment/delete", array("id" => $data->id))',
     						'options'=>array(
     							// 'class'=>'btn red delete',
     							'onclick' => 'return confirm("Are you sure want to delete this Equipment?");',
     							)
     						),

							),
						),
					),
				)); ?>
				</div>
		</div>
	</div>