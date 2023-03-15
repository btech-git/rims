<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 5% }
    .width1-4 { width: 20% }
    .width1-5 { width: 10% }
    .width1-6 { width: 15% }
    .width1-7 { width: 20% }

    .width2-1 { width: 40% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Penjualan Retail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Penjualan #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Jenis</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">Vehicle</th>
            <th class="width1-6">Grand Total</th>
            <th class="width1-7">Status</th>
        </tr>
<!--        <tr id="header2">
            <td colspan="7">
                <table>
                    <tr>
                        <th class="width2-1">Barang/Jasa</th>
                        <th class="width2-2">Qty</th>
                        <th class="width2-3">Price</th>
                        <th class="width2-4">Discount</th>
                        <th class="width2-5">Total</th>
                    </tr>
                </table>
            </td>
        </tr>-->
    </thead>
    <tbody>
        <?php $totalSale = 0.00; ?>
        <?php foreach ($saleRetailSummary->dataProvider->data as $header): ?>
            <?php $grandTotal = CHtml::value($header, 'grand_total'); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/frontDesk/registrationTransaction/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
                <td class="width1-7"><?php echo CHtml::encode($header->status); ?></td>
            </tr>
            <?php $totalSale += $grandTotal; ?>
            
            <?php /*<tr class="items2">
                <td colspan="7">
                    <table>
                        <?php if (!empty($header->registrationProducts)): ?>
                            <?php foreach ($header->registrationProducts as $detailProduct): ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detailProduct, 'product.name')); ?></td>
                                    <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detailProduct, 'quantity')); ?></td>
                                    <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailProduct, 'sale_price'))); ?></td>
                                    <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailProduct, 'discountAmount'))); ?></td>
                                    <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailProduct, 'total_price'))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif (!empty($header->registrationServices)): ?>
                            <?php foreach ($header->registrationServices as $detailService): ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detailService, 'service.name')); ?></td>
                                    <td class="width2-2"><?php echo '1'; ?></td>
                                    <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailService, 'price'))); ?></td>
                                    <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailService, 'discountAmount'))); ?></td>
                                    <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailService, 'total_price'))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </td>
            </tr> */ ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="5">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>