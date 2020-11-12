<?php
/* @var $this WorkOrderController */
/* @var $model WorkOrder */

$this->breadcrumbs = array(
    'Cashier' => array('cashier'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List WorkOrder', 'url' => array('admin')),
        // array('label'=>'Create WorkOrder', 'url'=>array('create')),
        // array('label'=>'Update WorkOrder', 'url'=>array('update', 'id'=>$model->id)),
        // array('label'=>'Delete WorkOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
        //array('label'=>'Manage WorkOrder', 'url'=>array('admin')),
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'payment-in-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>

<h1>BILL DETAIL</h1>

<?php
//$this->widget('zii.widgets.CDetailView', array(
// 'data'=>$model,
// 'attributes'=>array(
// 	'id',
// 	'work_order_number',
// 	'work_order_date',
// 	'registration_transaction_id',
// 	'user_id',
// 	'branch_id',
// ),
//)); 
?>
<?php //$model = RegistrationTransaction::model()->findByPk($model->registration_transaction_id);  ?>
<div class="row">


    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Transaction #</label>
        </div>
        <div class="small-8 columns">
            <?php echo CHtml::activeHiddenField($model, 'registration_transaction_id', array('value' => $model->id)); ?>
            <?php echo CHtml::activeTextField($model, 'registration_transaction_id', array('value' => $model->transaction_number, 'readonly' => true)); ?>
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Work Order #</label>
        </div>
        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'work_order_number', array('value' => $model->work_order_number, 'readonly' => true)); ?>
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Plate #</label>
        </div>
        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'plate_number', array('value' => $model->vehicle->plate_number, 'readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="row">
    <?php
    $invoiceCriteria = new CDbCriteria;
    $invoiceCriteria->addCondition("status != 'CANCELLED'");
    $invoiceCriteria->addCondition("registration_transaction_id = " . $model->id);
    ?>
    <?php $invoice = InvoiceHeader::model()->find($invoiceCriteria); ?>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Invoice #</label>
        </div>

        <div class="small-8 columns">
            <?php echo $form->hiddenField($payment, 'invoice_id', array('size' => 50, 'maxlength' => 50, 'value' => count(array($invoice)) > 0 ? $invoice->id : '')); ?>
            <?php echo CHtml::activeTextField($model, 'invoice_number', array('value' => count(array($invoice)) > 0 ? $invoice->invoice_number : '', 'readonly' => true)); ?>
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Customer</label>
        </div>

        <div class="small-8 columns">
            <?php echo CHtml::activeHiddenField($payment, 'customer_id', array('value' => $model->customer_id)); ?>
            <?php echo CHtml::activeTextField($model, 'customer_name', array('value' => $model->customer->name, 'readonly' => true)); ?>
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Car Make</label>
        </div>

        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'pic_name', array('value' => $model->vehicle->carMake != null ? $model->vehicle->carMake->name : '-', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Invoice Date</label>
        </div>

        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'invoice_date', array('value' => count(array($invoice)) > 0 ? $invoice->invoice_date : '', 'readonly' => true)); ?>
        </div>

    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">PIC</label>
        </div>

        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'pic_name', array('value' => $model->pic != null ? $model->pic->name : '-', 'readonly' => true)); ?>
        </div>
    </div>


    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Car Model</label>
        </div>

        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'pic_name', array('value' => $model->vehicle->carModel != null ? $model->vehicle->carModel->name : '-', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Status</label>
        </div>

        <div class="small-8 columns">
            <input type="text" readonly="true" id="Invoice_status" style="background-color:red; color:white; padding-left:5px" value="<?php echo count(array($invoice)) != 0 ? $invoice->status : '-'; ?>"> 
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Repair Type</label>
        </div>

        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'repair_type', array('value' => $model->repair_type, 'readonly' => true)); ?>
        </div>

        <div id="dp" class="hide">
            <div class="small-4 columns">
                <label for="">Amount</label>
            </div>

            <div class="small-8 columns">
                <?php echo CHtml::activeTextField($model, 'down_payment_amount'); ?>
            </div>
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Color</label>
        </div>

        <div class="small-8 columns">
            <?php $color = Colors::model()->findByPk($model->vehicle->color_id); ?>
            <?php echo CHtml::activeTextField($model, 'pic_name', array('value' => count(array($color)) > 0 ? $color->name : '-', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Total Price</label>
        </div>

        <div class="small-8 columns">
            <?php echo CHtml::activeTextField($model, 'total_price', array('value' => number_format($model->grand_total, 0), 'readonly' => true)); ?>
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Payment Amount</label>
        </div>

        <div class="small-8 columns">
            <input type="text" readonly="true" id="Invoice_payment_amount" value="<?php echo count(array($invoice)) > 0 ? $invoice->payment_amount : '0,00' ?>"> 
        </div>
    </div>

    <div class="large-4 columns">
        <div class="small-4 columns">
            <label for="">Payment Left</label>
        </div>

        <div class="small-8 columns">
            <input type="text" readonly="true" id="Invoice_payment_left" value="<?php echo count(array($invoice)) > 0 ? $invoice->payment_left : '0,00' ?>"> 
        </div>
    </div>
</div>


<fieldset>
    <legend>Detail</legend>
    <?php if (count($registrationQuickServices) != 0) : ?>
        <table class="detail">
            <thead>
                <tr>
                    <th>Quick Service</th>
                    <th>Services</th>
                    <th>Price</th>
                    <th>Hour</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($registrationQuickServices as $key => $registrationQuickService): ?>
                    <tr>
                        <td><?php echo $registrationQuickService->quickService->code; ?></td>
                        <td><?php
                            $first = true;
                            $rec = "";
                            $qsDetails = QuickServiceDetail::model()->findAllByAttributes(array('quick_service_id' => $registrationQuickService->quick_service_id));
                            foreach ($qsDetails as $qssDetail) {
                                $service = Service::model()->findByPk($qssDetail->service_id);
                                if ($first === true) {
                                    $first = false;
                                } else {
                                    $rec .= ', ';
                                }
                                $rec .= $service->name;
                            }
                            echo $rec;
                            ?></td>
                        <td><?php echo number_format($registrationQuickService->price, 0); ?></td>
                        <td><?php echo $registrationQuickService->hour; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php
    //$registrationServices = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$model->id,'is_body_repair'=>0)); 
    ?>
    <?php if (count($registrationServices) != 0) : ?>
        <table class="detail">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Product Used</th>
                    <th>Quick Service?</th>
                    <th>Price</th>
                    <th>Discount Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrationServices as $key => $registrationService): ?>
                    <tr>
                        <td><?php echo $registrationService->service->name; ?></td>
                        <td><?php
                    $first = true;
                    $rec = "";
                    $smDetails = ServiceMaterial::model()->findAllByAttributes(array('service_id' => $registrationService->service_id));
                    foreach ($smDetails as $smDetail) {
                        $product = Product::model()->findByPk($smDetail->product_id);
                        if ($first === true) {
                            $first = false;
                        } else {
                            $rec .= ', ';
                        }
                        $rec .= $product->name;
                    }
                    echo $rec;
                    ?></td>
                        <td><?php echo $registrationService->is_quick_service == 1 ? 'YES' : 'NO' ?></td>
                        <td><?php echo number_format($registrationService->price, 0); ?></td>
                        <td><?php echo number_format($registrationService->discount_price, 0); ?></td>
                        <td><?php echo number_format($registrationService->total_price, 0); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php if (count($registrationProducts) > 0): ?>
        <table class="detail">
            <thead>
                <tr>
                    <th>Product name</th>
                    <th>Quantity</th>
                    <th>Retail Price</th>
                    <th>HPP</th>
                    <th>Sale Price</th>
                    <th>Discount Type</th>
                    <th>Discount</th>
                    <th>Total Price</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrationProducts as $i => $registrationProduct): ?>
                    <tr>
                        <td><?php echo $registrationProduct->product->name; ?></td>
                        <td><?php echo $registrationProduct->quantity; ?></td>
                        <td><?php echo number_format($registrationProduct->retail_price, 0); ?></td>
                        <td><?php echo number_format($registrationProduct->hpp, 0); ?></td>
                        <td><?php echo number_format($registrationProduct->sale_price, 0); ?></td>
                        <td><?php echo $registrationProduct->discount_type; ?></td>
                        <td><?php echo number_format($registrationProduct->discount, 0); ?></td>
                        <td><?php echo number_format($registrationProduct->total_price, 0); ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</fieldset>
<div class="payment">
    <fieldset >
        <legend>Payment</legend>
        <div class="row">
            <div class="large-4 columns">
                <div class="small-5 columns">
                    <?php echo $form->labelEx($payment, 'payment_number'); ?>
                </div>
                <div class="small-7 columns">
                    <?php //echo $form->textField($payment, 'payment_number', array('readonly' => true)); ?>
                    <?php echo CHtml::encode(CHtml::value($payment, 'payment_number')); ?>
                </div>

            </div>
            <div class="large-4 columns">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($payment, 'payment_date'); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($payment, 'payment_date', array('readonly' => true)); ?>
                    <?php /* $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                      'model' => $payment,
                      'attribute' => "payment_date",
                      'options'=>array(
                      'dateFormat' => 'yy-mm-dd',
                      'changeMonth'=>true,
                      'changeYear'=>true,
                      'yearRange'=>'1900:2020'
                      ),
                      'htmlOptions'=>array(
                      'value'=>date('Y-m-d'),
                      //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                      ),
                      )); */ ?>
                </div>

            </div>
            <div class="large-4 columns">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($payment, 'payment_type_id'); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::activeDropDownlist($payment, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array('prompt' => '[--Select Payment Type--]')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="large-4 columns">
                <div class="small-5 columns">
                    <?php echo $form->labelEx($payment, 'payment_amount'); ?>
                </div>
                <div class="small-7 columns">
                    <?php echo $form->textField($payment, 'payment_amount', array('size' => 18, 'value' => 0, 'maxlength' => 18, 'readonly' => $payment->isNewRecord ? false : true,
                        'onchange' => '
                        var relCount = $("#PaymentIn_invoice_id").attr("rel");
                        var count = 0;
                        var status = $("#Invoice_status").val();

                        // if(status == "NOT PAID")
                        // 	alert(status);
                        var paymentAmount = $("#PaymentIn_payment_amount").val();
                        var invoiceAmount = $("#RegistrationTransaction_total_price").val();
                        var invoiceLeft = $("#Invoice_payment_left").val();
                        console.log(paymentAmount);
                        console.log(invoiceAmount);
                        console.log(invoiceLeft);
                        if (status == "NOT PAID") {
                            count = invoiceAmount - paymentAmount;
                        } else {
                            count = invoiceLeft - paymentAmount;
                        }
                        if (count < 0) {
                            alert("Payment Amount could not be higher than Invoice Amount");
                            $("#PaymentIn_payment_amount").val("");
                        }

                    ')); ?>
                </div>
            </div>
            <div class="large-4 columns">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($payment, 'notes'); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->textArea($payment, 'notes', array('rows' => 6, 'cols' => 50)); ?>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="large-4 columns">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($payment, 'user_id'); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->hiddenField($payment, 'user_id', array('value' => $payment->isNewRecord ? Yii::app()->user->getId() : $model->user_id, 'readonly' => true)); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'user.username')); ?>
                </div>

            </div>
            <div class="large-4 columns">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($payment, 'branch_id'); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->dropDownlist($payment, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                        'prompt' => '[--Select Branch--]',
                        'onchange' => 'jQuery.ajax({
                            type: "POST",
                            url: "' . CController::createUrl('ajaxGetCompanyBank') . '",
                            data: jQuery("form").serialize(),
                            success: function(data){
                                console.log(data);
                                jQuery("#PaymentIn_company_bank_id").html(data);
                            },
                        });'
                    )); ?>
                </div>
            </div>
            <div class="large-4 columns">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($payment, 'company_bank_id'); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->dropDownlist($payment, 'company_bank_id', array(), array('prompt' => '[--Select Company Bank--]',
                    ));
                    ?>
                    <?php echo $form->error($payment, 'company_bank_id'); ?>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="row">
        <div class="large-8 columns">

        </div>
        <div class="large-4 columns">
            <div class="small-4 columns">

            </div>
            <div class="small-8 columns">
                <?php echo CHtml::submitButton('PAY', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
        </div>
    </div>
</div> <!-- end class payment -->
<?php $this->endWidget(); ?>
<script>
    if (($("#Invoice_status").val() == "PAID")) {
        $(".payment").hide();
        $("#Invoice_status").css("background-color", "green");
        $("#Invoice_status").css("color", "white");
    } else if ($("#Invoice_status").val() == "-") {
        $(".payment").hide();
    } else {
        $(".payment").show();
    }

</script>