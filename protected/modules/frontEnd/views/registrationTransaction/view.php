<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Registration Transactions' => array('admin'),
    $model->id,
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Show BR/GR #<?php echo CHtml::encode(CHtml::value($model, 'id')); ?></h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Manage', array("admin"), array('class' => 'btn btn-info btn-sm')); ?>
            <?php echo CHtml::link('Edit', array("update", 'id' => $model->id), array('class' => 'btn btn-warning btn-sm')); ?>
            <?php if (empty($model->sales_order_number)): ?>
                <?php echo CHtml::button('Generate Sales Order', array(
                    'id' => 'detail-button',
                    'name' => 'Detail',
                    'class' => 'button cbutton left',
                    'style' => 'margin-right:10px',
                    'disabled' => $model->sales_order_number == null ? false : true,
                    'onclick' => ' 
                        $.ajax({
                            type: "POST",
                            //dataType: "JSON",
                            url: "' . CController::createUrl('generateSalesOrder', array('id' => $model->id)) . '",
                            data: $("form").serialize(),
                            success: function(html) {
                                alert("Sales Order Succesfully Generated");
                                location.reload();
                            },
                        })
                    '
                )); ?>
            <?php endif; ?>

            <?php if (count($model->registrationServices) > 0 && empty($model->work_order_number)): ?>
                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Work Order', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/generateWorkOrder?id=' . $model->id, array(
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

        </div>
    </div>
</div>

<hr />

<?php echo CHtml::beginForm(); ?>
    <table class="table table-bordered table-striped">
        <tbody>
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
        </tbody>
    </table>

    <hr />

    <table class="table table-bordered table-responsive">
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
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No Messages!</td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="3">
                    Tambah Memo: 
                    <?php echo CHtml::textField('Memo', $memo, array(
                        'class' => 'form-control',
                        'size' => 10, 
                        'maxLength' => 100
                    )); ?> <br />
                    <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'SubmitMemo', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn btn-success')); ?>
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
            $tabsArray['Movement'] = array(
                'id' => 'movement',
                'content' => $this->renderPartial('_viewMovement', array(
                    'model' => $model,
                    'products' => $products,
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