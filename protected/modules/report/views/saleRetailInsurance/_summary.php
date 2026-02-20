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
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name'));?></div>
    <div style="font-size: larger">Penjualan per Asuransi Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">ID</th>
            <th class="width1-2">Asuransi</th>
            <th class="width1-3">Akun</th>
            <th class="width1-4">Total Sales</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalSale = '0.00'; ?>
        <?php foreach ($insuranceSaleReport as $i => $dataItem): ?>
            <?php $grandTotal = CHtml::encode($dataItem['grand_total']); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($dataItem['insurance_company_id']); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::link($dataItem['insurance_name'], array(
                        '/report/saleRetailInsurance/transactionInfo', 
                        'insuranceId' => $dataItem['insurance_company_id'], 
                        'startDate' => $startDate, 
                        'endDate' => $endDate,
                        'branchId' => empty($branchId) ? null : $branch->id,
                    ), array('target' => '_blank')); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode($dataItem['coa_name']); ?></td>
                <td class="width1-4" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                </td>
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