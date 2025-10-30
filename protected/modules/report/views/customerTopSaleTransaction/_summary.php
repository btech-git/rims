<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 27% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Laporan Penjualan Customer Terbaik <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div>Periode: <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<fieldset>
    <legend>Company</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">ID</th>
                <th class="width1-3">Name</th>
                <th class="width1-4">Quantity</th>
                <th class="width1-5">Parts</th>
                <th class="width1-6">Service</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customerCompanyTopSaleReport as $i => $dataItemCompany): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_id']); ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_name']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dataItemCompany['quantity_invoice'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['product_price'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['service_price'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['total_price'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Individual</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">ID</th>
                <th class="width1-3">Name</th>
                <th class="width1-4">Quantity</th>
                <th class="width1-5">Parts</th>
                <th class="width1-6">Service</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customerIndividualTopSaleReport as $i => $dataItemIndividual): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_id']); ?></td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_name']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dataItemIndividual['quantity_invoice'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['product_price'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['service_price'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['total_price'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>