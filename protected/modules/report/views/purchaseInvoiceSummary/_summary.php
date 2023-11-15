<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 20% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Faktur Pembelian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Faktur #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Type</th>
        <th class="width1-4">Supplier</th>
        <th class="width1-5">Grand Total</th>
        <th class="width1-6">Payment</th>
        <th class="width1-7">Remaining</th>
        <th class="width1-8">Status</th>

    </tr>
    <tr id="header2">
        <td colspan="11">&nbsp;</td>
    </tr>
    <?php foreach ($purchaseInvoiceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-3"><?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?></td>
            <td class="width1-2"><?php echo CHtml::encode($header->getPurchaseStatus($header->purchase_type)); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->total_price))); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->payment_amount))); ?></td>
            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->payment_left))); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
        </tr>
    <?php endforeach; ?>
    <tr id="header1">
        <td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
        <td class="width1-5" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($purchaseInvoiceSummary->dataProvider))); ?></td>
        <td class="width1-6" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($purchaseInvoiceSummary->dataProvider))); ?></td>
        <td class="width1-7" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($purchaseInvoiceSummary->dataProvider))); ?></td>
        <td>&nbsp;</td>
    </tr>        
</table>