<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List RegistrationTransaction', 'url' => array('admin')),
    array('label' => 'Create RegistrationTransaction', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });

    $('.search-form form').submit(function(){
        $('#registration-transaction-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Follow Up Service</h1>
    </div>
    <div class="clearfix"></div>
</div>

<br />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'registration-transaction-grid',
        'dataProvider' => $dataProvider,
        'filter' => null,
        'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'rowCssClassExpression' => '(($data->status == "Finished")?"hijau":"merah")',
        'columns' => array(
            'transaction_number',
            'work_order_date',
            array('name' => 'plate_number', 'value' => '$data->vehicle->plate_number'),
            array(
                'header' => 'Car Make',
                'value' => 'empty($data->vehicle->carMake) ? "" : $data->vehicle->carMake->name'
            ),
            array(
                'header' => 'Car Model',
                'value' => '$data->vehicle->carModel->name'
            ),
            array(
                'header' => 'Repair Type',
                'name' => 'repair_type',
                'value' => '$data->repair_type',
                'type' => 'raw',
                'filter' => false,
            ),
            array(
                'header' => 'Customer Name',
                'value' => '$data->customer->name',
            ),
            array(
                'name' => 'branch_id',
                'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value' => '$data->branch->name'
            ),
            'problem',
        ),
    )); ?>
</div>