<?php
/* @var $this InvoiceHeaderController */
/* @var $invoice->header InvoiceHeader */

$this->breadcrumbs=array(
    'Invoice'=>array('admin'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <h1>View Invoice #<?php echo $model->invoice_number; ?></h1>

        <table>
            <tr>
                <td>Invoice Number</td>
                <td><?php echo $model->invoice_number; ?></td>
                <td>Invoice Date</td>
                <td><?php echo $model->invoice_date; ?></td>
            </tr>
            
            <tr>
                <td>Reference Type</td>
                <td><?php echo $model->reference_type == 1 ? 'Sales Order' : 'Retail Sales'; ?></td>
                <td>Due Date</td>
                <td><?php echo $model->due_date; ?></td>
            </tr>
            
            <tr>
                <td>Reference Number</td>
                <td><?php if ($model->reference_type == 1): ?>
                        <?php echo $model->salesOrder->sale_order_no; ?>
                    <?php else : ?>
                        <?php echo $model->registration_transaction_id; ?>
                    <?php endif ?></td>
                <td>Branch</td>
                <td><?php echo $model->branch->name; ?></td>
            </tr>
            
            <tr>
                <td width="10%">Status</td>
                <td width="30%"><input type="text" id = "status" style="background-color:red;color:white" value="<?php echo $model->status; ?>"></td>
                <td width="10%">User_id</td>
                <td width="30%"><?php echo $model->user->username; ?></td>
            </tr>
            
            <tr>
                <td width="10%">Payment Bank</td>
                <td width="30%">
                    <?php echo CHtml::activeDropDownlist($model, 'coa_bank_id_estimate', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_sub_category_id' => 2)), 'id', 'name'), array(
                        'empty' => '[--Select Payment Bank--]',
                    )); ?>
                </td>
                <td width="10%">Payment Est Date</td>
                <td width="30%">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'model' => $model,
                        'attribute' => 'payment_date_estimate',
                        'options'=>array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
//                            'yearRange'=>'1900:2020'
                        ),
                        'htmlOptions'=>array(
                            'readonly' => true,
                        ),
                    )); ?>
                </td>
            </tr>
        </table>
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Update', array('name' => 'Update', 'class' => 'button cbutton', 'confirm' => 'Are you sure you want to update?')); ?>
        </div>
        
        <?php
        $productCriteria = new CDbCriteria;
        $productCriteria->addCondition('invoice_id =' . $model->id);
        $productCriteria->addCondition('product_id != ""');
        $products = InvoiceDetail::model()->findAll($productCriteria);
        ?>
        
        <?php
        $serviceCriteria = new CDbCriteria;
        $serviceCriteria->addCondition('invoice_id =' . $model->id);
        $serviceCriteria->addCondition('service_id != ""');
        $services = InvoiceDetail::model()->findAll($serviceCriteria);
        ?>
        
        <?php
        $QserviceCriteria = new CDbCriteria;
        $QserviceCriteria->addCondition('invoice_id =' . $model->id);
        $QserviceCriteria->addCondition('quick_service_id != ""');
        $Qservices = InvoiceDetail::model()->findAll($QserviceCriteria);
        ?>
        <fieldset>
            <legend>Details</legend>
            <?php if (count($products) > 0) : ?>
                <table>
                    <thead>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Price</th>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->product_id != ""): ?>
                                <tr>
                                    <td><?php echo $detail->product->name; ?></td>
                                    <td><?php echo $detail->quantity; ?></td>
                                    <td><?php echo number_format($detail->unit_price, 2); ?></td>
                                    <td><?php echo number_format($detail->total_price, 2); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php if (count($services) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->service_id != ""): ?>
                                <tr>
                                    <td ><?php echo $detail->service->name; ?></td>
                                    <td><?php echo number_format($detail->total_price, 2); ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php if (count($Qservices) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Quick Service</th>
                            <th>Unit Price</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->quick_service_id != ""): ?>
                                <tr>
                                    <td><?php echo $detail->quickService->name; ?></td>
                                    <td><?php echo number_format($detail->unit_price, 2); ?></td>
                                    <td><?php echo number_format($detail->total_price, 2); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <style type="text/css">
                .totalTable{
                    width:30% !important;float:right; border:none;background-color: white;
                }
                .totalTable tr td
                {
                    border:none;
                    background-color: white;
                }
                .title{
                    font-weight: bold;
                }
            </style>
            <table class="totalTable">
                <?php if ($model->reference_type == 2): ?>
                    <tr>
                        <td class="title">Service Price</td>
                        <td>Rp. <?php echo number_format($model->service_price, 2); ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td class="title"><?php echo $model->reference_type == 1 ? 'Subtotal' : 'Product Price' ?></td>
                    <td>Rp. <?php echo number_format($model->product_price, 2) ?></td>
                </tr>
                <?php if ($model->reference_type == 2): ?>
                    <tr>
                        <td class="title">Quick Service Price</td>
                        <td>Rp. <?php echo number_format($model->quick_service_price, 2); ?></td>
                    </tr>
                <?php endif ?>
                <tr>
                    <td class="title">Sub Total</td>
                    <td>Rp. <?php echo number_format($model->subTotal, 2) ?></td>
                </tr>
                <tr>
                    <td class="title">PPN(10%)</td>
                    <td>Rp. <?php echo $model->ppn == 1 ? number_format($model->ppn_total, 2) : 0.00; ?>
                        <?php //if ($model->status !=  "PAID"): ?>
<?php //echo CHtml::link('PPN<span class="fa fa-question"></span>', Yii::app()->baseUrl.'/transaction/invoiceHeader/ppn?id=' . $model->id. '&ppn_type=1&ref='.$model->reference_type, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.invoiceHeader.ppn")))  ?>
<?php //endif  ?>
                    </td>
                </tr>

                <?php if ($model->reference_type == 2): ?>
                    <tr>
                        <td class="title">PPH (2%) </td>
                        <td>Rp. <?php echo number_format($model->pph_total, 2) ?></td>
                    </tr>
                <?php endif ?>

                <tr>
                    <td class="title">Total Price</td>
                    <td><strong>Rp. <?php echo number_format($model->total_price, 2) ?></strong></td>
                </tr>	

                <tr>
                    <td class="title">Remaining Receivable</td>
                    <td><strong>Rp. <?php echo number_format($model->payment_left, 2) ?></strong></td>
                </tr>
            </table>
        </fieldset>

        <fieldset>
            <legend>Payment Details</legend>
            <?php if (count($payments) > 0): ?>
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
                                <td><?php echo $payment->payment_number; ?></td>
                                <td><?php echo $payment->payment_date; ?></td>
                                <td><?php echo $payment->payment_type; ?></td>
                                <td><?php echo number_format($payment->payment_amount, 2); ?></td>
                                <td><?php echo $payment->notes; ?></td>
                                <td><?php echo $payment->status; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <?php echo "No Payment For this Invoice."; ?>
            <?php endif ?>
        </fieldset>
    </div>
</div>

<?php echo CHtml::endForm(); ?>