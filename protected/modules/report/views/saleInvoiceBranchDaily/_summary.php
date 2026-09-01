<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></div>
    <div style="font-size: larger">Penjualan per Cabang Harian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))); ?> - <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th>No. </th>
                <th>Branch</th>
                <th>Front</th>
                <th>Level</th>
                <th>Customer</th>
                <th>New/Repeat</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Total Invoice</th>
                <th>Service List</th>
                <th>Service Total</th>
                <th>Parts List</th>
                <th>Parts Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $subTotalSum = '0.00'; ?>
            <?php $servicePriceSum = '0.00'; ?>
            <?php $productPriceSum = '0.00'; ?>
            
            <?php foreach ($saleInvoiceSummary->dataProvider->data as $i => $header): ?>
                <?php $subTotalAmount = CHtml::value($header, 'subTotal'); ?>
                <?php $servicePriceAmount = CHtml::value($header, 'service_price'); ?>
                <?php $productPriceAmount = CHtml::value($header, 'product_price'); ?>
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.level.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo $header->is_new_customer == 0 ? 'Repeat' : 'New'; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $subTotalAmount)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'serviceLists')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $servicePriceAmount)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'productLists')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productPriceAmount)); ?>
                    </td>
                </tr>
                
                <?php $subTotalSum += $subTotalAmount; ?>
                <?php $servicePriceSum += $servicePriceAmount; ?>
                <?php $productPriceSum += $productPriceAmount; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $subTotalAmount)); ?>
                </td>
                <td colspan="2" style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $subTotalAmount)); ?>
                </td>
                <td colspan="2" style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $subTotalAmount)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>