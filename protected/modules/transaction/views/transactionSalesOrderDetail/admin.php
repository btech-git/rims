<?php
/* @var $this TransactionSalesOrderDetailController */
/* @var $model TransactionSalesOrderDetail */

$this->breadcrumbs=array(
	'Transaction Sales Order Details'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderDetail', 'url'=>array('create')),
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
	$('#transaction-sales-order-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transaction Sales Order Details</h1>

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
	'id'=>'transaction-sales-order-detail-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'columns'=>array(
		'id',
		'sales_order_id',
		'product_id',
		'unit_id',
		'retail_price',
		'quantity',
		/*
		'unit_price',
		'amount',
		'discount_step',
		'discount1_type',
		'discount1_nominal',
		'discount1_temp_quantity',
		'discount1_temp_price',
		'discount2_type',
		'discount2_nominal',
		'discount2_temp_quantity',
		'discount2_temp_price',
		'discount3_type',
		'discount3_nominal',
		'discount3_temp_quantity',
		'discount3_temp_price',
		'discount4_type',
		'discount4_nominal',
		'discount4_temp_quantity',
		'discount4_temp_price',
		'discount5_type',
		'discount5_nominal',
		'discount5_temp_quantity',
		'discount5_temp_price',
		'total_quantity',
		'total_price',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
