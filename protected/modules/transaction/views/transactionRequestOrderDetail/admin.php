<?php
/* @var $this TransactionRequestOrderDetailController */
/* @var $model TransactionRequestOrderDetail */

$this->breadcrumbs=array(
	'Transaction Request Order Details'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransactionRequestOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionRequestOrderDetail', 'url'=>array('create')),
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
	$('#transaction-request-order-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transaction Request Order Details</h1>

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
	'id'=>'transaction-request-order-detail-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'columns'=>array(
		'id',
		'request_order_id',
		'product_id',
		'supplier_id',
		'unit_id',
		'discount_percent',
		/*
		'discount_nominal',
		'quantity',
		'price',
		'subtotal',
		'purchase_order_quantity',
		'request_order_quantity',
		'notes',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
