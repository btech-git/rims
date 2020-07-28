<?php
/* @var $this EquipmentDetailsController */
/* @var $model EquipmentDetails */

$this->breadcrumbs=array(
	'Product',
	'Equipment Details'=>array('admin'),
	'Manage',
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
	$('#equipment-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

		
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.equipmentDetails.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentDetails/create';?>"><span class="fa fa-plus"></span>New Equipment Details</a>
			<?php }?>
					<h1>Manage Equipment Details</h1>
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
						'id'=>'equipment-details-grid',
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
							array('name'=>'equipment_id', 'value'=>'$data->equipment->name'),
							'equipment_code',
							'brand',
							'purchase_date',
							'age',
							/*
							'quantity',
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
									'visible'=>'(Yii::app()->user->checkAccess("master.equipmentDetails.update"))',
										'url'=>'Yii::app()->createUrl("master/equipmentDetails/update", array("id"=>$data->id))',
									),
									
								),
							),
						),
					)); ?>
					</div>
			</div>
		</div>
	</div>	
</div>	