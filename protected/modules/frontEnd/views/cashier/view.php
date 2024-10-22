<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    $model->id,
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Show Payment #<?php echo CHtml::encode(CHtml::value($model, 'id')); ?></h4>
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
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Payment #</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'payment_number')); ?></td>
                <th>Customer</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?></td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($model, 'payment_date'))); ?></td>
                <th>Customer Type</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.customer_type')); ?></td>
            </tr>
            <tr>
                <th>Jenis Pembayaran</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'paymentType.name')); ?></td>
                <th>Asuransi</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'insuranceCompany.name')); ?></td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'notes')); ?></td>
                <th>Bank</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'companyBank.bank.name')); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'status')); ?></td>
                <th>Giro #</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'nomor_giro')); ?></td>
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

    <?php if (!empty($model->paymentInDetails)): ?>
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Detail</legend>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-info">
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Asuransi</th>
                        <th>Memo</th>
                        <th>Total Invoice</th>
                        <th>Pph</th>
                        <th>Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->paymentInDetails as $i => $detail): ?>
                        <tr>
                            <td><?php echo CHTml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.customer.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.insuranceCompany.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_invoice'))); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'tax_service_amount'))); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-end fw-bold" colspan="6">Downpayment</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'downpayment_amount')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="6">Diskon</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'discount_product_amount')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="6">Beban Administrasi Bank</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'bank_administration_fee')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="6">Beban Merimen</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'merimen_fee')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="6">Total Payment</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'totalPayment')), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold" colspan="6">Total Invoice</td>
                        <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($model, 'totalInvoice')), 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <?php endif; ?>
    <?php echo CHtml::link('<i class="bi-printer"></i> Print Nota Lunas', array("memo", 'id' => $model->id), array('class' => 'btn btn-secondary btn-sm')); ?>
<?php echo CHtml::endForm(); ?>