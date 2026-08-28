<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 8% }
    .width1-4 { width: 20% }
    .width1-5 { width: 10% }
    .width1-6 { width: 20% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
');
?>

<div class="tab reportTab">
    <div class="tabHead">
        <div style="font-size: larger; font-weight: bold; text-align: center">Transaksi Detail Piutang Customer</div>
        <div style="font-size: larger; font-weight: bold; text-align: center"><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></div>
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
                            <th class="width1-5">Plat #</th>
                            <th class="width1-6">Kendaraan</th>
                            <th class="width1-7">invoice</th>
                            <th class="width1-8">Payment</th>
                            <th class="width1-9">Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $revenueSum = '0.00'; ?>
                        <?php $paymentAmountSum = '0.00'; ?>
                        <?php $paymentLeftSum = '0.00'; ?>
                        
                        <?php foreach ($invoiceHeaders as $invoiceHeader): ?>
                            <?php $revenue = CHtml::value($invoiceHeader, 'total_price'); ?>
                            <?php $paymentAmount = '0.00'; ?>
                            <?php $paymentInDetails = PaymentInDetail::model()->with('paymentIn')->findAll(array(
                                'condition' => 't.invoice_header_id = :invoice_id AND paymentIn.payment_date BETWEEN :start_date AND :end_date AND paymentIn.user_id_cancelled IS NULL',
                                'params' => array(
                                    ':start_date' => $startDate,
                                    ':end_date' => $endDate,
                                    ':invoice_id' => $invoiceHeader->id,
                                )
                            )); ?>
                            <?php foreach ($paymentInDetails as $paymentInDetail): ?>
                                <?php $paymentAmount += $paymentInDetail->totalAmount; ?>
                            <?php endforeach; ?>
                            <?php $paymentLeft = $revenue - $paymentAmount; ?>

                            <tr class="items1">
                                <td>
                                    <?php echo CHtml::link(CHtml::value($invoiceHeader, 'invoice_number'), array(
                                        '/transaction/invoiceHeader/show', 
                                        'id' => $invoiceHeader->id, 
                                    ), array('target' => '_blank')); ?>
                                </td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($invoiceHeader->invoice_date))); ?></td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($invoiceHeader->due_date))); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.plate_number')); ?></td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carMake.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carModel.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carSubModel.name')); ?>
                                </td>
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