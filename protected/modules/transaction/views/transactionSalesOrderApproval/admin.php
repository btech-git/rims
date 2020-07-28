<?php
/* @var $this TransactionSalesOrderApprovalController */
/* @var $model TransactionSalesOrderApproval */

$this->breadcrumbs=array(
	'Transaction Sales Order Approvals'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderApproval', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderApproval', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transaction-sales-order-approval-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transaction Sales Order Approvals</h1>

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
	'id'=>'transaction-sales-order-approval-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sales_order_id',
		'revision',
		'approval_type',
		'date',
		'supervisor_id',
		/*
		'note',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
