<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 8% }
    .width1-4 { width: 10% }
    .width1-5 { width: 20% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 5% }
    .width1-9 { width: 8% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 5% }
    .width2-5 { width: 5% }
    .width2-6 { width: 10% }
    .width2-7 { width: 5% }
    .width2-8 { width: 10% }
    .width2-9 { width: 10% }
    .width2-10 { width: 10% }
    .width2-11 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Body Repair Costing</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Transaction #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Plate #</th>
            <th class="width1-4">Kendaraan</th>
            <th class="width1-5">Customer</th>
            <th class="width1-6">Asuransi</th>
            <th class="width1-7">WO #</th>
            <th class="width1-8">WO Status</th>
            <th class="width1-9">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bodyRepairCostingSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'transaction_number')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'transaction_date')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-4">
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                </td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'insuranceCompany.name')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'grand_total'))); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="10">
                    <table>
                        <?php $workOrderExpenses = WorkOrderExpenseHeader::model()->findAllByAttributes(array('registration_transaction_id' => $header->id)); ?>
                        <?php foreach ($workOrderExpenses as $workOrderExpense): ?>
                            <?php foreach ($workOrderExpense->workOrderExpenseDetails as $detail): ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::encode(CHtml::value($workOrderExpense, 'transaction_number')); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($workOrderExpense, 'transaction_date')))); ?>
                                    </td>
                                    <td class="width2-3">
                                        <?php echo CHtml::encode(CHtml::value($workOrderExpense, 'note')); ?>
                                    </td>
                                    <td class="width2-4">
                                        <?php echo CHtml::encode(CHtml::value($workOrderExpense, 'supplier.name')); ?>
                                    </td>
                                    <td class="width2-5">
                                        <?php echo CHtml::encode(CHtml::value($detail, 'description')); ?>
                                    </td>
                                    <td class="width2-6">
                                        <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                                    </td>
                                    <td class="width2-7" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <?php $materialRequestHeaders = MaterialRequestHeader::model()->findAllByAttributes(array('registration_transaction_id' => $header->id)); ?>
                        <?php foreach ($materialRequestHeaders as $materialRequestHeader): ?>
                            <?php $movementOutHeaders = MovementOutHeader::model()->findAllByAttributes(array('material_request_header_id' => $materialRequestHeader->id)); ?>
                            <?php foreach ($movementOutHeaders as $movementOutHeader): ?>
                                <?php foreach ($movementOutHeader->movementOutDetails as $detail): ?>
                                    <?php $quantity = CHtml::encode(CHtml::value($detail, 'quantity')); ?>
                                    <?php $cogs = CHtml::encode(CHtml::value($detail, 'product.hpp')); ?>
                                    <?php $totalCost = $quantity * $cogs; ?>
                                    <tr>
                                        <td class="width2-1">
                                            <?php echo CHtml::encode(CHtml::value($movementOutHeader, 'movement_out_no')); ?>
                                        </td>
                                        <td class="width2-2">
                                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($movementOutHeader, 'date_posting')))); ?>
                                        </td>
                                        <td class="width2-3">
                                            <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                                        </td>
                                        <td class="width2-4">
                                            <?php echo CHtml::encode(CHtml::value($detail, 'warehouse.name')); ?>
                                        </td>
                                        <td class="width2-5" style="text-align: center">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantity)); ?>
                                        </td>
                                        <td class="width2-6" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cogs)); ?>
                                        </td>
                                        <td class="width2-7" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCost)); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>