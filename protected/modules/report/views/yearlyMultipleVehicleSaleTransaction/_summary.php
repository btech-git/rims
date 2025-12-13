<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 3% }
    .width1-3 { width: 5% }
    .width1-4 { width: 15% }
    .width1-5 { width: 5% }
    .width1-6 { width: 15% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
    .width1-11 { width: 5% }
    .width1-11 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">
        Laporan Penjualan Kendaraan Customer Tahunan 
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div>Periode: <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<fieldset>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">ID</th>
                <th class="width1-3">Plate #</th>
                <th class="width1-4">Kendaraan</th>
                <th class="width1-5">Customer Type</th>
                <th class="width1-6">Name</th>
                <th class="width1-7"># of Invoice</th>
                <th class="width1-8">Total Invoice (Rp)</th>
                <th class="width1-9">Total Parts (Rp)</th>
                <th class="width1-10">Total Service (Rp)</th>
                <th class="width1-11">Date 1st Invoice</th>
                <th class="width1-12">Duration from 1st Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yearlyMultipleVehicleSaleReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItem['vehicle_id']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['plate_number']); ?></td>
                    <td>
                        <?php echo CHtml::encode($dataItem['car_make']); ?> -
                        <?php echo CHtml::encode($dataItem['car_model']); ?> -
                        <?php echo CHtml::encode($dataItem['car_sub_model']); ?>
                    </td>
                    <td><?php echo CHtml::encode($dataItem['customer_type']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['customer_name']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dataItem['invoice_quantity'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['grand_total'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_product'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_service'])); ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>