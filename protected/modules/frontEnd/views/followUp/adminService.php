<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    'Manage',
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Follow Up Service</h4>
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
                    Problem
                </th>
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
                    <td><?php echo CHtml::encode(CHtml::value($data, 'problem')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $dataProvider->pagination,
        )); ?>
    </div>
</div>