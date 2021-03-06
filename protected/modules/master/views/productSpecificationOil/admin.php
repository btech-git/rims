<?php
/* @var $this ProductSpecificationOilController */
/* @var $model ProductSpecificationOil */

$this->breadcrumbs=array(
	'Product Specification Oils'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationOil', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationOil', 'url'=>array('create')),
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
	$('#product-specification-oil-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Specification Oils</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="clearfix"></div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-specification-oil-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'columns'=>array(
		'id',
		'product_id',
		'category_usage',
		'oil_type',
		'transmission',
		'code_serial',
		/*
		'sub_brand_id',
		'sub_brand_series_id',
		'fuel',
		'dot_code',
		'viscosity_low_t',
		'viscosity_high',
		'api_code',
		'size_measurements',
		'size',
		'name',
		'description',
		'car_use',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
