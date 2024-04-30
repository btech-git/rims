<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 25% }
    .width1-3 { width: 20% }
    .width1-4 { width: 25% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Penjualan per Pelanggan <?php echo CHtml::encode(CHtml::value($branch, 'name'));?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">ID</th>
            <th class="width1-2">Customer</th>
            <th class="width1-3">Type</th>
            <th class="width1-4">Total Sales</th>
        </tr>
    </thead>
    
    <tbody>
        <tr>
            <?php $totalIndividual = Customer::getTotalSaleIndividual($startDate, $endDate, $branchId); ?>
            <td colspan="3" style="text-align: center">Individual</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalIndividual)); ?></td>
        </tr>
        <?php $totalSale = 0.00; ?>
        <?php foreach ($saleRetailCustomerSummary->dataProvider->data as $header): ?>
            <?php $grandTotal = $header->getTotalSaleCompany($startDate, $endDate, $branchId); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'id')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer_type')); ?></td>
                <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
            </tr>
            <?php $totalSale += $grandTotal; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="3">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
        </tr>
    </tfoot>
</table>