<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 8% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 20% }
    .width1-7 { width: 7% }
    .width1-8 { width: 7% }
    .width1-9 { width: 5% }
    .width1-10 { width: 8% }
    .width1-11 { width: 8% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Bahan Penjualan</div>
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
                    <th class="width1-1">Request #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Status</th>
                    <th class="width1-4">Note</th>
                    <th class="width1-5">Code</th>
                    <th class="width1-6">Parts</th>
                    <th class="width1-7">Qty Request</th>
                    <th class="width1-8">Qty Move Out</th>
                    <th class="width1-9">Satuan</th>
                    <th class="width1-10">HPP</th>
                    <th class="width1-11">Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalCost = '0.00'; ?>
                <?php foreach ($materialRequestData as $materialRequestItem): ?>
                    <?php foreach ($materialRequestItem->materialRequestDetails as $materialRequestDetail): ?>
                        <?php $quantityMovement = CHtml::value($materialRequestDetail, 'quantity_movement_out'); ?>
                        <?php $cogs = CHtml::value($materialRequestDetail, 'product.hpp'); ?>
                
                        <?php if ($materialRequestDetail->unit_id !== $materialRequestDetail->product->unit_id): ?>
                            <?php $conversionFactor = 1; ?>
                            <?php $unitConversion = UnitConversion::model()->findByAttributes(array(
                                'unit_from_id' => $materialRequestDetail->unit_id, 
                                'unit_to_id' => $materialRequestDetail->product->unit_id
                            )); ?>
                            <?php if ($unitConversion !== null): ?>
                                <?php $conversionFactor = $unitConversion->multiplier; ?>
                            <?php else: ?>
                                <?php $unitConversionFlipped = UnitConversion::model()->findByAttributes(array(
                                    'unit_from_id' => $materialRequestDetail->product->unit_id, 
                                    'unit_to_id' => $materialRequestDetail->unit_id
                                )); ?> 
                                <?php if ($unitConversionFlipped !== null): ?>
                                    <?php $conversionFactor = 1 / $unitConversionFlipped->multiplier; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php $cogs = $conversionFactor * $cogs; ?>
                        <?php endif; ?>
                
                        <?php $costAmount = $quantityMovement * $cogs; ?>
                        <tr class="items1">
                            <td>
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($materialRequestItem, 'transaction_number')), array(
                                    "/frontDesk/materialRequest/view", 
                                    "id" => $materialRequestItem->id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td>
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($materialRequestItem, 'transaction_date')))); ?>
                            </td>
                            <td><?php echo CHtml::encode(CHtml::value($materialRequestItem, 'status_document')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($materialRequestItem, 'note')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($materialRequestDetail, 'product.manufacturer_code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($materialRequestDetail, 'product.name')); ?></td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($materialRequestDetail, 'quantity'))); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityMovement)); ?>
                            </td>
                            <td><?php echo CHtml::encode(CHtml::value($materialRequestDetail, 'unit.name')); ?></td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cogs)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $costAmount)); ?>
                            </td>
                        </tr>
                        <?php $totalCost += $costAmount; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10" style="font-weight: bold; text-align: right">TOTAL</td>
                    <td style="font-weight: bold; text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCost)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>