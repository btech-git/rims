<?php
/* @var $this InventoryDetailController */
/* @var $model InventoryDetail */

$this->breadcrumbs=array(
	'Inventory Details'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List InventoryDetail', 'url'=>array('index')),
	array('label'=>'Create InventoryDetail', 'url'=>array('create')),
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
	$('#inventory-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Inventory Details</h1>

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
	'id'=>'inventory-detail-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'columns'=>array(
		'id',
		'inventory_id',
		'product_id',
		'warehouse_id',
		'transaction_type',
		'transaction_number',
		/*
		'transaction_date',
		'stock_in',
		'stock_out',
		'notes',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
