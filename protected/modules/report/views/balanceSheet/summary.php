<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
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
                                    <?php //echo CHtml::textField('StartDate', $startDate, array('readOnly' => true)); ?>
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
                                            'onSelect' => 'js:function(text) {
                                                var parts = text.split("-");
                                                var startDate = parts[0] + "-01-01";
                                                $("#StartDate").val(startDate);
                                            }',
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

            <div class="relative">
                <div style="font-weight: bold; text-align: center">
                    <?php $branch = Branch::model()->findByPk($branchId); ?>
                    <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
                    <div style="font-size: larger">Laporan Balance Sheet Induk</div>
                    <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
                </div>

                <br />

                <table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
                    <?php $accountCategoryAssetBalance = 0.00; ?>
                    <?php foreach ($accountCategoryAssets as $accountCategoryAsset): ?>
                        <tr>
                            <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                <?php echo CHtml::encode(CHtml::value($accountCategoryAsset, 'name')); ?>
                            </td>
                            <td></td>
                        </tr>
                        
                        <?php $accountCategoryPrimarys = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryAsset->id), array('order' => 'code')); ?>
                        <?php foreach ($accountCategoryPrimarys as $accountCategoryPrimary): ?>
                            <?php $accountCategoryPrimaryBalance = 0.00; ?>
                            <tr>
                                <td style="padding-left: 25px; font-size: large; font-weight: bold; text-transform: uppercase">
                                    <?php echo CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')); ?>
                                </td>
                                <td></td>
                            </tr>
                        
                            <?php $accountCategorySubs = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code')); ?>
                            <?php foreach ($accountCategorySubs as $accountCategorySub): ?>
                                <?php $accountCategorySubBalance = 0.00; ?>
                                <tr>
                                    <td style="padding-left: 50px; font-size: large; font-weight: bold; text-transform: uppercase">
                                        <?php echo CHtml::encode(CHtml::value($accountCategorySub, 'name')); ?>
                                    </td>
                                    <td></td>
                                </tr>

                                <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code')); ?>
                                <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                                    <?php $accountCategoryBalance = 0.00; ?>
                                    <tr>
                                        <td style="padding-left: 75px; font-weight: bold; text-transform: capitalize">
                                            <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                                            <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                                        </td>

                                        <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                        <?php foreach ($coas as $account): ?>
                                            <?php $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId); ?>
                                            <?php $accountCategoryBalance += $accountBalance; ?>
                                        <?php endforeach; ?>

                                        <td style="text-align: right; font-weight: bold">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryBalance)); ?>
                                        </td>
                                    </tr>
                                    <?php $accountCategorySubBalance += $accountCategoryBalance; ?>
                                <?php endforeach; ?>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                        TOTAL 
                                        <?php echo CHtml::encode(CHtml::value($accountCategorySub, 'name')); ?>
                                    </td>

                                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySubBalance)); ?>
                                    </td>
                                </tr>
                                <?php $accountCategoryPrimaryBalance += $accountCategorySubBalance; ?>
                            <?php endforeach; ?>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                    TOTAL 
                                    <?php echo CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')); ?>
                                </td>

                                <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryPrimaryBalance)); ?>
                                </td>
                            </tr>
                            <?php $accountCategoryAssetBalance += $accountCategoryPrimaryBalance; ?>
                        <?php endforeach; ?>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                TOTAL 
                                <?php echo CHtml::encode(CHtml::value($accountCategoryAsset, 'name')); ?>
                            </td>

                            <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryAssetBalance)); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <br />

                <table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
                    <?php $accountCategoryLiabilityEquityBalance = 0.00; ?>
                    <?php foreach ($accountCategoryLiabilitiesEquities as $accountCategoryLiabilitiesEquity): ?>
                        <tr>
                            <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                <?php echo CHtml::encode(CHtml::value($accountCategoryLiabilitiesEquity, 'name')); ?>
                            </td>
                            <td></td>
                        </tr>
                        
                        <?php $accountCategoryPrimarys = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryLiabilitiesEquity->id), array('order' => 'code')); ?>
                        <?php foreach ($accountCategoryPrimarys as $accountCategoryPrimary): ?>
                            <?php $accountCategoryPrimaryBalance = 0.00; ?>
                            <tr>
                                <td style="padding-left: 25px; font-size: large; font-weight: bold; text-transform: uppercase">
                                    <?php echo CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')); ?>
                                </td>
                                <td></td>
                            </tr>
                        
                            <?php if ($accountCategoryPrimary->id == 5): ?>
                                <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code')); ?>
                                <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                                    <?php $accountCategoryBalance = 0.00; ?>
                                    <tr>
                                        <td style="padding-left: 75px; font-weight: bold; text-transform: capitalize">
                                            <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                                            <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                                        </td>

                                        <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                        <?php foreach ($coas as $account): ?>
                                            <?php $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId); ?>
                                            <?php $accountCategoryBalance += $accountBalance; ?>
                                        <?php endforeach; ?>

                                        <td style="text-align: right; font-weight: bold">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryBalance)); ?>
                                        </td>
                                    </tr>
                                    <?php $accountCategoryPrimaryBalance += $accountCategoryBalance; ?>
                                <?php endforeach; ?>
