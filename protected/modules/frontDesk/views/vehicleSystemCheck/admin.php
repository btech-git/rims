<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */

$this->breadcrumbs = array(
    'Vehicle System Check' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#vehicle-system_check-header-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New', Yii::app()->baseUrl . '/frontDesk/vehicleSystemCheck/registrationTransactionList', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("maintenanceRequestCreate"))) ?>
        <h2>Manage Vehicle System Check</h2>
    </div>

    <div class="search-bar">
        <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php /*$this->renderPartial('_search', array(
                    'model' => $model,
                ));*/ ?>
            </div><!-- search-form -->
        </div>
    </div>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'vehicle-system-check-header-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'name' => 'transaction_number', 
                    'value' => 'CHtml::link($data->transaction_number, array("view", "id"=>$data->id))', 
                    'type' => 'raw'
                ),
                'transaction_date',
                'registrationTransaction.work_order_number',
                'registrationTransaction.customer.name',
                'registrationTransaction.vehicle.plate_number',
                'registrationTransaction.vehicle_mileage',
                array(
                    'name' => 'branch_id',
                    'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value' => '$data->branch->name'
                ),
                'vehicle_condition_recommendation',
            )
        )); ?>
    </div>
</div>