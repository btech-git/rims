<?php if (count($model->transactionReceiveItems) > 0): ?>
    <?php foreach ($model->transactionReceiveItems as $receiveHeader): ?>
        <?php if (!empty($receiveHeader->invoice_number)): ?>
            <table>
                <tr>
                    <td width="15%">Invoice #</td>
                    <td><?php echo $receiveHeader->invoice_number; ?></td>
                </tr>
                <tr>
                    <td width="15%">Tanggal</td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->invoice_date); ?></td>
                </tr>
                <tr>
                    <td width="15%">Faktur Pajak #</td>
                    <td><?php echo $receiveHeader->invoice_tax_number; ?></td>
                </tr>
                <tr>
                    <td width="15%">Jatuh Tempo</td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->invoice_due_date); ?></td>
                </tr>
                <tr>
                    <td width="15%">Receive Item No</td>
                    <td><?php echo CHTml::link($receiveHeader->receive_item_no, array("/transaction/transactionReceiveItem/show", "id"=>$receiveHeader->id), array('target' => 'blank')); ?></td>
                </tr>
                <tr>
                    <td width="15%">Tanggal</td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->receive_item_date); ?></td>
                </tr>
                <tr>
                    <td width="15%">Supplier SJ#</td>
                    <td><?php echo $receiveHeader->supplier_delivery_number; ?></td>
                </tr>
                <tr>
                    <td width="15%">Status</td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'approvalStatus')); ?></td>
                </tr>
                <?php if ($receiveHeader->is_approved_invoice == 1): ?>
                    <tr>
                        <td width="15%">Approved by</td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'userIdApprovalInvoice.username')); ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Approval Date</td>
                        <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->date_approval_invoice); ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Approval Time</td>
                        <td><?php echo Yii::app()->dateFormatter->format("H:i:s", $receiveHeader->time_approval_invoice); ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2" style="text-align: center">
                            <?php echo CHtml::link('<span class="fa fa-dollar"></span>Approve Invoice', Yii::app()->baseUrl . '/transaction/transactionReceiveItem/approvalInvoice?id=' . $receiveHeader->id) ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2">
                        <table>
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Product</td>
                                    <td>Code</td>
                                    <td>Kategori</td>
                                    <td>Brand</td>
                                    <td>Sub Brand</td>
                                    <td>Sub Brand Series</td>
                                    <td>Qty Order</td>
                                    <td>Qty Received</td>
                                    <td>Unit</td>
                                    <td>Price</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($receiveHeader->transactionReceiveItemDetails as $key => $receiveDetail): ?>
                                    <tr>
                                        <?php $product = $receiveDetail->product; ?>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'qty_request')); ?></td>
                                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'qty_received')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveDetail, 'purchaseOrderDetail.unit_price'))); ?></td>
                                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveDetail, 'totalPrice'))); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="11" style="text-align: right">SUB TOTAL</td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'subTotal'))); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align: right">PPn <?php echo CHtml::encode(CHtml::value($receiveHeader, 'purchaseOrder.tax_percentage'));?>%</td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'taxNominal'))); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align: right">GRAND TOTAL</td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'grandTotal'))); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <?php echo "NO DATA FOUND"; ?>
<?php endif; ?>