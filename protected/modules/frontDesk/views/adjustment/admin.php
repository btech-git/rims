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
            <!--<div class="left clearfix bulk-action">
                    <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                    <input type="submit" value="Archive" class="button secondary cbutton" name="archive">
                    <input type="submit" value="Delete" class="button secondary cbutton" name="delete">
                    </div>-->
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
            </div><!-- search-form -->
        </div>
    </div>
    <div class="grid-view">

        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'stock-adjustment-header-grid',
            'dataProvider' => $dataProvider,
            'filter' => null,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                // 'id',
                // 'stock_adjustment_number',
                array('name' => 'stock_adjustment_number', 'value' => 'CHTml::link($data->stock_adjustment_number, array("view", "id"=>$data->id))', 'type' => 'raw'),
                'date_posting',
                // 'branch_id',
                // 'user_id',
                // 'supervisor_id',
                array(
                    'name' => 'username_name',
                    'value' => '(!empty($data->user->username)?$data->user->username:"")',
                ),
                array(
                    'name' => 'supervisor_name',
                    'value' => '(!empty($data->supervisor->username)?$data->supervisor->username:"")',
                ),
                array(
                    'name' => 'branch_id',
                    'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value' => '$data->branch->name'
                ),
                'status',
                array(
                    'header' => 'Input',
                    'name' => 'created_datetime',
                    'filter' => false,
                    'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                ),
//		array(
//			'class'=>'CButtonColumn',
//			'template'=>'{edit}',
//			'buttons'=>array(
//				'edit'=> array(
//					'label'=>'edit',
//					'url' =>'Yii::app()->createUrl("transaction/stockAdjustment/update",array("id"=>$data->id))',
//					'visible'=>'$data->status!="Approved" && Yii::app()->user->checkAccess("transaction.stockAdjustment.update")'
//				),
//			),	
//		),
            )
        ));
        ?>
