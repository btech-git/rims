<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Laporan Jurnal Umum Rekap</div>
        <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    </div>

    <br />

    <table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
        <tr>
            <th style="text-align: center">Chart of Account</th>
            <th style="text-align: center">Debit</th>
            <th style="text-align: center">Credit</th>
        </tr>
        <?php $accountCategoryAssetDebitBalance = 0.00; $accountCategoryAssetCreditBalance = 0.00; ?>
        <?php foreach ($accountCategoryAssets as $accountCategoryAsset): ?>
            <?php $accountCategoryPrimarys = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryAsset->id), array('order' => 'code')); ?>
            <?php foreach ($accountCategoryPrimarys as $accountCategoryPrimary): ?>
                <?php $accountCategoryPrimaryDebitBalance = 0.00; $accountCategoryPrimaryCreditBalance = 0.00; ?>
                <?php $accountCategorySubs = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code')); ?>
                <?php foreach ($accountCategorySubs as $accountCategorySub): ?>
                    <?php $accountCategorySubDebitBalance = 0.00; $accountCategorySubCreditBalance = 0.00; ?>
                    <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code')); ?>
                    <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                        <?php $accountCategoryDebitBalance = 0.00; $accountCategoryCreditBalance = 0.00; ?>
                        <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1, 'coa_id' => null)); ?> 
                        <?php foreach ($coas as $coa): ?>
                            <?php $journalDebitBalance = $coa->getJournalDebitBalance($startDate, $endDate, $branchId); ?>
                            <?php $journalCreditBalance = $coa->getJournalCreditBalance($startDate, $endDate, $branchId); ?>
                            <?php if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance): ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?> - 
                                        <?php echo CHtml::link($coa->name, Yii::app()->createUrl("report/balanceSheetDetail/jurnalTransaction", array("coaId" => $coa->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php if (empty($coa->coaIds)): ?> 
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalDebitBalance)); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php if (empty($coa->coaIds)): ?> 
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalCreditBalance)); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <?php $groupDebitBalance = 0; $groupCreditBalance = 0; ?>
                                <?php if (!empty($coa->coaIds)): ?> 
                                    <?php foreach ($coa->coaIds as $account): ?>
                                        <?php $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId); ?>
                                        <?php $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId); ?>
                                        <?php if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance): ?>
                                            <tr>
                                                <td style="font-size: 10px">
                                                    <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                                                    <?php echo CHtml::link($account->name, Yii::app()->createUrl("report/profitLossDetail/jurnalTransaction", array("coaId" => $account->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                                                </td>
                                                <td style="text-align: right; font-size: 10px">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalDebitBalance)); ?>
                                                </td>
                                                <td style="text-align: right; font-size: 10px">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalCreditBalance)); ?>
                                                </td>
                                            </tr>
                                            <?php $groupDebitBalance += $journalDebitBalance; ?>
                                            <?php $groupCreditBalance += $journalCreditBalance; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php $accountCategoryDebitBalance += $journalDebitBalance; ?>
                            <?php $accountCategoryCreditBalance += $journalCreditBalance; ?>
                        <?php endforeach; ?>
                        <?php $accountCategorySubDebitBalance += $accountCategoryDebitBalance; ?>
                        <?php $accountCategorySubCreditBalance += $accountCategoryCreditBalance; ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                            TOTAL 
                            <?php echo CHtml::encode(CHtml::value($accountCategorySub, 'name')); ?>
                        </td>

                        <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySubDebitBalance)); ?>
                        </td>

                        <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySubCreditBalance)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>

                    <?php $accountCategoryPrimaryDebitBalance += $accountCategorySubDebitBalance; ?>
                    <?php $accountCategoryPrimaryCreditBalance += $accountCategorySubCreditBalance; ?>
                <?php endforeach; ?>

                <?php $accountCategoryAssetDebitBalance += $accountCategoryPrimaryDebitBalance; ?>
                <?php $accountCategoryAssetCreditBalance += $accountCategoryPrimaryCreditBalance; ?>
            <?php endforeach; ?>

            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>

