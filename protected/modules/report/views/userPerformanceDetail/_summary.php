<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 5% }
    .width1-4 { width: 35% }
    .width1-5 { width: 20% }
    .width1-6 { width: 5% }
    .width1-7 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $user = Users::model()->findByPk($userId); ?>
    <div style="font-size: larger">Laporan User Transaksi Log</div>
    <div><h2><?php echo CHtml::encode(CHtml::value($user, 'username')); ?></h2></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<fieldset>
    <legend>Registration Transaction</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Transaction #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-4">Customer</th>
                <th class="width1-2">Plat #</th>
                <th class="width1-5">Kendaraan</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createRegistrationTransactions as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'transaction_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-5">
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Work Order</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Transaction #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Kendaraan</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createWorkOrders as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->work_order_number), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'transaction_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Movement Out</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Transaction #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-4">Reference</th>
                <th class="width1-5">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createMovementOuts as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->movement_out_no), array("/transaction/movementOutHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'date_posting')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode($header->getMovementType($header->movement_type)); ?></td>
                    <td class="width1-5">
                        <?php if (!empty($header->delivery_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')); ?>
                        <?php elseif (!empty($header->return_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'returnOrder.return_order_no')); ?>
                        <?php elseif (!empty($header->material_request_header_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'materialRequestHeader.transaction_number')); ?>
                        <?php elseif (!empty($header->registration_transaction_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')); ?>
                        <?php else: ?>
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Invoice</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Invoice #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Reference</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Kendaraan</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createInvoices as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array("/transaction/invoiceHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'invoice_date')); ?></td>
                    <td class="width1-3">
                        <?php if (!empty($header->sales_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'salesOrder.sale_order_no')); ?>
                        <?php elseif (!empty($header->registration_transaction_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')); ?>
                        <?php else: ?>
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_price'))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Payment In</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Payment #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Note</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createPaymentIns as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array("/transaction/paymentIn/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'payment_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'payment_amount'))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Purchase Order</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Purchase #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-4">Supplier</th>
                <th class="width1-5">Note</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createPurchases as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'purchase_order_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_price'))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Penerimaan Barang</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Penerimaan #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-4">Supplier</th>
                <th class="width1-5">Ref #</th>
                <th class="width1-6">SJ #</th>
                <th class="width1-7">Note</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createReceives as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->receive_item_no), array("/transaction/transactionReceiveItem/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'receive_item_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'request_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td class="width1-5">
                        <?php if (!empty($header->purchase_order_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'purchaseOrder.purchase_order_no')); ?>
                        <?php elseif (!empty($header->transfer_request_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'transferRequest.transfer_request_no')); ?>
                        <?php elseif (!empty($header->consignment_in_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'consignmentIn.consignment_in_number')); ?>
                        <?php elseif (!empty($header->delivery_order_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')); ?>
                        <?php else: ?>
                        <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'supplier_delivery_number')); ?></td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Movement In</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Transaction #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-5">Ref #</th>
                <th class="width1-6">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createMovementIns as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->movement_in_number), array("/transaction/movementInHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'date_posting')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode($header->getMovementType($header->movement_type)); ?></td>
                    <td class="width1-5">
                        <?php if (!empty($header->return_item_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'returnItem.return_item_no')); ?>
                        <?php elseif (!empty($header->receive_item_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'receiveItem.receive_item_no')); ?>
                        <?php else: ?>
                        <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Pengiriman Barang</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Pengiriman #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-4">Tujuan</th>
                <th class="width1-5">Ref #</th>
                <th class="width1-6">ETA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createDeliveries as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->delivery_order_no), array("/transaction/transactionDeliveryOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'delivery_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'request_type')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td class="width1-5">
                        <?php if (!empty($header->sales_order_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'salesOrder.sale_order_no')); ?>
                        <?php elseif (!empty($header->sent_request_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'sentRequest.sent_request_no')); ?>
                        <?php elseif (!empty($header->consignment_out_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'consignmentOut.consignment_out_no')); ?>
                        <?php elseif (!empty($header->transfer_request_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'transferRequest.transfer_request_no')); ?>
                        <?php else: ?>
                        <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'estimate_arrival_date')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Transfer Request</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Transfer #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Status</th>
                <th class="width1-4">Tujuan</th>
                <th class="width1-6">ETA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createTransferRequests as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transfer_request_no), array("/transaction/transferRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'transfer_request_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'estimate_arrival_date')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Sent Request</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Sent #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Status</th>
                <th class="width1-4">Tujuan</th>
                <th class="width1-6">ETA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createSentRequests as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->sent_request_no), array("/transaction/transactionSentRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'sent_request_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'estimate_arrival_date')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Cash Transaction</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Transaction #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Type</th>
                <th class="width1-4">Note</th>
                <th class="width1-5">Payment</th>
                <th class="width1-6">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($createCashTransactions as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/transaction/cashTransaction/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'transaction_date')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'transaction_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />