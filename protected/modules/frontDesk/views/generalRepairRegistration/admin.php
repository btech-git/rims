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
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Registration', Yii::app()->baseUrl . '/frontDesk/customerRegistration/vehicleList', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("frontDesk.generalRepairRegistration.admin"))); ?>
        <h1>Manage General Repair Registrations</h1>
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
        // 'rowCssClassExpression' => '(($data->status == "Finished")?"hijau":(($data->status == "Pending")?"merah":""))',
        'columns' => array(
            array(
                'header' => '#',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1', //  row is zero based
            ),
            'transaction_number',
            // 'transaction_date',
            array(
                'name' => 'transaction_date',
                // 'value'=>'$data->transaction_date',
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
//            array('header'=>'Color','name'=>'car_color','value'=>'$data->vehicle->getColor($data->vehicle,"color_id")',
//             	'filter'=>CHtml::dropDownList('RegistrationTransaction[car_color]', 'car_color', CHtml::listData(Colors::model()->findAll(),'id','name'), array('class'=>'form-control','empty'=>'--Select Color--')),),
//            'work_order_number',
            array(
                'header' => 'Repair Type',
                'name' => 'repair_type',
                'value' => '$data->repair_type',
                'type' => 'raw',
                'filter' => false,
//                    CHtml::dropDownList('RegistrationTransaction[repair_type]', $model->repair_type, array(
//                    'GR' => 'General Repair',
//                    'BR' => 'Body Repair',
//                ), array('class' => 'form-control', 'empty' => '--Select Branch--')),
            ),
            array(
                'header' => 'Customer Name',
                'name' => 'customer_name',
                'value' => '$data->customer->name',
            ),
            'sales_order_number',
            array(
                'header' => 'Invoice #',
                'filter' => false,
                'value' => function($data) {
                    $invoiceCriteria = new CDbCriteria;
                    $invoiceCriteria->addCondition("status !='CANCELLED'");
                    $invoiceCriteria->addCondition("registration_transaction_id = " . $data->id);
                    $invoice = InvoiceHeader::model()->find($invoiceCriteria);
                    $invoiceNumber = "";
                    if (count($invoice) != 0)
                        $invoiceNumber = $invoice->invoice_number;
                    return $invoiceNumber;
                }
            ),
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
            array(
                'name'=>'branch_id',
                'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value'=>'$data->branch->name'
            ),
            'problem',
            array(
                'class' => 'CButtonColumn',
                'template' => '{views} {edit} {hapus}',
                'buttons' => array(
                    'views' => array(
                        'label' => 'view',
                        'url' => 'Yii::app()->createUrl("frontDesk/generalRepairRegistration/view", array("id"=>$data->id))',
                        'visible' => 'Yii::app()->user->checkAccess("transaction.generalRepairRegistration.view")'
                    ),
                    'edit' => array(
                        'label' => 'edit',
                        'url' => 'Yii::app()->createUrl("frontDesk/generalRepairRegistration/update", array("id"=>$data->id))',
                        'visible' => '$data->status != "Finished" && Yii::app()->user->checkAccess("transaction.generalRepairRegistration.update") && empty($data->invoiceHeaders)',
                    ),
                    'hapus' => array(
                        'label' => 'delete',
                        'url' => 'Yii::app()->createUrl("frontDesk/generalRepairRegistration/delete", array("id"=>$data->id))',
                        'visible' => '$data->status != "Finished" && Yii::app()->user->checkAccess("transaction.generalRepairRegistration.delete")'
                    ),
                ),
            ),
        ),
    )); ?>
</div>