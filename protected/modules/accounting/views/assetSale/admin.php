<?php
/* @var $this AssetSaleController */
/* @var $model AssetSale */

$this->breadcrumbs=array(
    'Asset Sales'=>array('admin'),
    'Manage',
);

$this->menu=array(
	array('label'=>'List AssetSale', 'url'=>array('admin')),
	array('label'=>'Create AssetSale', 'url'=>array('assetList')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});

$('.search-form form').submit(function(){
    $('#asset-sale-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Asset Sales</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span>New Sales', Yii::app()->baseUrl . '/accounting/assetSale/assetList', array(
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
    'id'=>'asset-sale-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'transaction_number',
        'transaction_date',
        'transaction_time',
        'sale_price',
        'note',
        'assetPurchase.description',
        'user.username',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>