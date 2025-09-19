<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 30% }
    .width1-4 { width: 10% }
    .width1-5 { width: 20% }
    .width1-6 { width: 5% }
    .width1-7 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Penjualan</div>
    <div style="font-size: larger">
        <?php echo CHtml::encode(CHtml::value($product, 'id')); ?> - 
        <?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?> -
        <?php echo CHtml::encode(CHtml::value($product, 'name')); ?>
    </div>
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
                    <th class="width1-4">Plat #</th>
                    <th class="width1-5">Vehicle</th>
                    <th class="width1-6">Status</th>
                    <th class="width1-7">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalQuantity = '0.00'; ?>
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $quantity = CHtml::value($header, 'quantity'); ?>
                    <tr class="items1">
                        <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'invoice.invoice_number')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice->invoice_date))); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'invoice.customer.name')); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.plate_number')); ?></td>
                        <td class="width1-5">
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carModel.name')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carSubModel.name')); ?>
                        </td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'invoice.status')); ?></td>
                        <td class="width1-7" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantity)); ?>
                        </td>
                    </tr>
                    <?php $totalQuantity += $quantity; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalQuantity)); ?>
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