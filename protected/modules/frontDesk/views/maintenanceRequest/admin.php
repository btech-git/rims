<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */

$this->breadcrumbs = array(
    'Maintenance Request' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#maintenance-request-header-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Maintenance Request', Yii::app()->baseUrl . '/frontDesk/maintenanceRequest/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("maintenanceRequestCreate"))) ?>
        <h2>Manage Maintenance Request</h2>
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
            'id' => 'maintenance-request-header-grid',
            'dataProvider' => $model->search(),
            'filter' => null,
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
                'transaction_time',
                'maintenance_type',
                'description',
                'priority_level',
                array(
                    'name' => 'branch_id',
                    'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value' => '$data->branch->name'
                ),
                'status',
            )
        )); ?>
    </div>
</div>
