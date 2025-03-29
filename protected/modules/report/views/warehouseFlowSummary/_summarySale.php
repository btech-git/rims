<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 27% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Perpindahan Barang Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">RG #</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">Vehicle</th>
            <th class="width1-6">Sales Order</th>
            <th class="width1-6">Work Order</th>
            <th class="width1-7">Movement Out</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleFlowSummary->dataProvider->data as $i => $header): ?>
            <?php $movementOutHeaders = $header->movementOutHeaders; ?>
            <?php $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders); ?>
            <?php $movementOutHeaderDates = array_map(function($movementOutHeader) { return Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($movementOutHeader->date_posting)); }, $movementOutHeaders); ?>
            <?php $movementOutHeaderTimes = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, -8); }, $movementOutHeaders); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($i + 1); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-3">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode(substr($header->transaction_date, -8)); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode($header->vehicle->plate_number); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'sales_order_number')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(implode(', ', $movementOutHeaderDates)); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(implode(', ', $movementOutHeaderTimes)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $saleFlowSummary->dataProvider->pagination->itemCount,
            'pageSize' => $saleFlowSummary->dataProvider->pagination->pageSize,
            'currentPage' => $saleFlowSummary->dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>