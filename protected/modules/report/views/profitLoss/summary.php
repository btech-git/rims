<?php
Yii::app()->clientScript->registerScript('report', '
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
                        <span class="prefix">Year to Date:</span>
                    </div>

                    <div class="small-8 columns">
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
        <?php echo CHtml::submitButton('Hapus', array('onclick' => 'resetForm($("#myform"));')); ?>
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
    <div class="clear"></div>

</div>

<hr />

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
    <div style="font-size: larger">Laporan Profit/Loss</div>
    <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
    <?php foreach ($accountCategoryTypes as $accountCategoryType): ?>
        <tr>
            <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                <?php echo CHtml::encode(CHtml::value($accountCategoryType, 'code')); ?> - 
                <?php echo CHtml::encode(CHtml::value($accountCategoryType, 'name')); ?>
            </td>
            <td></td>
        </tr>
        <?php foreach ($accountCategoryType->coaSubCategories as $accountCategory): ?>
            <tr>
                <td style="padding-left: 25px; font-weight: bold; text-transform: capitalize">
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                </td>
                <td style="text-align: right; font-weight: bold">
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategory->getBalanceTotal($endDate, $branchId))); ?>
                </td>
            </tr>
            <?php foreach ($accountCategory->coas as $account): ?>
                <tr>
                    <td style="padding-left: 50px">
                        <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($account, 'name')); ?>
                    </td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $account->getBalanceTotal($endDate, $branchId))); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td style="text-align: right; font-weight: bold">
                    TOTAL
                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                </td>
                
                <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategory->getBalanceTotal($endDate, $branchId))); ?>
                </td>
            </tr>
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
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryType->getBalanceTotal($endDate, $branchId))); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td style="text-align: right; font-weight: bold; border-top: 1px solid">Profit / Loss</td>

        <td style="text-align: right; font-weight: bold; border-top: 1px solid">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryType->getProfitLossAmount($endDate, $branchId))); ?>
        </td>
    </tr>
</table>