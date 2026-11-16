<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
<div class="row buttons">
    <?php echo CHtml::hiddenField('startDate', $startDate); ?>
    <?php echo CHtml::hiddenField('endDate', $endDate); ?>
    <?php echo CHtml::hiddenField('serviceId', $serviceId); ?>
    <?php echo CHtml::hiddenField('branchId', $branchId); ?>
    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel')); ?>
</div>

<?php echo CHtml::endForm(); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Penjualan <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($service, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="table_wrapper">
        <table class="responsive">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th>No.</th>
                    <th>Invoice #</th>
                    <th>Tanggal</th>
                    <th>Asuransi</th>
                    <th>Plat #</th>
                    <th>Vehicle</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>DPP (Rp)</th>
                    <th>PPn (Rp)</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = '0.00'; ?>
                
                <?php foreach ($dataProvider->data as $i => $header): ?>
                    <?php $unitPrice = CHtml::value($header, 'unit_price'); ?>
                    <?php $taxAmount = $unitPrice * CHtml::value($header, 'invoice.tax_percentage') / 100; ?>
                    <?php $totalPrice = $unitPrice + $taxAmount; ?>
                
                    <tr class="items1">
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.invoice_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice->invoice_date))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.insuranceCompany.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.plate_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carModel.name')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'invoice.vehicle.carSubModel.name')); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.customer.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.customer.customer_type')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice.status')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $unitPrice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxAmount)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                    </tr>
                    <?php $grandTotal += $totalPrice; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" style="text-align: right; font-weight: bold">TOTAL</td>
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