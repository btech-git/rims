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
        <h1>Customer List to Follow Up Service</h1>
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
//        'rowCssClassExpression' => '($data->follow_up_feedback == NULL ? "merah" : "hijau")',
        'columns' => array(
            array(
                'header' => 'Invoice #',
                'value' => 'CHtml::link($data->invoice_number, array("/transaction/invoiceHeader/view", "id"=>$data->id), array("target" => "blank"))', 
                'type' => 'raw'
            ),
            'invoice_date',
            'follow_up_date',
            array(
                'header' => 'Customer Name',
                'value' => '$data->customer->name',
            ),
            array(
                'header' => 'Kendaraan',
                'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->getCarMakeModelSubCombination()'
            ),
            array('name' => 'plate_number', 'value' => '$data->vehicle->plate_number'),
            'status',
            array(
                'header' => '',
                'value' => 'CHtml::link("Feedback", array("updateFollowUpFeedback", "id"=>$data->id), array("target" => "blank"))', 
                'type' => 'raw'
            ),
        ),
    )); ?>
</div>