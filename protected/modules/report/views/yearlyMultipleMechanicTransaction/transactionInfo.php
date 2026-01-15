<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 8% }
    .width1-2 { width: 5% }
    .width1-3 { width: 15% }
    .width1-4 { width: 5% }
    .width1-5 { width: 15% }
    .width1-6 { width: 8% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Penjualan</div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead"><span style="float: right"><?php echo ReportHelper::summaryText($dataProvider); ?></span></div>
    
    <br /><br />
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">Invoice #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Customer</th>
                    <th class="width1-4">Plat #</th>
                    <th class="width1-5">Vehicle</th>
                    <th class="width1-6">WO #</th>
                    <th class="width1-7">Status</th>
                    <th class="width1-8">Parts (Rp)</th>
                    <th class="width1-9">Jasa (Rp)</th>
                    <th class="width1-10">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = '0.00'; ?>
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
                    <tr class="items1">
                        <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                        <td class="width1-5">
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                        </td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')); ?></td>
                        <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                        <td class="width1-8" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'product_price'))); ?>
                        </td>
                        <td class="width1-9" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'service_price'))); ?>
                        </td>
                        <td class="width1-10" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                        
                    </tr>
                    <?php $grandTotal += $totalPrice; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
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