<?php
$this->breadcrumbs=array(
    'Transaction Transfer Requests'=>array('admin'),
    'Manage',
); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Transfer Request Partial Delivery</h1>
         <div class="grid-view">
            <table class="report">
                <thead>
                    <tr id="header1">
                        <th class="width1-1">Request #</th>
                        <th class="width1-2">Request Date</th>
                        <th class="width1-3">Umur (hari)</th>
                        <th class="width1-4">Status</th>
                        <th class="width1-5">Requester</th>
                        <th class="width1-6">Destination</th>
                        <th class="width1-7">Delivery Status</th>
                        <th class="width1-8">Input User</th>
                        <th class="width1-9">Input Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($partialDeliveryReportData as $partialDeliveryReportItem): ?>
                        <tr class="items1">
                            <td><?php echo CHtml::encode($partialDeliveryReportItem['transaction_number']); ?></td>
                            <td>
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($partialDeliveryReportItem['transaction_date']))); ?>
                            </td>
                            <td><?php echo CHtml::encode($partialDeliveryReportItem['insurance']); ?></td>
                            <td><?php echo CHtml::encode($movementTransactionInfo); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partialDeliveryReportItem['product_price'])); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partialDeliveryReportItem['service_price'])); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partialDeliveryReportItem['ppn_total'])); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partialDeliveryReportItem['total_price'])); ?></td>
                            <td><?php echo CHtml::encode($partialDeliveryReportItem['invoice_number']); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partialDeliveryReportItem['payment_left'])); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partialDeliveryReportItem['payment_amount'])); ?></td>
                            <td><?php echo CHtml::encode($partialDeliveryReportItem['payment_number']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>