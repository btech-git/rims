<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Pembelian Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Tanggal</th>
        <th class="width1-2">Jatuh Tempo</th>
        <th class="width1-3">PO #</th>
        <th class="width1-4">Supplier</th>
        <th class="width1-5">Payment Type</th>
        <th class="width1-6">Branch</th>
        <th class="width1-7">Grand Total</th>
        <th class="width1-8">Payment</th>
        <th class="width1-9">Remaining</th>
        <th class="width1-10">Approved By</th>

    </tr>
    <tr id="header2">
        <td colspan="10">&nbsp;</td>
    </tr>
    <?php foreach ($purchaseSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->estimate_payment_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode($header->payment_type); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'mainBranch.code')); ?></td>
            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($header->total_price))); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($header->payment_amount))); ?></td>
            <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($header->payment_left))); ?></td>
            <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'approval.username')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="10">&nbsp;</td>
        </tr>
    <?php endforeach; ?>
    <tr id="header1">
        <td colspan="6" style="text-align: right">TOTAL</td>
        <td class="width1-7" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($purchaseSummary->dataProvider))); ?></td>
        <td class="width1-8" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($purchaseSummary->dataProvider))); ?></td>
        <td class="width1-9" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($purchaseSummary->dataProvider))); ?></td>
    </tr>        
</table>