<!--                                <tr>
                                    <td style="padding-left: 75px; font-weight: bold; text-transform: capitalize">
                                        <?php /*echo CHtml::encode(CHtml::value($accountProfitLossPrevious, 'code')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($accountProfitLossPrevious, 'name')); ?>
                                    </td>

                                    <td style="text-align: right; font-weight: bold">
                                        <?php $profitLossPreviousAmount = 0.00; ?>
                                        <?php foreach ($accountCategoryTypes as $accountCategoryType): ?>
                                            <?php $accountCategoryTypeBalance = 0.00; ?>
                                            <?php $coaSubCategories = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryType->id), array('order' => 'code')); ?> 
                                            <?php foreach ($coaSubCategories as $accountCategory): ?>
                                                <?php $accountCategoryBalance = 0.00; ?>
                                                <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                                <?php foreach ($coas as $account): ?>
                                                    <?php $accountBalance = $account->getProfitLossPreviousBalance($startDate, $endDate, $branchId); ?>
                                                    <?php $accountCategoryBalance += $accountBalance; ?>
                                                <?php endforeach; ?>
                                                <?php $accountCategoryTypeBalance += $accountCategoryBalance; ?>
                                            <?php endforeach; ?>
                                            <?php if ($accountCategoryType->id == 7 || $accountCategoryType->id == 8 || $accountCategoryType->id == 10): ?>
                                                <?php $profitLossPreviousAmount -= $accountCategoryTypeBalance; ?>
                                            <?php else: ?>
                                                <?php $profitLossPreviousAmount += $accountCategoryTypeBalance; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $profitLossPreviousAmount)); ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding-left: 75px; font-weight: bold; text-transform: capitalize">
                                        <?php echo CHtml::encode(CHtml::value($accountProfitLoss, 'code')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($accountProfitLoss, 'name')); ?>
                                    </td>

                                    <td style="text-align: right; font-weight: bold">
                                        <?php $profitLossAmount = 0.00; ?>
                                        <?php foreach ($accountCategoryTypes as $accountCategoryType): ?>
                                            <?php $accountCategoryTypeBalance = 0.00; ?>
                                            <?php $coaSubCategories = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryType->id), array('order' => 'code')); ?> 
                                            <?php foreach ($coaSubCategories as $accountCategory): ?>
                                                <?php $accountCategoryBalance = 0.00; ?>
                                                <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                                <?php foreach ($coas as $account): ?>
                                                    <?php $accountBalance = $account->getProfitLossBalance($startDate, $endDate, $branchId); ?>
                                                    <?php $accountCategoryBalance += $accountBalance; ?>
                                                <?php endforeach; ?>
                                                <?php $accountCategoryTypeBalance += $accountCategoryBalance; ?>
                                            <?php endforeach; ?>
                                            <?php if ($accountCategoryType->id == 7 || $accountCategoryType->id == 8 || $accountCategoryType->id == 10): ?>
                                                <?php $profitLossAmount -= $accountCategoryTypeBalance; ?>
                                            <?php else: ?>
                                                <?php $profitLossAmount += $accountCategoryTypeBalance; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $profitLossAmount));*/ ?>
                                   </td>
                                </tr>-->
                            <?php else : ?>
                                <?php $accountCategorySubs = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code')); ?>
                                <?php foreach ($accountCategorySubs as $accountCategorySub): ?>
                                    <?php $accountCategorySubBalance = 0.00; ?>
                                    <tr>
                                        <td style="padding-left: 50px; font-size: large; font-weight: bold; text-transform: uppercase">
                                            <?php echo CHtml::encode(CHtml::value($accountCategorySub, 'name')); ?>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <?php if ($accountCategorySub->id == 3): ?>
                                        <?php $coaCategorySecondaries = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code')); ?>
                                        <?php foreach ($coaCategorySecondaries as $coaCategorySecondary): ?>
                                            <?php $accountCategorySecondaryBalance = 0.00; ?>
                                            <tr>
                                                <td style="padding-left: 75px; font-weight: bold; text-transform: capitalize">
                                                    <?php echo CHtml::encode(CHtml::value($coaCategorySecondary, 'name')); ?>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $coaCategorySecondary->id), array('order' => 'code')); ?>
                                            <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                                                <?php $accountCategoryBalance = 0.00; ?>
                                                <tr>
                                                    <td style="padding-left: 95px; font-weight: bold; text-transform: capitalize">
                                                        <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                                                        <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                                                    </td>

                                                    <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                                    <?php foreach ($coas as $account): ?>
                                                        <?php $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId); ?>
                                                        <?php $accountCategoryBalance += $accountBalance; ?>
                                                    <?php endforeach; ?>

                                                    <td style="text-align: right; font-weight: bold">
                                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryBalance)); ?>
                                                    </td>
                                                </tr>
                                                <?php $accountCategorySecondaryBalance += $accountCategoryBalance; ?>
                                            <?php endforeach; ?>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                                    TOTAL 
                                                    <?php echo CHtml::encode(CHtml::value($coaCategorySecondary, 'name')); ?>
                                                </td>

                                                <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySecondaryBalance)); ?>
                                                </td>
                                            </tr>
                                            <?php $accountCategorySubBalance += $accountCategorySecondaryBalance; ?>

                                        <?php endforeach; ?>
                                                    
                                    <?php else: ?>
                                            
                                        <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code')); ?>
                                        <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                                            <?php $accountCategoryBalance = 0.00; ?>
                                            <tr>
                                                <td style="padding-left: 95px; font-weight: bold; text-transform: capitalize">
                                                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'code')); ?> - 
                                                    <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                                                </td>

                                                <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                                <?php foreach ($coas as $account): ?>
                                                    <?php $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId); ?>
                                                    <?php $accountCategoryBalance += $accountBalance; ?>
                                                <?php endforeach; ?>

                                                <td style="text-align: right; font-weight: bold">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryBalance)); ?>
                                                </td>
                                            </tr>
                                            <?php $accountCategorySubBalance += $accountCategoryBalance; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                            TOTAL 
                                            <?php echo CHtml::encode(CHtml::value($accountCategorySub, 'name')); ?>
                                        </td>

                                        <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySubBalance)); ?>
                                        </td>
                                    </tr>
                                    <?php $accountCategoryPrimaryBalance += $accountCategorySubBalance; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                    TOTAL 
                                    <?php echo CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')); ?>
                                </td>

                                <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryPrimaryBalance)); ?>
                                </td>
                            </tr>
                            <?php $accountCategoryLiabilityEquityBalance += $accountCategoryPrimaryBalance; ?>
                        <?php endforeach; ?>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                TOTAL 
                                <?php echo CHtml::encode(CHtml::value($accountCategoryLiabilitiesEquity, 'name')); ?>
                            </td>

                            <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryLiabilityEquityBalance)); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
</div>