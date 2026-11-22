<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 30% }
    .width1-4 { width: 8% }
    .width1-5 { width: 20% }
    .width1-6 { width: 5% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
');
?>

<div class="tab reportTab">
    <div class="tabHead">
        <div style="font-size: larger; font-weight: bold; text-align: center">Transaksi Pembelian Parts</div>
        <div style="font-size: larger; font-weight: bold; text-align: center"><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></div>
        <div style="font-size: larger; font-weight: bold; text-align: center">
            <?php echo 'Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>
    
    <div class="clear"></div>
    
    <?php echo CHtml::beginForm('', 'get'); ?>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcelDetail')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>

    <br /> 
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="relative">
                <table class="report">
                    <thead style="position: sticky; top: 0">
                        <tr id="header1">
                            <th class="width1-1">PO #</th>
                            <th class="width1-2">Tanggal</th>
                            <th class="width1-3">Supplier</th>
                            <th class="width1-4">Status</th>
                            <th class="width1-5">Memo</th>
                            <th class="width1-6">Quantity</th>
                            <th class="width1-7">Unit Price</th>
                            <th class="width1-8">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalQuantity = '0.00'; ?>
                        <?php $totalPurchaseAmount = '0.00'; ?>
                        
                        <?php foreach ($purchaseDetails as $purchaseDetail): ?>
                            <?php $quantity = CHtml::value($purchaseDetail, 'quantity'); ?>
                            <?php $totalPrice = CHtml::value($purchaseDetail, 'total_price'); ?>

                            <tr class="items1">
                                <td>
                                    <?php echo CHtml::link(CHtml::value($purchaseDetail, 'purchaseOrder.purchase_order_no'), array(
                                        '/transaction/transactionPurchaseOrder/show', 
                                        'id' => $purchaseDetail->purchase_order_id, 
                                    ), array('target' => '_blank')); ?>
                                </td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($purchaseDetail->purchaseOrder->purchase_order_date))); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'purchaseOrder.supplier.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'purchaseOrder.status_document')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'memo')); ?></td>
                                <td style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetail->unit_price)); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                                </td>
                            </tr>
                            <?php $totalQuantity += $quantity; ?>
                            <?php $totalPurchaseAmount += $totalPrice; ?>

                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">TOTAL</td>
                            <td style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantity)); ?>
                            </td>
                            <td>&nbsp;</td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPurchaseAmount)); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>