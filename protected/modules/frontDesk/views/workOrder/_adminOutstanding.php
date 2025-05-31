<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 10% }
    .width1-3 { width: 7% }
    .width1-4 { width: 10% }
    .width1-5 { width: 5% }
    .width1-6 { width: 10% }
    .width1-7 { width: 7% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 5% }
    .width1-11 { width: 10% }
    .width1-12 { width: 10% }
    .width1-13 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">WO Outstanding (pending invoices)</div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Vehicle ID</th>
            <th class="width1-2">Plat #</th>
            <th class="width1-3">Tanggal RG</th>
            <th class="width1-4">Kendaraan</th>
            <th class="width1-5">Warna</th>
            <th class="width1-6">WO #</th>
            <th class="width1-7">Tanggal WO</th>
            <th class="width1-8">Invoice #</th>
            <th class="width1-9">Services</th>
            <th class="width1-10">Repair Type</th>
            <th class="width1-11">Problem</th>
            <th class="width1-12">User</th>
            <th class="width1-13">WO Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($workOrderSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <th class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'vehicle_id')); ?></th>
                <th class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></th>
                <th class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($header, 'transaction_date'))); ?></th>
                <th class="width1-4">
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?>
                </th>
                <th class="width1-5"><?php echo CHtml::encode($header->vehicle->getColor($header->vehicle,"color_id")); ?></th>
                <th class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></th>
                <th class="width1-7"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($header, 'work_order_date'))); ?></th>
                <th class="width1-8"><?php echo CHtml::encode($header->getInvoice($header)); ?></th>
                <th class="width1-9"><?php echo CHtml::encode($header->getServices()); ?></th>
                <th class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></th>
                <th class="width1-11"><?php echo CHtml::encode(CHtml::value($header, 'problem')); ?></th>
                <th class="width1-12"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></th>
                <th class="width1-13"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></th>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>