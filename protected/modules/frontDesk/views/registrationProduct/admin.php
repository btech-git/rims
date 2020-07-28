<?php
/* @var $this RegistrationProductController */
/* @var $model RegistrationProduct */

$this->breadcrumbs=array(
	'Registration Products'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RegistrationProduct', 'url'=>array('index')),
	array('label'=>'Create RegistrationProduct', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#registration-product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Registration Products</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'registration-product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'registration_transaction_id',
		'product_id',
		'quantity',
		'retail_price',
		'hpp',
		/*
		'sale_price',
		'discount',
		'total_price',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
