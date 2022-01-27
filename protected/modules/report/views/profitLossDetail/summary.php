<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="form">

    <?php echo CHtml::beginForm(array(''), 'get'); ?>

    <div class="row">
        <div class="medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Branch </span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Periode:</span>
                    </div>

                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'StartDate',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Mulai',
                            ),
                        )); ?>
                    </div>

                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'EndDate',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Sampai',
                            ),
                        )); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="clear"></div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::resetButton('Hapus');  ?>
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
    <div class="clear"></div>

</div>

<hr />

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
                <td style="padding-left: 25px; font-weight: bold; text-transform: capitalize">
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                </td>
                <td style="text-align: right; font-weight: bold"></td>
            </tr>
            <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved'), array('order' => 'code ASC')); ?> 
            <?php foreach ($coas as $account): ?>
		<?php $accountBalance = $account->getProfitLossBalance($startDate, $endDate, $branchId); ?>
		<?php if ($accountBalance > 0): ?>
                    <tr>
                        <td style="padding-left: 50px">
                            <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                            <?php echo CHtml::link($account->name, Yii::app()->createUrl("report/profitLossDetail/jurnalTransaction", array("coaId" => $account->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountBalance)); ?></td>
                    </tr>
                    <?php $accountCategoryBalance += $accountBalance; ?>
		<?php endif; ?>
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
            <?php if ($account->coa_sub_category_id == 28 || $account->coa_sub_category_id == 30 || $account->coa_sub_category_id == 31): ?>
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
