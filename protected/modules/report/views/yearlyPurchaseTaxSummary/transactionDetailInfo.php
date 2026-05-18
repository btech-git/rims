<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 10% }
    .width1-4 { width: 7% }
    .width1-5 { width: 10% }
    .width1-6 { width: 7% }
    .width1-7 { width: 30% }
    .width1-8 { width: 14% }
');
?>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
<div class="row buttons">
    <?php echo CHtml::hiddenField('year', $year); ?>
    <?php echo CHtml::hiddenField('month', $month); ?>
    <?php echo CHtml::hiddenField('branchId', $branchId); ?>
    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel')); ?>
</div>

<?php echo CHtml::endForm(); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Transaksi Detail Pembelian PPn</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<div class="clear"></div>

<br />

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">PO #</th>
                    <th class="width1-2">Tanggal PO</th>
                    <th class="width1-3">Penerimaan #</th>
                    <th class="width1-4">Tanggal Terima</th>
                    <th class="width1-5">Invoice #</th>
                    <th class="width1-6">Tanggal Invoice #</th>
                    <th class="width1-7">Supplier</th>
                    <th class="width1-8">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalSum = '0.00'; ?>
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $totalAmount = CHtml::value($header, 'invoice_grand_total'); ?>
                    <tr class="items1">
                        <td class="width1-1">
                            <?php echo CHtml::link(CHtml::value($header, 'purchaseOrder.purchase_order_no'), array("/transaction/transactionPurchaseOrder/show", "id" => $header->purchase_order_id), array('target' => '_blank')); ?>
                        </td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchaseOrder->purchase_order_date))); ?></td>
                        <td class="width1-1">
                            <?php echo CHtml::link(CHtml::value($header, 'receive_item_no'), array("/transaction/transactionReceiveItem/show", "id" => $header->id), array('target' => '_blank')); ?>
                        </td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->receive_item_date))); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                        <td class="width1-5" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?>
                        </td>
                    </tr>
                    <?php $totalSum += $totalAmount; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align: right">TOTAL</td>
                    <td class="width1-5" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSum)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $dataProvider->pagination->itemCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'currentPage' => $dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>