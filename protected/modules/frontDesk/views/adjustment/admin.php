<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */

$this->breadcrumbs = array(
    'Stock Adjustment Headers' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List StockAdjustmentHeader', 'url' => array('admin')),
    array('label' => 'Create StockAdjustmentHeader', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#stock-adjustment-header-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Stock Adjustment', Yii::app()->baseUrl . '/frontDesk/adjustment/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("stockAdjustmentCreate"))) ?>
        <h2>Manage Stock Adjustment Headers</h2>
    </div>

    <div class="search-bar">
        <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                )); ?>
            </div><!-- search-form -->
        </div>
    </div>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'stock-adjustment-header-grid',
            'dataProvider' => $dataProvider,
            'filter' => null,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'name' => 'stock_adjustment_number', 
                    'value' => 'CHtml::link($data->stock_adjustment_number, array("view", "id"=>$data->id))', 
                    'type' => 'raw'
                ),
                'date_posting',
                array(
                    'name' => 'transaction_type',
                    'filter' => CHtml::activeDropDownList($model, 'transaction_type', array(), array('empty' => '-- All --')),
                    'value' => '$data->transaction_type'
                ),
                array(
                    'header' => 'Parts',
                    'value' => '$data->getProducts()',
                ),
                array(
                    'name' => 'username_name',
                    'value' => '(!empty($data->user->username)?$data->user->username:"")',
                ),
                array(
                    'name' => 'supervisor_name',
                    'value' => '(!empty($data->supervisor->username)?$data->supervisor->username:"")',
                ),
//                array(
//                    'name' => 'branch_id',
//                    'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
//                    'value' => '$data->branch->name'
//                ),
                'status',
                array(
                    'header' => 'Input',
                    'name' => 'created_datetime',
                    'filter' => false,
                    'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                ),
            ),
        )); ?>
    </div>
</div>