<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs = array(
    'Invoice Headers' => array('admin'),
    'Manage',
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Manage Invoice</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Add', array("registrationList"), array('class' => 'btn btn-success btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-primary">
                <th style="min-width: 200px">
                    Invoice #
                </th>
                <th style="min-width: 150px">
                    Tanggal
                </th>
                <th style="min-width: 250px">
                    Customer
                </th>
                <th style="min-width: 150px" >
                    Jatuh Tempo
                </th>
                <th style="min-width: 150px">
                    Registration #
                </th>
                <th style="min-width: 150px">
                    Asuransi
                </th>
                <th style="min-width: 100px">
                    Status
                </th>
                <th style="min-width: 90px"></th>
            </tr>
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
                    <td><?php echo CHtml::encode(CHtml::value($data, 'invoice_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($data, 'invoice_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($data, 'due_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'registrationTransaction.transaction_number')); ?></td>
                    <td class="text-end"><?php echo CHtml::encode(CHtml::value($data, 'insuranceCompany.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'status')); ?></td>
                    <td>
                        <?php echo CHtml::link('<i class="bi-search"></i>', array("view", "id" => $data->id), array('class' => 'btn btn-info btn-sm')); ?>
                        <?php echo CHtml::link('<i class="bi-pencil"></i>', array("update", "id" => $data->id), array('class' => 'btn btn-warning btn-sm')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>