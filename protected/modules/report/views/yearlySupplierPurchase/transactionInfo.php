<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
<div class="row buttons">
    <?php echo CHtml::hiddenField('year', $year); ?>
    <?php echo CHtml::hiddenField('month', $month); ?>
    <?php echo CHtml::hiddenField('branchId', $branchId); ?>
    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel')); ?>
</div>

<?php echo CHtml::endForm(); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Transaksi Detail Penjualan</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<div class="clear"></div>

<br />

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="table_wrapper">
        <table class="responsive">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th>Invoice #</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>PO #</th>
                    <th>SJ #</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = '0.00'; ?>
                
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $totalPrice = CHtml::value($header, 'invoice_grand_total'); ?>
                
                    <tr class="items1">
                        <td>
                            <?php echo CHtml::link(CHtml::value($header, 'invoice_number'), array(
                                '/transaction/invoiceHeader/show', 
                                'id' => $header->id, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'purchaseOrder.purchase_order_no')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'supplier_delivery_number')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'purchaseOrder.status_document')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                    </tr>
                    
                    <?php $grandTotal += $totalPrice; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
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