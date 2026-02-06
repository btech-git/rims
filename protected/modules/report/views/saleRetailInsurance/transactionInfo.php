<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 15% }
    .width1-4 { width: 7% }
    .width1-5 { width: 8% }
    .width1-6 { width: 15% }
    .width1-7 { width: 7% }
    .width1-8 { width: 7% }
    .width1-9 { width: 8% }
    .width1-10 { width: 8% }
    .width1-11 { width: 8% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Penjualan <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($insuranceCompany, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">Invoice #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Customer</th>
                    <th class="width1-4">Type</th>
                    <th class="width1-5">Plat #</th>
                    <th class="width1-6">Kendaraan</th>
                    <th class="width1-7">Parts (Rp)</th>
                    <th class="width1-8">Jasa (Rp)</th>
                    <th class="width1-9">Total (Rp)</th>
                    <th class="width1-10">Pembayaran (Rp)</th>
                    <th class="width1-11">Sisa (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = '0.00'; ?>
                <?php $paymentTotal = '0.00'; ?>
                <?php $remainingTotal = '0.00'; ?>
                
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
                    <?php $paymentAmount = CHtml::value($header, 'payment_amount'); ?>
                    <?php $paymentLeft = CHtml::value($header, 'payment_left'); ?>
                    <tr class="items1">
                        <td>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($header, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => $header->id)), array('target' => '_blank')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'customer.customer_type')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'product_price'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'service_price'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeft)); ?>
                        </td>
                    </tr>
                    <?php $grandTotal += $totalPrice; ?>
                    <?php $paymentTotal += $paymentAmount; ?>
                    <?php $remainingTotal += $paymentLeft; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentTotal)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $remainingTotal)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $dataProvider->pagination->itemCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'currentPage' => $dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>