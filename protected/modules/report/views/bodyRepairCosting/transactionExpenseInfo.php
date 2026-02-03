<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 20% }
    .width1-4 { width: 5% }
    .width1-5 { width: 15% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }
    .width1-8 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Sub Luar Penjualan</div>
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
                    <th class="width1-1">WO #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Supplier</th>
                    <th class="width1-4">Status</th>
                    <th class="width1-5">Note</th>
                    <th class="width1-6">Memo</th>
                    <th class="width1-7">Description</th>
                    <th class="width1-8">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalAmount = '0.00'; ?>
                <?php foreach ($workOrderExpenseData as $workOrderExpenseItem): ?>
                    <?php foreach ($workOrderExpenseItem->workOrderExpenseDetails as $workOrderExpenseDetail): ?>
                        <?php $amount = CHtml::value($workOrderExpenseDetail, 'amount'); ?>
                        <tr class="items1">
                            <td class="width1-1">
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($workOrderExpenseItem, 'transaction_number')), array(
                                    "/accounting/workOrderExpense/view", 
                                    "id" => $workOrderExpenseItem->id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td class="width1-2">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($workOrderExpenseItem, 'transaction_date')))); ?>
                            </td>
                            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($workOrderExpenseItem, 'supplier.name')); ?></td>
                            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($workOrderExpenseItem, 'status')); ?></td>
                            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($workOrderExpenseItem, 'note')); ?></td>
                            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($workOrderExpenseDetail, 'memo')); ?></td>
                            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($workOrderExpenseDetail, 'description')); ?></td>
                            <td class="width1-8" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amount)); ?>
                            </td>
                        </tr>
                        <?php $totalAmount += $amount; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="font-weight: bold; text-align: right">TOTAL</td>
                    <td style="font-weight: bold; text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalAmount)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>