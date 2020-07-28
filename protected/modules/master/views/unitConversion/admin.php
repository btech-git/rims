<?php
/* @var $this UnitConversionController */
/* @var $model UnitConversion */

$this->breadcrumbs=array(
	'Company',
	'Unit Conversions'=>array('admin'),
	'Manage Unit Conversions',
);

$this->menu=array(
	array('label'=>'List UnitConversion', 'url'=>array('index')),
	array('label'=>'Create UnitConversion', 'url'=>array('create')),
);

/*Yii::app()->clientScript->registerScript('search', "
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
	$('#unit-conversion-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/

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
	$('#unit-conversion-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.unitConversion.create")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/unitConversion/create';?>"><span class="fa fa-plus"></span>New Unit Conversion</a>
			<?php }?>

		<!--<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/unit/create';?>" data-reveal-id="unit"><span class="fa fa-plus"></span>New Unit</a>-->
		<?php //echo CHtml::button('New Unit', array('id' => 'create-button', 'class'=>'button success right')); ?>

		<h1>Manage Unit Conversions</h1>


		<div class="search-bar">
			<div class="clearfix button-bar">
					<!--<div class="left clearfix bulk-action">
	         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
	         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
	         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
					<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
				<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>
				</div>
				<div class="clearfix"></div>
<div class="search-form" style="display:none">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
			</div><!-- search-form -->
			</div>

		<div class="grid-view">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'unit-conversion-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
				'columns'=>array(
					//'id',
					//'unit_from_id',
					array('name'=>'unit_from_id','value'=>'$data->unitFrom->name'),
					//'unit_to_id',
					array('name'=>'unit_to_id','value'=>'$data->unitTo->name'),
					// 'multiplier',
					array(
						'name'=>'multiplier',
						'value'=>'(float) $data->multiplier',
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{edit}',
						'buttons'=>array
						(
							'edit' => array
							(
									'visible'=>'(Yii::app()->user->checkAccess("master.unitConversion.update"))',
								'label'=>'edit',
								'url'=>'Yii::app()->createUrl("master/unitConversion/update", array("id"=>$data->id))',
							),
						),
					),
				),
			)); ?>
		</div>
	</div>
	<!-- end maincontent -->
</div>