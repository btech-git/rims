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
    <div style="font-size: larger">Penjualan Body Repair</div>
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
            <th class="width1-10">HPP</th>
            <th class="width1-11">Sub Luar</th>
            <th class="width1-12">Bahan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bodyRepairCostingSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'transaction_number')); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy HH:mm:ss', strtotime(CHtml::value($header, 'transaction_date')))); ?>
                </td>
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
                <td class="width1-10" style="text-align: right">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'grand_total'))), array(
                        "/frontDesk/registrationTransaction/view", 
                        "id"=>$header->id
                    ), array("target" => "_blank")); ?>
                </td>
                <td class="width1-10" style="text-align: right">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'totalHpp'))), array(
                        '/report/bodyRepairCosting/transactionProductInfo', 
                        'registrationId' => $header->id, 
                    ), array("target" => "_blank")); ?>
                </td>
                <td class="width1-10" style="text-align: right">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'totalWorkOrderExpense'))), array(
                        '/report/bodyRepairCosting/transactionExpenseInfo', 
                        'registrationId' => $header->id, 
                    ), array("target" => "_blank")); ?>
                </td>
                <td class="width1-10" style="text-align: right">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'totalMaterialRequest'))), array(
                        '/report/bodyRepairCosting/transactionMaterialInfo', 
                        'registrationId' => $header->id, 
                    ), array("target" => "_blank")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>