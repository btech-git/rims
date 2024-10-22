<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs = array(
    'Invoice Headers' => array('admin'),
    $model->id,
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Show Invoice #<?php echo CHtml::encode(CHtml::value($model, 'id')); ?></h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Manage', array("admin"), array('class' => 'btn btn-info btn-sm')); ?>
            <?php echo CHtml::link('Edit', array("update", 'id' => $model->id), array('class' => 'btn btn-warning btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<?php echo CHtml::beginForm(); ?>
    <?php $registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Invoice #</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'invoice_number')); ?></td>
                <th>Customer</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?></td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($model, 'invoice_date'))); ?></td>
                <th>Customer Type</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.customer_type')); ?></td>
            </tr>
            <tr>
                <th>Jatuh Tempo</th>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($model, 'due_date'))); ?></td>
                <th>Asuransi</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'insuranceCompany.name')); ?></td>
            </tr>
            <tr>
                <th>Registration #</th>
                <td><?php echo CHtml::encode(CHtml::value($registration, 'transaction_number')); ?></td>
                <th>No Pol</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'vehicle.plate_number')); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'status')); ?></td>
                <th>Kendaraan</th>
                <td>
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carSubModel.name')); ?>
                </td>
            </tr>
            <tr>
                <th>User Created</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'userIdCreated.username')); ?></td>
                <th>User Edited</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'userIdEdited.username')); ?></td>
            </tr>
            <tr>
                <th>Created Date</th>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:mm:s", CHtml::value($model, 'created_datetime'))); ?></td>
                <th>Edited Date</th>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:mm:s", CHtml::value($model, 'edited_datetime'))); ?></td>
            </tr>
        </tbody>
    </table>

    <?php if (!empty($model->invoiceDetails)): ?>
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Produk/Jasa</legend>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-info">
                        <th>Deskripsi</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->invoiceDetails as $i => $detail): ?>
                        <tr>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                                <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?>
                            </td>
                            <td class="text-center"><?php echo CHtml::encode(CHtml::value($detail, "quantity")); ?></td>
                            <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "unit_price"))); ?></td>
                            <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "total_price"))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-end fw-bold" colspan="3">Total Jasa</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'service_price')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="3">Total Produk</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'product_price')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="3">Sub Total</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'subtotal')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="3">Ppn</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'ppn_total')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="3">Grand Total</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'total_price')), 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <?php endif; ?>
    <?php echo CHtml::link('<i class="bi-printer"></i> Print Invoice', array("memo", 'id' => $model->id), array('class' => 'btn btn-secondary btn-sm')); ?>
<?php echo CHtml::endForm(); ?>