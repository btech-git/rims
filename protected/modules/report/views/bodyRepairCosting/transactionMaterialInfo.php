<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 5% }
    .width1-4 { width: 20% }
    .width1-5 { width: 10% }
    .width1-6 { width: 20% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 5% }
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
                    <th class="width1-8">Qty Movement</th>
                    <th class="width1-9">Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materialRequestData as $materialRequestItem): ?>
                    <?php foreach ($materialRequestItem->materialRequestDetails as $materialRequestDetail): ?>
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
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($materialRequestDetail, 'quantity_movement_out'))); ?>
                            </td>
                            <td><?php echo CHtml::encode(CHtml::value($materialRequestDetail, 'unit.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>