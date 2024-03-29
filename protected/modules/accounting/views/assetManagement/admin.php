<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
    'Asset Purchases'=>array('admin'),
    'Manage',
);

$this->menu=array(
    array('label'=>'List AssetPurchase', 'url'=>array('admin')),
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

<h1>Manage Assets</h1>

<div id="link">
    <span style="display: inline-block">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>Purchase', Yii::app()->baseUrl . '/accounting/assetManagement/createPurchase', array(
            'class' => 'button success right',
        )); ?>
    </span>
<!--    <span style="display: inline-block; width: 9px">&nbsp;</span>
    <span style="display: inline-block">
    <?php /*echo CHtml::link('<span class="fa fa-minus"></span>Sell', Yii::app()->baseUrl . '/accounting/assetPurchase/createSale', array(
        'class' => 'button alert right',
    ));*/ ?>
    </span>-->
    <span style="display: inline-block; width: 9px">&nbsp;</span>
    <span style="display: inline-block">
        <?php echo CHtml::link('<span class="fa fa-arrow-down"></span>Depreciating', Yii::app()->baseUrl . '/accounting/assetManagement/createDepreciation', array(
            'class' => 'button warning right',
        )); ?>
    </span>
</div>

<br />

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="search-bar">
    <div class="clearfix button-bar">
        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>
        <div class="clearfix"></div>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div><!-- search-form -->
    </div>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'asset-purchase-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
       'cssFile'=>false,
       'header'=>'',
    ),
    'columns'=>array(
        'assetCategory.description',
        'description: item',
        'transaction_number',
        'transaction_date',
        array(
            'name' => 'purchase_value', 
            'value' => 'number_format($data->purchase_value, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right'         
            ),
        ),
        array(
            'name' => 'accumulated_depreciation_value',
            'header' => 'Total Depresiasi',
            'value' => 'number_format($data->accumulated_depreciation_value, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right'         
            ),
        ),
        array(
            'name' => 'current_value', 
            'value' => 'number_format($data->current_value, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right'         
            ),
        ),
        'status',
        /*
        'monthly_useful_life',
        'user.username',
        'depreciation_amount',
        'depreciation_start_date',
        'depreciation_end_date',
        'user_id',
        */
        array(
            'class'=>'CButtonColumn',
            'template' => '{views} {updates} {sale}',
            'buttons' => array(
                'views' => array(
                    'label' => 'view',
                    'url' => 'Yii::app()->createUrl("accounting/assetManagement/view", array("id"=>$data->id))',
                    'visible' => 'Yii::app()->user->checkAccess("bodyRepairCreate") || Yii::app()->user->checkAccess("bodyRepairEdit")',
                ),
                'updates' => array(
                    'label' => 'update',
                    'url' => 'Yii::app()->createUrl("accounting/assetManagement/update", array("id"=>$data->id))',
                    'visible' => 'Yii::app()->user->checkAccess("bodyRepairCreate") || Yii::app()->user->checkAccess("bodyRepairEdit")',
                ),
                'sale' => array(
                    'label' => 'sale',
                    'url' => 'Yii::app()->createUrl("accounting/assetManagement/createSale", array("id"=>$data->id))',
                    'visible' => '$data->status !== "Sold" && Yii::app()->user->checkAccess("bodyRepairEdit")'
                ),
            ),
        ),
    ),
)); ?>
