<?php
/* @var $this AssetCategoryController */
/* @var $model AssetCategory */

$this->breadcrumbs=array(
	'Asset Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AssetCategory', 'url'=>array('index')),
	array('label'=>'Create AssetCategory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#asset-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Asset Categories</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span>New Asset', Yii::app()->baseUrl . '/master/assetCategory/create', array(
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
	'id'=>'asset-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
            'id',
            'code',
            'description',
            'type',
            'number_of_years: Lama (tahun)',
            'coaInventory.name: COA Inventaris',
            'coaExpense.name: COA Beban',
            'coaAccumulation.name: COA Akumulasi',
            array(
                'class'=>'CButtonColumn',
            ),
	),
)); ?>
