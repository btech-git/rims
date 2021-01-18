<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Registration Transactions' => array('admin'),
    'Cashier',
);

$this->menu = array(
    array('label' => 'List RegistrationTransaction', 'url' => array('admin')),
    array('label' => 'Create RegistrationTransaction', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
/*$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if ($(this).hasClass('active')){
            $(this).text('');
	} else {
            $(this).text('Customer Filter');
	}
	return false;
});*/
$('form').submit(function(){
    $('#registration-transaction-grid').yiiGridView('update', {
            data: $(this).serialize()
    });
    return false;
});
"); ?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">

        <h1>Cashier</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
                <div class="row">
                    <table>
                        <tr>
                            <td style="text-align: center; font-weight: bold">Transaction #</td>
                            <td style="text-align: center; font-weight: bold" colspan="2">Date</td>
                            <td style="text-align: center; font-weight: bold">Plate #</td>
                            <td style="text-align: center; font-weight: bold">Car Make</td>
                            <td style="text-align: center; font-weight: bold">Car Model</td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php echo CHtml::activeTextField($model, 'transaction_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            transaction_number: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <div>
                                    <?php $attribute = 'transaction_date'; ?>
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'=>$model,
                                        'attribute'=>$attribute."_from",
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date From',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                                    transaction_date_from: $(this).val(),
                                                    transaction_number: $("#' . CHtml::activeId($model, 'transaction_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                                    transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                                    car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                                    car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                                    work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                                    status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                                    repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                                    customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                                } } });
                                            ',
                                        ),
                                    )); ?>
                                </div>
                            </td>
                            
                            <td>                                
                                <div>
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'=>$model,
                                        'attribute'=>$attribute."_to",
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date To',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                                    transaction_date_to: $(this).val(),
                                                    transaction_number: $("#' . CHtml::activeId($model, 'transaction_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                                    transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                                    car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                                    car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                                    work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                                    status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                                    repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                                    customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                                } } });
                                            ',
                                        ),
                                    )); ?>
                                </div>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeTextField($model, 'plate_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            plate_number: $(this).val(),
                                            transaction_number: $("#' . CHtml::activeId($model, 'transaction_number') . '").val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'car_make_code', CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            car_make_code: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ' . CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                                        'update' => '#car_model',
                                    )),
                                )); ?>
                            </td>
                            
                            <td>
                                <div id="car_model">
                                    <?php echo CHtml::activeDropDownList($model, 'car_model_code', CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'onchange' => '
                                            $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                                car_model_code: $(this).val(),
                                                transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                                transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                                car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                                plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                                work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                                status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                                repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                                branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                                customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                            } } });
                                        ',
                                    )); ?>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: center; font-weight: bold">WO #</td>
                            <td style="text-align: center; font-weight: bold">Customer Name</td>
                            <td style="text-align: center; font-weight: bold">Customer Type</td>
                            <td style="text-align: center; font-weight: bold">WO Status</td>
                            <td style="text-align: center; font-weight: bold">Type</td>
                            <td style="text-align: center; font-weight: bold">Branch</td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php echo CHtml::activeTextField($model, 'work_order_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            work_order_number: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeTextField($model, 'customer_name', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            customer_name: $(this).val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_type: $("#' . CHtml::activeId($model, 'customer_type') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'customer_type', array(
                                    '' => '-- All --',
                                    'Company' => 'Company',
                                    'Individual' => 'Individual',
                                ),  array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            customer_type: $(this).val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'status', array(
                                    '' => '-- All --',
                                    'Registration' => 'Registration',
                                    'Pending' => 'Pending',
                                    'Available' => 'Available',
                                    'On Progress' => 'On Progress',
                                ), array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            status: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'repair_type', array(
                                    '' => '-- All --',
                                    'GR' => 'GR',
                                    'BR' => 'BR',
                                ), array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            repair_type: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {RegistrationTransaction: {
                                            branch_id: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($model, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'registration-transaction-grid',
                'dataProvider' => $model->searchByCashier(),
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'header' => '#',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1', //  row is zero based
                    ),
                    'transaction_number',
                    array(
                        'name' => 'transaction_date',
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)',
                    ),
                    array(
                        'name' => 'plate_number', 
                        'value' => '$data->vehicle->plate_number',
                    ),
                    array(
                        'name' => 'customer_name', 
                        'value' => '$data->customer != null? $data->customer->name : "-"'
                    ),
                    array(
                        'name' => 'grand_total', 
                        'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->grand_total)'
                    ),
                    'status',
                    array(
                        'name' => 'branch_id', 
                        'value' => '$data->branch_id != null? $data->branch->name : "-"'
                    ),
                    array(
                        'name' => 'invoice_number',
                        'header' => 'Invoice',
                        'value' => array($model, 'getInvoice'),
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{views}',
                        'buttons' => array(
                            'views' => array(
                                'label' => 'bill detail',
                                'url' => 'Yii::app()->createUrl("transaction/paymentIn/create",array("invoiceId"=>$data->invoiceHeaders[0]->id))',
                                'visible' => 'Yii::app()->user->checkAccess("frontDesk.registrationTransaction.billDetail") && !empty($data->invoiceHeaders)',
                                'click' => "js:function(){
                                    var url = $(this).attr('href');

                                    newwindow=window.open(url,'name','height=600,width=1200,left=100');
                                    if (window.focus) {newwindow.focus()}
                                    newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
                                    newwindow.onunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
                                    return false;
                                }"
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'customer-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Customer',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-grid',
    'dataProvider' => $customerDataProvider,
    'filter' => $customer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
        jQuery("#RegistrationTransaction_customer_id").val(jQuery.fn.yiiGridView.getSelection(id));
        jQuery("#customer-dialog").dialog("close");
        jQuery.ajax({
            type: "POST",
            dataType: "JSON",
            url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
            data: $("form").serialize(),
            success: function(data) {
                jQuery("#RegistrationTransaction_customer_name").val(data.name);
                $.fn.yiiGridView.update("registration-transaction-grid", {
                    data: $("#search_heading-range").serialize()
                });
            },
        });

        jQuery("#customer-grid").find("tr.selected").each(function(){
                $(this).removeClass( "selected" );
        });
    }',
    'columns' => array(
        'name',
        array(
            'header' => 'Customer Type',
            'value' => '$data->customer_type',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('Customer[customer_type]', $customer->customer_type, array(
                '' => 'All',
                'Individual' => 'Individual',
                'Company' => 'Company',
            )),
        ),
        'email',
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
