<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 75% }
    .width1-2 { width: 20% }

    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 10% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
    .width2-6 { width: 15% }
    .width2-7 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Rincian Penjualan per Pelanggan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Customer</th>
            <th class="width1-2">Type</th>
        </tr>
        <tr id="header2">
            <td colspan="2">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Jenis</th>
                        <th class="width2-4">Vehicle</th>
                        <th class="width2-5">Barang</th>
                        <th class="width2-6">Jasa</th>
                        <th class="width2-7">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleRetailSummary->dataProvider->data as $header): ?>
            <?php $grandTotal = CHtml::value($header, 'grand_total'); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($header->customer_type); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="7">
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $registrationTransactions = RegistrationTransaction::model()->findAll(array(
                            'condition' => 'customer_id = :customer_id AND transaction_date BETWEEN :start_date AND :end_date', 
                            'params' => array(
                                ':customer_id' => $header->id,
                                ':start_date' => $startDate,
                                ':end_date' => $endDate,
                            )
                        )); ?>
                        <?php if (!empty($registrationTransactions)): ?>
                            <?php foreach ($registrationTransactions as $detail): ?>
                                <?php $grandTotal = CHtml::value($detail, 'grand_total'); ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::link(CHtml::encode($detail->transaction_number), array("/frontDesk/registrationTransaction/view", "id"=>$detail->id), array("target" => "_blank")); ?></td>
                                    <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->transaction_date))); ?></td>
                                    <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'repair_type')); ?></td>
                                    <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'vehicle.plate_number')); ?></td>
                                    <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'subtotal_product'))); ?></td>
                                    <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'subtotal_service'))); ?></td>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
                                </tr>
                                <?php $totalSale += $grandTotal; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right" colspan="6">Total</td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                                <td>&nbsp;</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>