<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 8% }
    .width1-4 { width: 15% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
');
?>

<div class="tab reportTab">
    <div class="tabHead">
        <div style="font-size: larger; font-weight: bold; text-align: center">Transaksi Detail Hutang Supplier</div>
        <div style="font-size: larger; font-weight: bold; text-align: center"><?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?></div>
        <div style="font-size: larger; font-weight: bold; text-align: center">
            <?php echo 'Per Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>
    
    <div class="clear"></div>
    
    <?php echo CHtml::beginForm('', 'get'); ?>
        <div class="row buttons">
            <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcelDetail')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>

    <br /> 
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="relative">
                <table class="report">
                    <thead style="position: sticky; top: 0">
                        <tr id="header1">
                            <th class="width1-1">Invoice #</th>
                            <th class="width1-2">Tanggal</th>
                            <th class="width1-3">Jatuh Tempo</th>
                            <th class="width1-4">PO #</th>
                            <th class="width1-5">Type</th>
                            <th class="width1-6">Invoice</th>
                            <th class="width1-7">Payment</th>
                            <th class="width1-8">Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $revenueSum = '0.00'; ?>
                        <?php $paymentAmountSum = '0.00'; ?>
                        <?php $paymentLeftSum = '0.00'; ?>
                        
                        <?php foreach ($invoiceHeaders as $invoiceHeader): ?>
                            <?php $revenue = CHtml::value($invoiceHeader, 'invoice_grand_total'); ?>
                            <?php $paymentAmount = '0.00'; ?>
                            <?php $paymentOutDetails = PayOutDetail::model()->with('paymentOut')->findAll(array(
                                'condition' => 't.receive_item_id = :invoice_id AND paymentOut.payment_date BETWEEN :start_date AND :end_date AND paymentOut.user_id_cancelled IS NULL',
                                'params' => array(
                                    ':start_date' => $startDate,
                                    ':end_date' => $endDate,
                                    ':invoice_id' => $invoiceHeader->id,
                                )
                            )); ?>
                            <?php foreach ($paymentOutDetails as $paymentOutDetail): ?>
                                <?php $paymentAmount += $paymentOutDetail->amount; ?>
                            <?php endforeach; ?>
                            <?php $paymentLeft = $revenue - $paymentAmount; ?>

                            <tr class="items1">
                                <td>
                                    <?php echo CHtml::link(CHtml::value($invoiceHeader, 'invoice_number'), array(
                                        '/transaction/transactionReceiveItem/showInvoice', 
                                        'id' => $invoiceHeader->id, 
                                    ), array('target' => '_blank')); ?>
                                </td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($invoiceHeader->invoice_date))); ?></td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($invoiceHeader->invoice_due_date))); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'purchaseOrder.purchase_order_no')); ?></td>
                                <td><?php echo CHtml::encode($invoiceHeader->purchaseOrder->getPurchaseStatus($invoiceHeader->purchaseOrder->purchase_type)); ?></td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $revenue)); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeft)); ?>
                                </td>
                            </tr>
                            <?php $revenueSum += $revenue; ?>
                            <?php $paymentAmountSum += $paymentAmount; ?>
                            <?php $paymentLeftSum += $paymentLeft; ?>

                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">TOTAL</td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $revenueSum)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmountSum)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeftSum)); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>