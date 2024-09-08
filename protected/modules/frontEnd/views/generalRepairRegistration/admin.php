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
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Registration', Yii::app()->baseUrl . '/frontEnd/customerRegistration/vehicleList', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("frontEnd.generalRepairRegistration.admin"))); ?>
        <h1>Manage General Repair Registrations</h1>
        
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
            array(
                'header' => '#',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1', //  row is zero based
            ),
            'transaction_number',
            array(
                'name' => 'transaction_date',
                'value' => "Yii::app()->dateFormatter->formatDateTime(\$data->transaction_date, 'medium', 'short')",
                'filter' => false, // Set the filter to false when date range searching
            ),
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
            'work_order_number',
            array(
                'header' => 'WO Status',
                'name' => 'status',
                'value' => '$data->status',
                'type' => 'raw',
                'filter' => CHtml::dropDownList('RegistrationTransaction[status]', $model->status, array(
                    '' => 'All',
                    'Registration' => 'Registration',
                    'Pending' => 'Pending',
                    'Available' => 'Available',
                    'On Progress' => 'On Progress',
                    'Finished' => 'Finished'
                )),
            ),
            'service_status',
            'payment_status',
            'vehicle_status',
            'problem',
            array(
                'header' => 'Mekanik',
                'name' => 'employee_id_assign_mechanic',
                'filter' => CHtml::activeDropDownlist($model, 'employee_id_assign_mechanic', CHtml::listData(Employee::model()->findAllByAttributes(array(
                    "position_id" => 1,
                )), "id", "name"), array("empty" => "--Assign Mechanic--")),
                'value' => 'empty($data->employeeIdAssignMechanic) ? "" : $data->employeeIdAssignMechanic->name'
            ),
            array(
                'header' => 'Salesman',
                'name' => 'employee_id_sales_person',
                'filter' => CHtml::activeDropDownlist($model, 'employee_id_sales_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
                    "position_id" => 2,
                )), "id", "name"), array("empty" => "--Salesman--")),
                'value' => 'empty($data->employeeIdSalesPerson) ? "" : $data->employeeIdSalesPerson->name'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{views} {edit} {finish}',
                'buttons' => array(
                    'views' => array(
                        'label' => 'view',
                        'url' => 'Yii::app()->createUrl("frontEnd/generalRepairRegistration/view", array("id"=>$data->id))',
                        'visible' => 'Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")'
                    ),
                    'edit' => array(
                        'label' => 'edit',
                        'url' => 'Yii::app()->createUrl("frontEnd/generalRepairRegistration/update", array("id"=>$data->id))',
                        'visible' => 'Yii::app()->user->checkAccess("generalRepairEdit")', //' && $data->status != "Finished" && empty($data->invoiceHeaders)',
                    ),
                    'finish' => array(
                        'label' => 'finish',
                        'url' => 'Yii::app()->createUrl("frontEnd/generalRepairRegistration/finishTransaction", array("id"=>$data->id))',
                        'visible' => '$data->status != "Finished" && Yii::app()->user->checkAccess("generalRepairEdit")',
                        'options' => array(
                            'confirm' => 'Are you sure to finish this transaction?',
                        ),
                    ),
                ),
            ),
        ),
    )); ?>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>