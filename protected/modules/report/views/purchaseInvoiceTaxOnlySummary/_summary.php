<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($purchaseOrderHeader, 'mainBranch.name')); ?></div>
    <div style="font-size: larger">Faktur Pembelian PPn (Rincian & Detail)</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th style="width: 3%">No</th>
                <th>PO #</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Invoice #</th>
                <th>Tanggal Invoice</th>
                <th>Tanggal SJ</th>
                <th>SJ #</th>
                <th>Faktur Pajak #</th>
                <th>PPn/Non</th>
                <th>DPP (Rp)</th>
                <th>Disc (Rp)</th>
                <th>Sub Total (Rp)</th>
                <th>PPn (Rp)</th>
                <th>Total</th>
                <th>Retur</th>
                <th>Hutang</th>
            </tr>
        </thead>
        <tbody>
            <?php $ordinalNumber = 1; ?>
            <?php foreach ($purchaseInvoiceSummary->dataProvider->data as $header): ?>
                <?php $receiveItems = TransactionReceiveItem::model()->findAll(array(
                    'condition' => 'purchase_order_id = :purchase_order_id AND invoice_date BETWEEN :start_date AND :end_date AND user_id_cancelled IS NULL',
                    'params' => array(
                        ':purchase_order_id' => $header->id,
                        ':start_date' => $startDate,
                        ':end_date' => $endDate,
                    )
                )); ?>
                <?php foreach ($receiveItems as $receiveItem): ?>
                    <tr class="items1">
                        <td style="text-align: center"><?php echo $ordinalNumber; ?></td>
                        <td>
                            <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array(
                                "/transaction/transactionPurchaseOrder/view", 
                                "id"=>$header->id
                            ), array("target" => "_blank")); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy hh:mm:ss', strtotime($header->purchase_order_date))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiveItem->invoice_date))); ?>
                            <?php echo substr(CHtml::encode($header->created_datetime), -8); ?>
                        </td>
                        <td>
                            <?php echo empty($header) ? '' : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiveItem->receive_item_date))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'supplier_delivery_number')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_tax_number')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'taxStatus')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItem, 'totalRetailPrice'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItem, 'totalPurchaseDiscount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItem, 'invoice_sub_total'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItem, 'invoice_tax_nominal'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItem, 'invoice_grand_total'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItem, 'purchase_return_amount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItem, 'invoice_payment_remaining'))); ?>
                        </td>
                    </tr>
                    <?php $ordinalNumber++; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>