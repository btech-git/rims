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
                    <th>Invoice #</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Plat #</th>
                    <th>Kendaraan</th>
                    <th>Panel</th>
                    <th>Type</th>
                    <th>WO #</th>
                    <th>SPK Customer #</th>
                </tr>
            </thead>
            <tbody>
                <?php $runningNumber = 1; ?>
                <?php foreach ($invoiceHeaders as $header): ?>
                    <?php $invoiceDetails = InvoiceDetail::model()->findAll(array(
                        'condition' => 'invoice_id = :invoice_id AND product_id IS NULL AND service_id IS NOT NULL', 
                        'params' => array(':invoice_id' => $header->id)
                    )); ?>
                    <?php foreach ($invoiceDetails as $detail): ?>
                        <tr class="items1">
                            <td><?php echo $runningNumber; ?></td>
                            <td>
                                <?php echo CHtml::link(CHtml::value($header, 'invoice_number'), Yii::app()->createUrl("transaction/invoiceHeader/show", array(
                                    "id" => $header->id
                                )), array('target' => '_blank'));?>
                            </td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($header, 'invoice_date')))); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                            </td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'service.serviceType.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer_work_order_number')); ?></td>
                        </tr>
                        <?php $runningNumber++; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>