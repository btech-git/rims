<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */

$this->breadcrumbs = array(
'Registration Transactions' => array('admin'),
'Manage',
);
?>
<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Manage Payment</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Add', array("invoiceList"), array('class' => 'btn btn-success btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-primary">
                <th style="min-width: 200px">Payment #</th>
                <th style="min-width: 150px">Tanggal</th>
                <th style="min-width: 150px">Customer</th>
                <th style="min-width: 150px">Asuransi</th>
                <th style="min-width: 150px">Total</th>
                <th style="min-width: 150px">Created By</th>
                <th style="min-width: 150px">Approval Status</th>
                <th style="min-width: 150px">Tanggal Input</th>
                <th style="min-width: 150px"></th>
            <tr class="table-light">
                <th>
                    <?php echo CHtml::activeTextField($model, 'invoice_number', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationTable'),
                            'update' => '#sale_estimation_data_container',
                        )),
                    )); ?>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->data as $data): ?>
                <tr id="sale_estimation_data_container">
                    <td><?php echo CHtml::encode(CHtml::value($data, 'payment_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($data, 'payment_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'insuranceCompany.name')); ?></td>
                    <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($data, 'payment_amount'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'user.username')); ?></td>
                    <td><?php //echo CHtml::encode(CHtml::value($data, 'approvalStatus')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($data, 'created_datetime'))); ?></td>
                    <td>
                        <?php echo CHtml::link('<i class="bi-search"></i>', array("view", "id" => $data->id), array('class' => 'btn btn-info btn-sm')); ?>
                        <?php echo CHtml::link('<i class="bi-pencil"></i>', array("update", "id" => $data->id), array('class' => 'btn btn-warning btn-sm')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