<!--            <tr>
                <td style="text-align: right; font-weight: bold; border-top: 4px solid; text-transform: uppercase">
                    TOTAL 
                    <?php /*echo CHtml::encode(CHtml::value($accountCategoryAsset, 'name')); ?>
                </td>

                <td style="text-align: right; font-weight: bold; border-top: 4px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryAssetDebitBalance)); ?>
                </td>

                <td style="text-align: right; font-weight: bold; border-top: 4px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryAssetCreditBalance));*/ ?>
                </td>
            </tr>-->
        <?php endforeach; ?>
    </table>

    <br />

    <table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
        <?php $accountCategoryLiabilityEquityDebitBalance = 0.00; $accountCategoryLiabilityEquityCreditBalance = 0.00; ?>
        <?php foreach ($accountCategoryLiabilitiesEquities as $accountCategoryLiabilitiesEquity): ?>
            <?php $accountCategoryPrimarys = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryLiabilitiesEquity->id), array('order' => 'code')); ?>
            <?php foreach ($accountCategoryPrimarys as $accountCategoryPrimary): ?>
                <?php $accountCategoryPrimaryDebitBalance = 0.00; $accountCategoryPrimaryCreditBalance = 0.00; ?>
                <?php if ($accountCategoryPrimary->id == 5): ?>
                    <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code')); ?>
                    <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                        <?php $accountCategoryDebitBalance = 0.00; $accountCategoryCreditBalance = 0.00; ?>
                        <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                        <?php foreach ($coas as $account): ?>
                            <?php $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId); ?>
                            <?php $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId); ?>
                            <?php if ($journalDebitBalance !== 0 || $journalCreditBalance !== 0): ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                                        <?php echo CHtml::link($account->name, Yii::app()->createUrl("report/balanceSheetDetail/jurnalTransaction", array("coaId" => $account->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                                    </td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalDebitBalance)); ?></td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalCreditBalance)); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php $accountCategoryDebitBalance += $journalDebitBalance; ?>
                            <?php $accountCategoryCreditBalance += $journalCreditBalance; ?>
                        <?php endforeach; ?>
                        <?php $accountCategoryPrimaryDebitBalance += $accountCategoryDebitBalance; ?>
                        <?php $accountCategoryPrimaryCreditBalance += $accountCategoryCreditBalance; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php $accountCategorySubs = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code')); ?>
                    <?php foreach ($accountCategorySubs as $accountCategorySub): ?>
                        <?php $accountCategorySubDebitBalance = 0.00; $accountCategorySubCreditBalance = 0.00; ?>
                        <?php if ($accountCategorySub->id == 3): ?>
                            <?php $coaCategorySecondaries = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code')); ?>
                            <?php foreach ($coaCategorySecondaries as $coaCategorySecondary): ?>
                                <?php $accountCategorySecondaryDebitBalance = 0.00; $accountCategorySecondaryCreditBalance = 0.00;  ?>
                                <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $coaCategorySecondary->id), array('order' => 'code')); ?>
                                <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                                    <?php $accountCategoryDebitBalance = 0.00; $accountCategoryCreditBalance = 0.00; ?>
                                    <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                    <?php foreach ($coas as $account): ?>
                                        <?php $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId); ?>
                                        <?php $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId); ?>
                                        <?php if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance): ?>
                                            <tr>
                                                <td>
                                                    <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                                                    <?php echo CHtml::link($account->name, Yii::app()->createUrl("report/balanceSheetDetail/jurnalTransaction", array("coaId" => $account->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                                                </td>
                                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalDebitBalance)); ?></td>
                                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalCreditBalance)); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php $accountCategoryDebitBalance += $journalDebitBalance; ?>
                                        <?php $accountCategoryCreditBalance += $journalCreditBalance; ?>
                                    <?php endforeach; ?>
                                    <?php $accountCategorySecondaryDebitBalance += $accountCategoryDebitBalance; ?>
                                    <?php $accountCategorySecondaryCreditBalance += $accountCategoryCreditBalance; ?>
                                <?php endforeach; ?>

                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>

<!--                                <tr>
                                    <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                                        TOTAL 
                                        <?php /*echo CHtml::encode(CHtml::value($coaCategorySecondary, 'name')); ?>
                                    </td>

                                    <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySecondaryDebitBalance)); ?>
                                    </td>

                                    <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySecondaryCreditBalance));*/ ?>
                                    </td>
                                </tr>-->
                                <?php $accountCategorySubDebitBalance += $accountCategorySecondaryDebitBalance; ?>
                                <?php $accountCategorySubCreditBalance += $accountCategorySecondaryCreditBalance; ?>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <?php $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code')); ?>
                            <?php foreach ($coaSubCategoryCodes as $accountCategory): ?>
                                <?php $accountCategoryDebitBalance = 0.00; $accountCategoryCreditBalance = 0.00; ?>
                                <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved')); ?> 
                                <?php foreach ($coas as $account): ?>
                                    <?php $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId); ?>
                                    <?php $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId); ?>
                                    <?php $accountCategoryDebitBalance += $journalDebitBalance; ?>
                                    <?php $accountCategoryCreditBalance += $journalCreditBalance; ?>
                                <?php endforeach; ?>
                                    
<!--                                <tr>
                                    <td style="text-align: right; font-weight: bold">
                                        TOTAL 
                                        <?php /*echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
                                    </td>

                                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryDebitBalance)); ?>
                                    </td>

                                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryCreditBalance));*/ ?>
                                    </td>
                                </tr>-->
                                <?php $accountCategorySubDebitBalance += $accountCategoryDebitBalance; ?>
                                <?php $accountCategorySubCreditBalance += $accountCategoryCreditBalance; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

<!--                        <tr>
                            <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                                TOTAL 
                                <?php /*echo CHtml::encode(CHtml::value($accountCategorySub, 'name')); ?>
                            </td>

                            <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySubDebitBalance)); ?>
                            </td>

                            <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategorySubCreditBalance));*/ ?>
                            </td>
                        </tr>-->
                        <?php $accountCategoryPrimaryDebitBalance += $accountCategorySubDebitBalance; ?>
                        <?php $accountCategoryPrimaryCreditBalance += $accountCategorySubCreditBalance; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

<!--                <tr>
                    <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                        TOTAL 
                        <?php /*echo CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')); ?>
                    </td>

                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryPrimaryDebitBalance)); ?>
                    </td>

                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryPrimaryCreditBalance));*/ ?>
                    </td>
                </tr>-->
                <?php $accountCategoryLiabilityEquityDebitBalance += $accountCategoryPrimaryDebitBalance; ?>
                <?php $accountCategoryLiabilityEquityCreditBalance += $accountCategoryPrimaryCreditBalance; ?>
            <?php endforeach; ?>

<!--            <tr>
                <td style="text-align: right; font-weight: bold; border-top: 1px solid; text-transform: uppercase">
                    TOTAL 
                    <?php /*echo CHtml::encode(CHtml::value($accountCategoryLiabilitiesEquity, 'name')); ?>
                </td>

                <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryLiabilityEquityDebitBalance)); ?>
                </td>

                <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryLiabilityEquityCreditBalance));*/ ?>
                </td>
            </tr>-->
        <?php endforeach; ?>
    </table>
</div>