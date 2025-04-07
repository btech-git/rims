<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 20% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 20% }
    .width1-10 { width: 10% }
    .width1-11 { width: 10% }
    .width1-12 { width: 10% }
    .width1-13 { width: 10% }
    .width1-14 { width: 10% }
'); ?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Faktur Pembelian PPn</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">PO #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Supplier</th>
                <th class="width1-4">Invoice #</th>
                <th class="width1-5">Tanggal Invoice</th>
                <th class="width1-6">Tanggal SJ</th>
                <th class="width1-7">SJ #</th>
                <th class="width1-8">Faktur Pajak #</th>
                <th class="width1-9">PPn/Non</th>
                <th class="width1-10">DPP (Rp)</th>
                <th class="width1-11">Disc (Rp)</th>
                <th class="width1-12">Sub Total (Rp)</th>
                <th class="width1-13">PPn (Rp)</th>
                <th class="width1-14">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseInvoiceSummary->dataProvider->data as $header): ?>
                <?php $receiveHeader = TransactionReceiveItem::model()->findByAttributes(array('purchase_order_id' => $header->id)); ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy hh:mm:ss', strtotime($header->purchase_order_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($receiveHeader, 'invoice_number')); ?></td>
                    <td class="width1-5">
                        <?php echo empty($receiveHeader) ? '' : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiveHeader->invoice_date))); ?>
                        <?php echo empty($receiveHeader) ? '' : CHtml::encode(Yii::app()->dateFormatter->format('hh:mm:ss', strtotime($receiveHeader->created_datetime))); ?>
                    </td>
                    <td class="width1-6">
                        <?php echo empty($receiveHeader) ? '' : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiveHeader->receive_item_date))); ?>
                    </td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($receiveHeader, 'supplier_delivery_number')); ?></td>
                    <td class="width1-8"><?php echo CHtml::encode(CHtml::value($receiveHeader, 'invoice_tax_number')); ?></td>
                    <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'taxStatus')); ?></td>
                    <td class="width1-10" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'totalRetailPrice'))); ?>
                    </td>
                    <td class="width1-11" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'totalPurchaseDiscount'))); ?>
                    </td>
                    <td class="width1-12" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'subTotal'))); ?>
                    </td>
                    <td class="width1-13" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'taxNominal'))); ?>
                    </td>
                    <td class="width1-14" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'grandTotal'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <!--    <tfoot>
            <tr id="header1">
                <td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
                <td class="width1-5" style="text-align: right; font-weight: bold"> <?php /*echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($purchaseInvoiceSummary->dataProvider))); ?></td>
                <td class="width1-6" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($purchaseInvoiceSummary->dataProvider))); ?></td>
                <td class="width1-7" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($purchaseInvoiceSummary->dataProvider)));*/ ?></td>
                <td>&nbsp;</td>
            </tr>     
        </tfoot>-->
    </table>
</div>