<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Rincian Penjualan per Jasa</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th>Code</th>
                <th>Type</th>
                <th>Category</th>
                <th>Name</th>
            </tr>
            <tr id="header2">
                <td colspan="4">
                    <table>
                        <tr>
                            <th>Penjualan #</th>
                            <th>Tanggal</th>
                            <th>WO #</th>
                            <th>Customer</th>
                            <th>Asuransi</th>
                            <th>Plat #</th>
                            <th>Kendaraan</th>
                            <th>Harga</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleRetailServiceSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'serviceType.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'serviceCategory.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                </tr>
                <tr class="items2">
                    <td colspan="4">
                        <table>
                            <?php $saleRetailData = $header->getSaleRetailServiceDetailReport($startDate, $endDate, $branchId, $customerType, $customerName); ?>
                            <?php $totalSale = '0.00'; ?>
                            <?php foreach ($saleRetailData as $saleRetailRow): ?>
                                <?php $total = $saleRetailRow['total_price']; ?>
                                <tr>
                                    <td><?php echo CHtml::encode($saleRetailRow['invoice_number']); ?></td>
                                    <td>
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleRetailRow['invoice_date']))); ?>
                                    </td>
                                    <td><?php echo CHtml::encode($saleRetailRow['work_order_number']); ?></td>
                                    <td><?php echo CHtml::encode($saleRetailRow['customer']); ?></td>
                                    <td><?php echo CHtml::encode($saleRetailRow['insurance']); ?></td>
                                    <td><?php echo CHtml::encode($saleRetailRow['plate_number']); ?></td>
                                    <td>
                                        <?php echo CHtml::encode($saleRetailRow['car_make']); ?> - 
                                        <?php echo CHtml::encode($saleRetailRow['car_model']); ?> - 
                                        <?php echo CHtml::encode($saleRetailRow['car_sub_model']); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total)); ?>
                                    </td>
                                </tr>
                                <?php $totalSale += $total; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="7">Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>