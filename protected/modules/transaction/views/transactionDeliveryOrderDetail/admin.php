<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $model TransactionDeliveryOrderDetail */

$this->breadcrumbs=array(
	'Transaction Delivery Order Details'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransactionDeliveryOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionDeliveryOrderDetail', 'url'=>array('create')),
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
	$('#transaction-delivery-order-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transaction Delivery Order Details</h1>

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
	'id'=>'transaction-delivery-order-detail-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'columns'=>array(
		'id',
		'delivery_order_id',
		'product_id',
		'quantity_request',
		'quantity_delivery',
		'quantity_request_left',
		/*
		'note',
		'barcode_product',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
