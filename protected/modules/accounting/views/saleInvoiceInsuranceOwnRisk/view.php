<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs = array(
    'Invoice Headers' => array('admin'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', array("/accounting/saleInvoiceInsuranceOwnRisk/admin"), array(
            'class' => 'button cbutton left', 
            'style' => 'margin-left:10px', 
        )); ?>
        
        <?php if ($model->status !== 'CANCELLED!!!'): ?>
            <?php if (Yii::app()->user->checkAccess("salesHead")): ?>
                <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/accounting/saleInvoiceInsuranceOwnRisk/cancel", "id" => $model->id), array(
                    'class' => 'button alert right', 
                    'style' => 'margin-right:10px', 
                )); ?>
            <?php endif; ?>
        
            <?php if ($model->payment_remaining > '0.00'): ?>
                <?php echo CHtml::link('<span class="fa fa-plus"></span>Payment', array("/transaction/paymentIn/create", "invoiceOwnRiskId" => $model->id), array(
                    'class' => 'button success right', 
                    'style' => 'margin-right:10px', 
                )); ?>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if (Yii::app()->user->checkAccess("saleInvoiceEdit")): ?>
            <?php echo CHtml::link('<span class="fa fa-pencil"></span>Edit', array("/accounting/saleInvoiceInsuranceOwnRisk/update", "id" => $model->id), array(
                'class' => 'button warning right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php endif; ?>
        
        <?php if ($model->status != 'PAID'): ?> 
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Invoice', array("pdf", "id" => $model->id), array(
                'class' => 'button info right', 
                'style' => 'margin-right:10px', 
                'target' => '_blank',
            )); ?>
        <?php endif; ?>

        <br /><hr />
        
        <h1>View Invoice Own Risk #<?php echo $model->transaction_number; ?></h1>

        <table>
            <?php $registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
            <tr>
                <td>Invoice Number</td>
                <td><?php echo $model->transaction_number; ?></td>
                <td width="10%">Status</td>
                <td width="30%">
                    <input type="text" id ="status" style="background-color:red;color:white" value="<?php echo $model->status; ?>">
                </td>
            </tr>
            
            <tr>
                <td>Tanggal</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($model->transaction_date)); ?></td>
                <td>Customer</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?></td>
            </tr>
            
            <tr>
                <td>Jatuh Tempo (hari)</td>
                <td><?php echo CHtml::encode($model->customer->tenor); ?></td>
                <td width="10%">Vehicle</td>
                <td width="30%">
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carModel.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carSubModel.name')); ?>                    
                </td>
            </tr>
            
            <tr>
                <td width="10%">Registration #</td>
                <td width="30%">
                    <?php echo CHtml::link($registration->transaction_number, array(
                        $registration->repair_type == 'GR' ? "/frontDesk/generalRepairRegistration/show" : "/frontDesk/bodyRepairRegistration/show", 
                        "id" => $registration->id
                    ), array('target' => 'blank')); ?>
                </td>
                <td width="10%">Plate #</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'vehicle.plate_number')); ?></td>
            </tr>
            
            <tr>
                <td width="10%">Note</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'note')); ?></td>
                <td width="10%">Insurance Company</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'insuranceCompany.name')); ?></td>
            </tr>
            
            <?php if (Yii::app()->user->checkAccess("director")): ?>
                <tr>
                    <td width="10%">User Created</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'userIdCreated.username')); ?></td>
                    <td width="10%">Date Created</td>
                    <td width="30%"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", strtotime(CHtml::value($model, 'created_datetime')))); ?></td>
                </tr>

                <tr>
                    <td width="10%">User Edited</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'userIdEdited.username')); ?></td>
                    <td width="10%">Date Edited</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'edited_datetime')); ?></td>
                </tr>

                <tr>
                    <td width="10%">User Cancelled</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'userIdCancelled.username')); ?></td>
                    <td width="10%">Date Cancelled</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'cancelled_datetime')); ?></td>
                </tr>
            <?php endif; ?>
        </table>
        
        <fieldset>
            <legend>Details</legend>
            <?php if (count($model->registrationTransaction->registrationProducts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 3%">No</th>
                            <th style="text-align: center; width: 3%">ID</th>
                            <th style="text-align: center">Code</th>
                            <th style="text-align: center">Product</th>
                            <th style="text-align: center">Brand</th>
                            <th style="text-align: center">Category</th>
                            <th style="text-align: center">Quantity</th>
                            <th style="text-align: center">Satuan</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($model->registrationTransaction->registrationProducts as $i => $detail): ?>
                            <?php if ($detail->product_id != ""): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo $detail->product->id; ?></td>
                                    <td><?php echo $detail->product->manufacturer_code; ?></td>
                                    <td><?php echo $detail->product->name; ?></td>
                                    <td>
                                        <?php echo $detail->product->brand->name; ?> - 
                                        <?php echo $detail->product->subBrand->name; ?> - 
                                        <?php echo $detail->product->subBrandSeries->name; ?>
                                    </td>
                                    <td>
                                        <?php echo $detail->product->productMasterCategory->name; ?> -
                                        <?php echo $detail->product->productSubMasterCategory->name; ?> -
                                        <?php echo $detail->product->productSubCategory->name; ?>
                                    </td>
                                    <td style="text-align: center"><?php echo $detail->quantity; ?></td>
                                    <td><?php echo $detail->product->unit->name; ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php if (count($model->registrationTransaction->registrationServices) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 3%">No</th>
                            <th style="text-align: center; width: 3%">ID</th>
                            <th style="text-align: center">Service</th>
                            <th style="text-align: center">Type</th>
                            <th style="text-align: center">Category</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($model->registrationTransaction->registrationServices as $i => $detail): ?>
                            <?php if ($detail->service_id != ""): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo $detail->service->id; ?></td>
                                    <td><?php echo $detail->service->name; ?></td>
                                    <td><?php echo $detail->service->serviceType->name; ?></td>
                                    <td><?php echo $detail->service->serviceCategory->name; ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <table>
                <tr>
                    <td style="text-align: right; font-weight: bold;">Amount Own Risk</td>
                    <td style="text-align: right; font-weight: bold; width: 15%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'amount_invoice'))); ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; font-weight: bold;">Amount Paid</td>
                    <td style="text-align: right; font-weight: bold; width: 15%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'amount_payment'))); ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; font-weight: bold;">Amount Remaining</td>
                    <td style="text-align: right; font-weight: bold; width: 15%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'payment_remaining'))); ?>
                    </td>
                </tr>
            </table>
        </fieldset>

        <fieldset>
            <legend>Payment Details</legend>
            <?php /*if (count($payments) > 0): ?>
                <table>
                    <thead>
                        <th>Payment Number</th>
                        <th>Payment Date</th>
                        <th>Payment Type</th>
                        <th>Payment Amount</th>
                        <th>Notes</th>
                        <th>Stat</th>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($payments as $key => $payment): ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::link($payment->paymentIn->payment_number, array(
                                        "/transaction/paymentIn/show", 
                                        "id"=>$payment->payment_in_id
                                    ), array('target' => 'blank')); ?>
                                </td>
                                <td><?php echo $payment->paymentIn->payment_date; ?></td>
                                <td><?php echo $payment->paymentIn->paymentType->name; ?></td>
                                <td style="text-align: right"><?php echo number_format($payment->totalAmount, 2); ?></td>
                                <td><?php echo $payment->paymentIn->notes; ?></td>
                                <td><?php echo $payment->paymentIn->status; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <?php echo "No Payment For this Invoice."; ?>
            <?php endif; */ ?>
        </fieldset>
    </div>
</div>

<?php echo IdempotentManager::generate(); ?>

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
    
    var label = $('#status');
    var text = label.text();
    //console.log(label.text());
    if (label.val() === "PAID") {
        label.css("background-color", "green");
    }
</script>