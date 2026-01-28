<?php
$this->breadcrumbs = array(
    'Body Repair Transactions' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Registration Transaction', 'url' => array('admin')),
    array('label' => 'Create Registration Transaction', 'url' => array('index')),
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
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Registration', Yii::app()->baseUrl . '/frontDesk/customerRegistration/vehicleList', array(
            'class' => 'button success right', 
            'visible' => Yii::app()->user->checkAccess("bodyRepairCreate")
        )); ?>
        <h1>Manage Body Repair Registrations</h1>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
                'startDate' => $startDate,
                'endDate' => $endDate,
            )); ?>
        </div><!-- search-form -->
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
                'name' => 'car_make_code',
                'value' => 'empty($data->vehicle->carMake) ? "" : $data->vehicle->carMake->name'
            ),
            array(
                'header'=>'Car Model',
                'name'=>'car_model_code',
                'value'=>'$data->vehicle->carModel->name'
            ),
            array(
                'header' => 'Customer Name',
                'name' => 'customer_name',
                'value' => 'empty($data->customer_id) ? "" : $data->customer->name',
            ),
            array(
                'header' => 'Insurance',
                'name' => 'insurance_company_id',
                'value' => 'empty($data->insurance_company_id) ? "" : $data->insuranceCompany->name',
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
            array(
                'header' => 'Invoice #',
                'value' => '$data->getInvoice($data)'
            ),            
//            array(
//                'header' => 'Invoice #',
//                'filter' => false,
//                'value' => function($data) {
//                    $invoiceCriteria = new CDbCriteria;
//                    $invoiceCriteria->addCondition("status !='CANCELLED'");
//                    $invoiceCriteria->addCondition("registration_transaction_id = " . $data->id);
//                    $invoice = InvoiceHeader::model()->find($invoiceCriteria);
//                    $invoiceNumber = "";
//                    
//                    if (!empty($invoice)) {
//                        $invoiceNumber = $invoice->invoice_number;
//                    }
//                    
//                    return $invoiceNumber;
//                }
//            ),
            'payment_status',
            array(
                'header' => 'Vehicle Status',
                'value' => '$data->vehicle->status_location'
            ),
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
                'template' => '{views}',
                'buttons' => array(
                    'views' => array(
                        'label' => 'view',
                        'url' => 'Yii::app()->createUrl("frontDesk/bodyRepairRegistration/view", array("id"=>$data->id))',
                        'visible' => 'Yii::app()->user->checkAccess("bodyRepairCreate") || Yii::app()->user->checkAccess("bodyRepairEdit") || Yii::app()->user->checkAccess("bodyRepairView")',
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