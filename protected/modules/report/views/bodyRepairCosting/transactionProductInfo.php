<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 30% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan HPP Penjualan</div>
    <div style="font-size: larger">
        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'transaction_number')); ?> - 
        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($registrationTransaction->transaction_date))); ?>
    </div>
    <div><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'customer.name')); ?></div>
    <div>
        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carMake.name')); ?> -
        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carModel.name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carSubModel.name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.plate_number')); ?>
    </div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">ID</th>
                    <th class="width1-2">Code</th>
                    <th class="width1-3">Parts</th>
                    <th class="width1-4">Quantity</th>
                    <th class="width1-5">Satuan</th>
                    <th class="width1-6">Harga</th>
                    <th class="width1-7">Total</th>
                    <th class="width1-8">HPP</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalPriceSum = '0.00'; ?>
                <?php $totalHppSum = '0.00'; ?>
                <?php foreach ($registrationProductData as $registrationProductItem): ?>
                    <?php $totalPrice = CHtml::value($registrationProductItem, 'total_price'); ?>
                    <?php $hpp = CHtml::value($registrationProductItem, 'hpp'); ?>
                    <tr class="items1">
                        <td class="width1-1"><?php echo CHtml::encode(CHtml::value($registrationProductItem, 'product_id')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($registrationProductItem, 'product.manufacturer_code')); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($registrationProductItem, 'product.name')); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($registrationProductItem, 'quantity')); ?></td>
                        <td class="width1-5"><?php echo CHtml::encode(CHtml::value($registrationProductItem, 'unit.name')); ?></td>
                        <td class="width1-6" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationProductItem, 'sale_price'))); ?>
                        </td>
                        <td class="width1-7" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                        <td class="width1-8" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $hpp)); ?>
                        </td>
                    </tr>
                    <?php $totalPriceSum += $totalPrice; ?>
                    <?php $totalHppSum += $hpp; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="font-weight: bold; text-align: right">TOTAL</td>
                    <td style="font-weight: bold; text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum)); ?>
                    </td>
                    <td style="font-weight: bold; text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalHppSum)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>