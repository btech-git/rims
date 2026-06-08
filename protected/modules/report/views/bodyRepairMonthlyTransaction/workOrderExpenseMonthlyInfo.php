<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
<div class="row buttons">
    <?php /*echo CHtml::hiddenField('coaId', $coaId); ?>
    <?php echo CHtml::hiddenField('debitCredit', $debitCredit); ?>
    <?php echo CHtml::hiddenField('date', $date); ?>
    <?php echo CHtml::hiddenField('branchId', $branchId); ?>
    <?php echo CHtml::hiddenField('inOut', $inOut); ?>
    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel'));*/ ?>
</div>

<?php echo CHtml::endForm(); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Transaksi Body Repair</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month)) . ' ' . $year); ?></div>
</div>

<hr />

<div class="tab reportTab">
    <div class="table_wrapper">
        <table class="responsive">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th></th>
                    <th>Sub Pekerjaan Luar #</th>
                    <th>Supplier</th>
                    <th>Customer</th>
                    <th>Plat #</th>
                    <th>Kendaraan</th>
                    <th>Note</th>
                    <th>SPK Customer #</th>
                    <th>WO #</th>
                    <th>Panel</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalSum = '0.00'; ?>
                <?php $totalPanel = 0; ?>
                <?php foreach ($workOrderExpenses as $i => $header): ?>
                    <?php $grandTotal = CHtml::value($header, 'grand_total'); ?>
                    <?php $panelQuantity = RegistrationService::model()->count(
                        'registration_transaction_id = :registration_transaction_id', 
                        array(':registration_transaction_id' => $header->registration_transaction_id)
                    ); ?>
                    <tr class="items1">
                        <td><?php echo $i + 1; ?></td>
                        <td>
                            <?php echo CHtml::link(CHtml::value($header, 'transaction_number'), Yii::app()->createUrl("accounting/workOrderExpense/show", array(
                                "id" => $header->id
                            )), array('target' => '_blank'));?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle.plate_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle.carModel.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle.carSubModel.name')); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer_work_order_number')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($panelQuantity); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                        </td>
                    </tr>
                    <?php $totalSum += $grandTotal; ?>
                    <?php $totalPanel += $panelQuantity; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: center; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPanel)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSum)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>