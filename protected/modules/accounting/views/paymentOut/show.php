<?php $this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'View',
); ?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $paymentOut,
    'attributes' => array(
        array(
            'label' => 'Payment Out #',
            'value' => $paymentOut->payment_number,
        ),
        array(
            'label' => 'Tanggal Payment',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $paymentOut->payment_date),
        ),
        array(
            'label' => 'Supplier',
            'value' => $paymentOut->supplier->company,
        ),
        array(
            'label' => 'Code',
            'value' => $paymentOut->supplier->code,
        ),
        array(
            'label' => 'Address',
            'value' => $paymentOut->supplier->address,
        ),
        array(
            'label' => 'Branch',
            'value' => $paymentOut->branch->name,
        ),
        array(
            'label' => 'Payment Type',
            'value' => $paymentOut->paymentType->name,
        ),
        array(
            'label' => 'Giro #',
            'value' => $paymentOut->nomor_giro,
        ),
        array(
            'label' => 'Company Bank',
            'value' => empty($paymentOut->company_bank_id) ? "N/A" : $paymentOut->companyBank->account_name,
        ),
        array(
            'label' => 'Bank',
            'value' => empty($paymentOut->bank_id) ? "N/A" : $paymentOut->bank->name,
        ),
        array(
            'label' => 'COA Deposit',
            'value' => empty($paymentOut->coa_id_deposit) ? "N/A" : $paymentOut->coaIdDeposit->name,
        ),
        array(
            'label' => 'Admin',
            'value' => $paymentOut->user->username,
        ),
        array(
            'label' => 'Tanggal Input',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $paymentOut->created_datetime),
        ),
        array(
            'label' => 'Status',
            'value' => $paymentOut->status,
        ),
        array(
            'label' => 'Catatan',
            'value' => $paymentOut->notes,
        ),
    ),
));
?>

<br />

<table style="background-color: greenyellow">
    <?php if (empty($paymentOut->payOutDetails[0]->receive_item_id)): ?>
        <thead>
            <tr style="background-color: skyblue">
                <th style="text-align: center; width: 15%">Sub Pekerjaan #</th>
                <th style="text-align: center; width: 15%">Tanggal</th>
                <th style="text-align: center; width: 15%">RG #</th>
                <th style="text-align: center" colspan="3">Memo</th>
                <th style="text-align: center; width: 15%">Total Invoice</th>
                <th style="text-align: center; width: 15%">Payment</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($paymentOutDetails as $detail): ?>
                <tr style="background-color: azure">
                    <td>
                        <?php $workOrderExpenseHeader = WorkOrderExpenseHeader::model()->findByPk($detail->work_order_expense_header_id); ?>
                        <?php echo CHtml::encode($workOrderExpenseHeader->transaction_number); ?>
                    </td>

                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($workOrderExpenseHeader, 'transaction_date'))); ?>
                    </td>

                    <td>
                        <?php echo CHtml::link($workOrderExpenseHeader->registrationTransaction->transaction_number, array('javascript:;'), array(
                            'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                                "codeNumber" => $workOrderExpenseHeader->registrationTransaction->transaction_number
                            )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                        )); ?>
                    </td>

                    <td style="text-align: right" colspan="3">
                        <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                    </td>

                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_invoice'))); ?>
                    </td>

                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php else: ?>
        <thead>
            <tr style="background-color: skyblue">
                <th style="text-align: center; width: 15%">Invoice #</th>
                <th style="text-align: center; width: 15%">Tanggal Invoice</th>
                <th style="text-align: center; width: 15%">PO #</th>
                <th style="text-align: center; width: 15%">Tanggal PO</th>
                <th style="text-align: center; width: 15%">Jatuh Tempo</th>
                <th style="text-align: center">Memo</th>
                <th style="text-align: center; width: 15%">Total Invoice</th>
                <th style="text-align: center; width: 15%">Payment</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($paymentOutDetails as $detail): ?>
                <tr style="background-color: azure">
                    <td>
                        <?php $receiveItem = TransactionReceiveItem::model()->findByPk($detail->receive_item_id); ?>
                        <?php echo CHtml::encode($receiveItem->invoice_number); ?>
                    </td>

                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receiveItem, 'invoice_date'))); ?>
                    </td>

                    <td>
                        <?php echo CHtml::link($receiveItem->purchaseOrder->purchase_order_no, array('javascript:;'), array(
                            'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                                "codeNumber" => $receiveItem->purchaseOrder->purchase_order_no
                            )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receiveItem, 'purchaseOrder.purchase_order_date'))); ?>
                    </td>

                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receiveItem, 'invoice_due_date'))); ?>
                    </td>

                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                    </td>

                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_invoice'))); ?>
                    </td>

                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
    
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="6">Total</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentOut, 'totalInvoice'))); ?>
            </td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentOut, 'payment_amount'))); ?>
            </td>
        </tr>
    </tfoot>
</table>

<br />

<div id="maincontent">
    <div class="clearfix page-action">
        <fieldset>
            <legend>Attached Images</legend>

            <?php foreach ($postImages as $postImage):
                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentOut/' . $postImage->filename;
                $src = Yii::app()->baseUrl . '/images/uploads/paymentOut/' . $postImage->filename;
            ?>
                <div class="row">
                    <div class="small-3 columns">
                        <div style="margin-bottom:.5rem">
                            <?php echo CHtml::image($src, $paymentOut->payment_number . "Image"); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </fieldset>
    </div>
</div>