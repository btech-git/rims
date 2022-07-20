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
                    <td><?php echo CHTml::link($receiveHeader->receive_item_no, array("/transaction/transactionReceiveItem/view", "id"=>$receiveHeader->id)); ?></td>
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
                    <td colspan="2">
                        <?php echo CHtml::link('<span class="fa fa-plus"></span>Add / Edit Supporting Docs', Yii::app()->baseUrl . '/transaction/transactionReceiveItem/addInvoice?id=' . $receiveHeader->id, array('visible' => Yii::app()->user->checkAccess("transaction.transactionReceiveItem.update"))) ?>
                    </td>
                </tr>
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
                                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveDetail, 'purchaseOrderDetail.unit_price'))); ?></td>
                                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveDetail, 'totalPrice'))); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="11" style="text-align: right">SUB TOTAL</td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveHeader, 'subTotal'))); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align: right">PPn 10%</td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveHeader, 'taxNominal'))); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align: right">GRAND TOTAL</td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveHeader, 'grandTotal'))); ?></td>
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