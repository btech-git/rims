<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
    <div style="font-size: larger">Laporan Profit/Loss Standar</div>
    <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
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
            <?php $accountCategoryBalance = 0.00; ?>
            <tr>
                <td style="padding-left: 25px; font-weight: bold; text-transform: capitalize; font-size: 14px;">
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                </td>
                <td style="text-align: right; font-weight: bold"></td>
            </tr>
            
            <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1, 'coa_id' => null), array('order' => 'code ASC')); ?> 
            <?php foreach ($coas as $coa): ?>
                <?php //if ($accountGroupBalance > 0): ?>
                    <tr>
                        <td style="padding-left: 50px;">
                            <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?>
                        </td>
                        <td><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountGroupBalance)); ?></td>
                    </tr>

                    <?php $accountGroupBalance = 0.00; ?>
                    <?php if (!empty($coa->coaIds)): ?> 
                        <?php foreach ($coa->coaIds as $account): ?>
                            <?php $accountBalance = $account->getProfitLossBalance($startDate, $endDate, $branchId); ?>
                            <?php if ($accountBalance !== 0): ?>
                                <tr>
                                    <td style="padding-left: 75px; font-size: 10px">
                                        <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                                        <?php echo CHtml::link($account->name, Yii::app()->createUrl("report/profitLossDetail/jurnalTransaction", array("coaId" => $account->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                                    </td>
                                    <td style="text-align: right; font-size: 10px">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountBalance)); ?>
                                    </td>
                                </tr>
                                <?php $accountGroupBalance += $accountBalance; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right; font-size: 11px;">TOTAL <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?></td>
                            <td style="text-align: right; font-size: 11px; border-top: 1px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountGroupBalance)); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $accountCategoryBalance += $accountGroupBalance; ?>
                <?php //endif; ?>
            <?php endforeach; ?>
        
            <tr>
                <td style="text-align: right; font-weight: bold">
                    TOTAL
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                </td>
                
                <td style="text-align: right; font-weight: bold; border-top: 1px solid">
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
                TOTAL 
                <?php echo CHtml::encode(CHtml::value($accountCategoryType, 'name')); ?>
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