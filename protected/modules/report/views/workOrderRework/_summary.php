<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'code')); ?>
    </div>
    <div style="font-size: larger">Work Order Re-work</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <?php $totalPriceSum = '0.00'; ?>
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th>Rework #</th>
                <th>Tanggal</th>
                <th>WO #</th>
                <th>SPK Customer #</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Asuransi</th>
                <th>KM</th>
                <th>Keluhan</th>
                <th>Problem</th>
                <th>Parts</th>
                <th>DPP Parts</th>
                <th>Jasa</th>
                <th>DPP Jasa</th>
                <th>Total DPP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workOrderReworkSummary->dataProvider->data as $i => $header): ?>
            <?php $totalPrice = CHtml::value($header, 'grand_total'); ?>
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->rework_transaction_number), array(
                            "/frontDesk/registrationTransaction/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->rework_transaction_date))); ?>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('hh:mm:ss', strtotime($header->rework_transaction_time))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer_work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'insuranceCompany.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle_mileage')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer_request_note')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'problem')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'products')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->subtotal_product)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'services')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->subtotal_service)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                    </td>
                </tr>
                <?php $totalPriceSum += $totalPrice; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>