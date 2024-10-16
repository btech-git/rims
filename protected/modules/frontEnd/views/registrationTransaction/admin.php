<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Body Repair Transactions' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#registration-transaction-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

    <?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <a class="btn btn-success btn-sm" href="">Add</a>
        <h1>Manage BR/GR Transaction</h1>
    </div>
    <div class="clearfix"></div>
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'attribute' => $startDate,
            'options'=>array(
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions'=>array(
                'readonly' => true,
            ),
        )); ?>
    </div>
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'EndDate',
            'attribute' => $endDate,
            'options'=>array(
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions'=>array(
                'readonly' => true,
            ),
        )); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

</div>
    <?php echo CHtml::endForm(); ?>

<br />

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
                        <a class="btn btn-info btn-sm" href=""><i class="bi-search"></i></a>
                        <a class="btn btn-warning btn-sm" href=""><i class="bi-pencil"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>