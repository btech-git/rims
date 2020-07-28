<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs=array(
	'Product',
	'Brands'=>array('admin'),
	'Manage Brands',
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
	$('#brand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.brand.create")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/brand/create';?>"><span class="fa fa-plus"></span>New Brand</a>
		<?php } ?>
		<h2>Manage Brand</h2>
	</div>

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
		'id'=>'brand-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'columns'=>array(
			//'id',
			array (
			'class' 		 => 'CCheckBoxColumn',
			'selectableRows' => '2',	
			'header'		 => 'Selected',	
			'value' => '$data->id',				
			),
			//'name',
			array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
			array(
					'header'=>'Status',
					'name'=>'status', 
					'value'=>'$data->status',
					'type'=>'raw',
					'filter'=>CHtml::dropDownList('Brand[status]', $model->status, 
						array(
							''=>'All',
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
							'url'=>'Yii::app()->createUrl("master/brand/update", array("id"=>$data->id))',
							'visible'=>'(Yii::app()->user->checkAccess("master.brand.update"))'

						),
					),
				),
			),
	)); ?>
</div>
</div>
