
<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
    <div style="font-size: larger">Laporan Profit/Loss Induk</div>
    <div><?php echo ' Periode: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
    <?php $profitLossAmount = 0.00; ?>
    <?php foreach ($accountCategoryTypes as $accountCategoryType): ?>
	<?php $accountCategoryTypeBalance = 0.00; ?>
        <tr>
            <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                <?php echo CHtml::encode(CHtml::value($accountCategoryType, 'code')); ?> - 
                <?php echo CHtml::encode(CHtml::value($accountCategoryType, 'name')); ?>
            </td>
            <td></td>
        </tr>
	<?php $coaSubCategories = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryType->id), array('order' => 'code ASC')); ?> 
        <?php foreach ($coaSubCategories as $accountCategory): ?>
            <?php $coaBalance = (empty($coa->coaIds)) ? $coa->getProfitLossBalance($startDate, $endDate, $branchId) : 0; ?>
            <?php $accountCategoryBalance = 0.00; ?>
            <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1, 'coa_id' => null), array('order' => 'code ASC')); ?> 
            <?php foreach ($coas as $coa): ?>
                <?php $accountGroupBalance = 0.00; ?>
                <?php foreach ($coa->coaIds as $account): ?>
                    <?php $accountBalance = $account->getProfitLossBalance($startDate, $endDate, $branchId); ?>
                    <?php $accountGroupBalance += $accountBalance; ?>
                <?php endforeach; ?>
                <?php $accountCategoryBalance += (empty($coa->coaIds)) ? $coaBalance : $accountGroupBalance; ?>
            <?php endforeach; ?>
        
            <tr>
                <td style="font-weight: bold">
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                </td>
                
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryBalance)); ?>
                </td>
            </tr>
            <?php if ((int)$accountCategory->id === 28 || (int)$accountCategory->id === 30 || (int)$accountCategory->id === 31): ?>
                <?php $accountCategoryTypeBalance -= $accountCategoryBalance; ?>
            <?php else: ?>
                <?php $accountCategoryTypeBalance += $accountCategoryBalance; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                TOTAL <?php echo CHtml::encode(CHtml::value($accountCategoryType, 'name')); ?>
            </td>
            
            <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryTypeBalance)); ?>
            </td>
        </tr>
        <?php if ($accountCategoryType->id == 7 || $accountCategoryType->id == 8 || $accountCategoryType->id == 10): ?>
            <?php $profitLossAmount -= $accountCategoryTypeBalance; ?>
        <?php else: ?>
            <?php $profitLossAmount += $accountCategoryTypeBalance; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td style="text-align: right; font-weight: bold; border-top: 1px solid">Profit / Loss</td>
        <td style="text-align: right; font-weight: bold; border-top: 1px solid">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $profitLossAmount)); ?>
        </td>
    </tr>
</table>