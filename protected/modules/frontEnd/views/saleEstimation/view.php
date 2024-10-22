<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    $model->id,
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Show Estimasi #<?php echo CHtml::encode(CHtml::value($model, 'id')); ?></h4>
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
                <th>Estimasi #</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'transaction_number')); ?></td>
                <th>Plat #</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'vehicle.plate_number')); ?></td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($model, 'transaction_date'))); ?></td>
                <th>Mobil Tipe</th>
                <td>
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carSubModel.name')); ?>
                </td>
            </tr>
            <tr>
                <th>Customer</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?></td>
                <th>Mileage (km)</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'vehicle_mileage')); ?></td>
            </tr>
            <tr>
                <th>Customer Type</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.customer_type')); ?></td>
                <th>Problem</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'problem')); ?></td>
            </tr>
            <tr>
                <th>Sales Person</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'employeeIdSalesPerson.name')); ?></td>
                <th>Status</th>
                <td><?php echo CHtml::encode(CHtml::value($model, 'status')); ?></td>
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

    <?php if (!empty($model->saleEstimationProductDetails)): ?>
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Produk</legend>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-info">
                        <th>Deskripsi</th>
                        <th>Quantity</th>
                        <th>Satuan</th>
                        <th>Harga Retail</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->saleEstimationProductDetails as $i => $productDetail): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($productDetail, "product.name")); ?></td>
                            <td class="text-center"><?php echo CHtml::encode(CHtml::value($productDetail, "quantity")); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($productDetail, "product.unit.name")); ?></td>
                            <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, "retail_price"))); ?></td>
                            <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, "sale_price"))); ?></td>
                            <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, "total_price"))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-end">Total Qty</td>
                        <td class="text-center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, "total_quantity_product"))); ?></td>
                        <td class="text-end" colspan="3">Sub Total Produk</td>
                        <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, "sub_total_product"))); ?></td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <?php endif; ?>

    <?php if (!empty($model->saleEstimationServiceDetails)): ?>
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Jasa</legend>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-info">
                        <th>Deskripsi</th>
                        <th>Harga Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->saleEstimationServiceDetails as $i => $serviceDetail): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($serviceDetail, "service.name")); ?></td>
                            <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($serviceDetail, "price"))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-end">Sub Total Jasa</td>
                        <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, "sub_total_service"))); ?></td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <?php endif; ?>

    <fieldset class="border border-secondary rounded mb-3 p-3">
        <legend class="float-none w-auto text-dark px-1">Total</legend>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-info">
                    <th class="text-end">Sub Total</th>
                    <th class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, "subTotalProductService"))); ?></th>
                </tr>
                <tr class="table-info">
                    <th class="text-end">PPn</th>
                    <th class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, "tax_product_amount"))); ?></th>
                </tr>
                <tr class="table-info">
                    <th class="text-end">PPh</th>
                    <th class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, "tax_service_amount"))); ?></th>
                </tr>
                <tr class="table-info">
                    <th class="text-end">Grand Total</th>
                    <th class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, "grand_total"))); ?></th>
                </tr>
            </thead>
        </table>
    </fieldset>

    <?php echo CHtml::link('<i class="bi-printer"></i> Print Estimasi', array("memo", 'id' => $model->id), array('class' => 'btn btn-secondary btn-sm')); ?>
    
<?php echo CHtml::endForm(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>