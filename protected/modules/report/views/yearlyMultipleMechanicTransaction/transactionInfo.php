<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Penjualan</div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead"><span style="float: right"><?php echo ReportHelper::summaryText($dataProvider); ?></span></div>
    
    <br /><br />
    
    <div class="table_wrapper">
        <table class="responsive">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th>Invoice #</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Plat #</th>
                    <th>Kendaraan</th>
                    <th>WO #</th>
                    <th>Tanggal</th>
                    <th>Type</th>
                    <th>Problem</th>
                    <th>KM</th>
                    <th>Status</th>
                    <th>Parts List</th>
                    <th>Jasa List</th>
                    <th>Parts (Rp)</th>
                    <th>Jasa (Rp)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalProductPrice = '0.00'; ?>
                <?php $totalServicePrice = '0.00'; ?>
                <?php $grandTotal = '0.00'; ?>
                
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $productPrice = CHtml::value($header, 'product_price'); ?>
                    <?php $servicePrice = CHtml::value($header, 'service_price'); ?>
                    <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
                
                    <tr class="items1">
                        <td>
                            <?php echo CHtml::link(CHtml::value($header, 'invoice_number'), array(
                                '/transaction/invoiceHeader/show', 
                                'id' => $header->id, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link(CHtml::value($header, 'registrationTransaction.work_order_number'), array(
                                '/frontDesk/registrationTransaction/view', 
                                'id' => $header->registration_transaction_id, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($header, 'registrationTransaction.work_order_date')))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.repair_type')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.problem')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'registrationTransaction.vehicle_mileage'))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'productLists')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'serviceLists')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productPrice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $servicePrice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                    </tr>
                    
                    <?php $totalProductPrice += $productPrice; ?>
                    <?php $totalServicePrice += $servicePrice; ?>
                    <?php $grandTotal += $totalPrice; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="13" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductPrice)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServicePrice)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="right">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $dataProvider->pagination->itemCount,
        'pageSize' => $dataProvider->pagination->pageSize,
        'currentPage' => $dataProvider->pagination->getCurrentPage(false),
    )); ?>
</div>
<div class="clear"></div>