<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 3% }
    .width1-3 { width: 5% }
    .width1-4 { width: 15% }
    .width1-5 { width: 5% }
    .width1-6 { width: 5% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 5% }
    .width1-11 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Laporan Penjualan Customer Tahunan <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
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
                <th class="width1-3">Type</th>
                <th class="width1-4">Name</th>
                <th class="width1-5">Phone</th>
                <th class="width1-6"># of Invoice</th>
                <th class="width1-7">Total Invoice (Rp)</th>
                <th class="width1-8">Total Parts (Rp)</th>
                <th class="width1-9">Total Service (Rp)</th>
                <th class="width1-10">Date 1st Invoice</th>
                <th class="width1-11">Duration from 1st Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yearlyMultipleCustomerCompanySaleReport as $i => $dataItemCompany): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_id']); ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_type']); ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_name']); ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_phone']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dataItemCompany['invoice_quantity'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['grand_total'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['total_product'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['total_service'])); ?>
                    </td>
                    <td></td>
                    <td></td>
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
                <th class="width1-3">Type</th>
                <th class="width1-4">Name</th>
                <th class="width1-5">Phone</th>
                <th class="width1-6"># of Invoice</th>
                <th class="width1-7">Total Invoice (Rp)</th>
                <th class="width1-8">Total Parts (Rp)</th>
                <th class="width1-9">Total Service (Rp)</th>
                <th class="width1-10">Date 1st Invoice</th>
                <th class="width1-11">Duration from 1st Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yearlyMultipleCustomerIndividualSaleReport as $i => $dataItemIndividual): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_id']); ?></td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_type']); ?></td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_name']); ?></td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_phone']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dataItemIndividual['invoice_quantity'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['grand_total'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['total_product'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['total_service'])); ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>