<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 8% }
    .width1-4 { width: 15% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 15% }
    .width1-8 { width: 5% }
    .width1-9 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Penjualan <?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></div>
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
                    <th class="width1-3">Plat #</th>
                    <th class="width1-4">Kendaraan</th>
                    <th class="width1-5">Code</th>
                    <th class="width1-6">Parts</th>
                    <th class="width1-7">Brand</th>
                    <th class="width1-8">Production Year</th>
                    <th class="width1-9">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalQuantity = '0.00'; ?>
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $quantity = CHtml::value($header, 'quantity'); ?>
                    <tr class="items1">
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.invoice_number')); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice->invoice_date))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.plate_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carModel.name')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carSubModel.name')); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'product.manufacturer_code')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'product.name')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($header, 'product.brand.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'product.subBrand.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'product.subBrandSeries.name')); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'production_year')); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?>
                        </td>
                    </tr>
                    <?php $totalQuantity += $quantity; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: center; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantity)); ?>
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