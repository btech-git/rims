<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
	'Asset Purchases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AssetPurchase', 'url'=>array('index')),
	array('label'=>'Create AssetPurchase', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#asset-purchase-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Asset Purchases</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span>New Purchase', Yii::app()->baseUrl . '/accounting/assetPurchase/create', array(
        'class' => 'button success right',
//        'visible' => Yii::app()->user->checkAccess("transaction.paymentOut.create")
    )); ?>
</div>

<br />

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
	'id'=>'asset-purchase-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'transaction_number',
		'transaction_date',
		'transaction_time',
		'purchase_price',
		'monthly_useful_life',
		'asset.name',
		'user.username',
		/*
		'depreciation_amount',
		'depreciation_start_date',
		'depreciation_end_date',
		'status',
		'note',
		'asset_id',
		'user_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
