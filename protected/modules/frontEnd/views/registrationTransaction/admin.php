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
        <h4>Manage BR/GR</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Add', array("saleEstimationList"), array('class' => 'btn btn-success btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-primary">
                <th style="min-width: 200px">
                    Transaction #
                </th>
                <th style="min-width: 150px">
                    Tanggal
                </th>
                <th style="min-width: 250px">
                    Customer
                </th>
                <th style="min-width: 150px" >
                    Plat #
                </th>
                <th style="min-width: 250px">
                    Mobil Tipe
                </th>
                <th style="min-width: 100px">
                    GR/BR
                </th>
                <th style="min-width: 150px">
                    Insurance
                </th>
                <th style="min-width: 150px">
                    WO #
                </th>
                <th style="min-width: 150px">
                    SO #
                </th>
                <th style="min-width: 150px">
                    Invoice
                </th>
                <th style="min-width: 150px">
                    Problem
                </th>
                <th style="min-width: 150px">
                    Sales
                </th>
                <th style="min-width: 100px">
                    Status
                </th>
                <th style="min-width: 90px"></th>
            </tr>
            <tr class="table-light">
                <th>
                    <?php echo CHtml::activeTextField($model, 'transaction_number', array(
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
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->data as $data): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'transaction_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($data, 'transaction_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'repair_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'insuranceCompany.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'sale_order_number')); ?></td>
                    <td>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array(), array(
                            'condition' => "status NOT LIKE '%CANCEL%' AND t.registration_transaction_id = :registration_transaction_id",
                            'params' => array(':registration_transaction_id' => $data->id),
                        )); ?>
                        <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'problem')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'employeeIdSalesPerson.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'status')); ?></td>
                    <td>
                        <?php echo CHtml::link('<i class="bi-search"></i>', array("view", "id" => $data->id), array('class' => 'btn btn-info btn-sm')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>