<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div class="small-12 columns">
    <div id="maincontent">
        <div class="clearfix page-action">

            <?php $ccontroller = Yii::app()->controller->id; ?>
            <?php $ccaction = Yii::app()->controller->action->id; ?>
            <?php $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $model->id)); ?>
            <div class="row">
                <div class="large-12 columns">
                    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Registration', Yii::app()->baseUrl . '/frontEnd/generalRepair/admin', array('class' => 'button cbutton left', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit"))) ?>
             
                    <?php if ($model->status !== 'Finished' && $model->status !== 'CANCELLED!!!'): ?>
                        <?php if (!empty($model->sales_order_number) || !empty($model->work_order_number)): ?>
                            <?php echo CHtml::submitButton('Finish Transaction', array('name' => 'SubmitFinish', 'confirm' => 'Are you sure you want to finish this transaction?', 'class' => 'button info right', 'style' => 'margin-right:10px')); ?>
                            <?php echo CHtml::submitButton('Kendaraan Keluar Bengkel', array('name' => 'SubmitOffPremise', 'confirm' => 'Are you sure you want to set this vehice off-premise?', 'class' => 'button info right', 'style' => 'margin-right:10px')); ?>
                        <?php endif; ?>
                    
                        <?php if ($model->service_status !== 'Done' && $model->total_service > 0): ?>
                            <?php echo CHtml::submitButton('Finish Service', array('name' => 'SubmitService', 'confirm' => 'Are you sure you want to finish this services?', 'class' => 'button info right', 'style' => 'margin-right:10px')); ?>
                        <?php endif; ?>
                        
                        <?php if (Yii::app()->user->checkAccess("generalRepairEdit")): ?>
                            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit Customer Data', Yii::app()->baseUrl . '/frontEnd/generalRepair/update?id=' . $model->id, array('class' => 'button cbutton left', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("generalRepairEdit"))) ?>
                        <?php endif; ?>
                    
                        <?php if (count($invoices) == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Product & Service', Yii::app()->baseUrl . '/frontEnd/generalRepair/addProductService?registrationId=' . $model->id, array('class' => 'button success left', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit"))) ?>
                        <?php endif; ?>

                        <?php if (empty($model->sales_order_number)): ?>
                            <?php echo CHtml::button('Generate Sales Order', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'class' => 'button cbutton left',
                                'style' => 'margin-right:10px',
                                'onclick' => '$.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('generateSalesOrder', array('id' => $model->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        alert("Sales Order Succesfully Generated");
                                        location.reload();
                                    },
                                })'
                            )); ?>
                        <?php endif; ?>

                        <?php
                        $servicesReg = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $model->id, 'is_body_repair' => 0));
                        $quickServicesReg = RegistrationQuickService::model()->findByAttributes(array('registration_transaction_id' => $model->id));
                        ?>
                    
                        <?php if (count($model->registrationServices) > 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Work Order', Yii::app()->baseUrl . '/frontEnd/generalRepair/generateWorkOrder?id=' . $model->id, array(
                                'class' => 'button success left', 
                                'style' => 'margin-right:10px'
                            )); ?>
                        <?php endif; ?>
                    
                        <?php if (empty($invoices)): ?>
                            <?php if (!empty($model->registrationServices) && (!empty($model->registrationProducts) && $model->getTotalQuantityMovementLeft() == 0)): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', Yii::app()->baseUrl . '/transaction/invoiceHeader/create?registrationId=' . $model->id, array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px'
                                )); ?>
                            <?php elseif (!empty($model->registrationServices) && empty($model->registrationProducts)): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', Yii::app()->baseUrl . '/transaction/invoiceHeader/create?registrationId=' . $model->id, array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px'
                                )); ?>
                            <?php elseif (empty($model->registrationServices) && !empty($model->registrationProducts) && $model->getTotalQuantityMovementLeft() == 0): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', Yii::app()->baseUrl . '/transaction/invoiceHeader/create?registrationId=' . $model->id, array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px'
                                )); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")): ?>
                            <?php echo CHtml::button('Show Realization', array(
                                'id' => 'real-button',
                                'name' => 'Real',
                                'class' => 'button cbutton left',
                                'onclick' => 'window.location.href = "showRealization?id=' . $model->id . '";'
                            )); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                </div>
            </div>

            <h3>View Transaction <?php echo CHtml::encode(CHtml::value($model, 'repair_type')); ?># <?php echo $model->transaction_number; ?></h3>

            <fieldset>
                <!--<legend>Information</legend>-->
                <div class="row">
                    <table>
                        <tr>
                            <td>Transaction #</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'transaction_number')); ?></td>
                            <td>Customer</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:m:s", CHtml::value($model, 'transaction_date'))); ?></td>
                            <td>Type</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'customer.customer_type')); ?></td>
                        </tr>
                        <tr>
                            <td>Repair Type</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'repair_type')); ?></td>
                            <td>Address</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'customer.address')); ?></td>
                        </tr>
                        <tr>
                            <td>Document Status</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'status')); ?></td>
                            <td>Mobile Phone</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'customer.mobile_phone')); ?></td>
                        </tr>
                        <tr>
                            <td>Payment Status</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'payment_status')); ?></td>
                            <td>Email</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'customer.email')); ?></td>
                        </tr>
                        <tr>
                            <td>Vehicle Status</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'vehicle_status')); ?></td>
                            <td>Plate #</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'vehicle.plate_number')); ?></td>
                        </tr>
                        <tr>
                            <td>Problem</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'problem')); ?></td>
                            <td>Car Model</td>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carMake.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carModel.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carSubModel.name')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Sales Person</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'employeeIdSalesPerson.name')); ?></td>
                            <td>Mileage (KM)</td>
                            <td><?php echo CHtml::encode(CHtml::value($model, 'vehicle_mileage')); ?></td>
                        </tr>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
    
    <hr />

    <table>
        <thead>
            <tr>
                <th>Message</th>
                <th>Date</th>
                <th>Sent By</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($registrationMemos) > 0): ?>
                <?php foreach ($registrationMemos as $i => $registrationMemo): ?>
                    <tr>
                        <td><?php echo $registrationMemo->memo; ?></td>
                        <td><?php echo $registrationMemo->date_time; ?></td>
                        <td><?php echo $registrationMemo->user->username; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="3">
                    Tambah Memo: 
                    <?php echo CHtml::textField('Memo', $memo, array('size' => 10, 'maxLength' => 100)); ?> <br />
                    <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'SubmitMemo', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
                </td>
            </tr>
        </tbody>
    </table>

    <hr />

    <div class="detail">
        <fieldset>
            <legend>Details</legend>
            <?php
            $tabsArray = array();
            $tabsArray['Billing'] = array(
                'id' => 'billing',
                'content' => $this->renderPartial('_viewBilling', array(
                    'model' => $model,
                    'products' => $products,
                    'services' => $services,
                ), TRUE)
            );
            $tabsArray['Order'] = array(
                'id' => 'order',
                'content' => $this->renderPartial('_viewOrder', array(
                    'model' => $model
                ), TRUE)
            );
            $tabsArray['Movement'] = array(
                'id' => 'movement',
                'content' => $this->renderPartial('_viewMovement', array(
                    'model' => $model
                ), TRUE)
            );
            $tabsArray['History'] = array(
                'id' => 'history',
                'content' => $this->renderPartial('_viewHistory', array(
                    'model' => $model
                ), TRUE)
            );
            ?>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => $tabsArray,
                // additional javascript options for the tabs plugin
                'options' => array('collapsible' => true),
            )); ?>
        </fieldset>
    </div>
    
    <div>
        <?php if (Yii::app()->user->checkAccess("generalRepairSupervisor") && $model->status !== 'Finished' && $model->status !== 'CANCELLED!!!'): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/frontEnd/generalRepair/cancel", "id" => $model->id), array(
                'class' => 'button alert', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php endif; ?>

        <?php if (empty($model->work_order_number) && $model->status !== 'Pending' && empty($model->sales_order_number)): ?>
            <?php echo CHtml::link('<span class="fa fa-bookmark"></span>Pending', Yii::app()->baseUrl.'/frontEnd/generalRepair/pendingOrder?id=' . $model->id, array('class'=>'button secondary right', 'style' => 'margin-right:10px')) ?>
        <?php endif; ?>
        <?php if (!empty($model->work_order_number) && $model->total_service > 0): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Work Order', Yii::app()->baseUrl.'/frontEnd/generalRepair/pdfWorkOrder?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px', 'target' =>'_blank')) ?>
        <?php endif; ?>
        <?php if (!empty($model->sales_order_number) && $model->status !== 'Finished'): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Sales Order', Yii::app()->baseUrl.'/frontEnd/generalRepair/pdfSaleOrder?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px', 'target' =>'_blank')) ?>
        <?php endif; ?>
        <?php if ($model->status !== 'Finished'): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Estimasi', Yii::app()->baseUrl.'/frontEnd/generalRepair/pdf?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px', 'target' =>'_blank')) ?>
        <?php endif; ?>
    </div>
</div>

<?php echo CHtml::endForm(); ?>

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