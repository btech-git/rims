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
    <div style="font-size: larger">Penjualan per Mekanik Harian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))); ?> - <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th>Nama</th>
                <th>Level</th>
                <th>Customer</th>
                <th>New/Repeat</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>WO #</th>
                <th>Tanggal</th>
                <th>Type</th>
                <th>Problem</th>
                <th>KM</th>
                <th>Grand Total</th>
                <th>Service List</th>
                <th>Service Total</th>
                <th>Parts List</th>
                <th>Parts Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransactionSummary->dataProvider->data as $i => $header): ?>
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'employeeIdAssignMechanic.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'employeeIdAssignMechanic.level.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo $header->is_new_customer == 0 ? 'Repeat' : 'New'; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::value($header, 'work_order_number'), array(
                            '/frontDesk/registrationTransaction/view', 
                            'id' => $header->id, 
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($header, 'work_order_date')))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'problem')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'vehicle_mileage'))); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'services')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_service_price'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'products')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_product_price'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>