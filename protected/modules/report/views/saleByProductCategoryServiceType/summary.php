<?php
Yii::app()->clientScript->registerScript('report', '
    $("#Month").val("' . $month . '");
    $("#Year").val("' . $year . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Bulan</span>
                                    </div>
                                    <div class="small-4 columns">
                                        <?php echo CHtml::dropDownList('Month', $month, $monthList); ?>
                                    </div>

                                    <div class="small-4 columns">
                                        <?php echo CHtml::dropDownList('Year', $year, $yearList); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                    <div class="clear"></div>
                    
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />
                
                <div style="font-weight: bold; text-align: center">
                    <?php $branch = Branch::model()->findByPk($branchId); ?>
                    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
                    <div style="font-size: larger">Laporan Penjualan</div>
                    <div><?php echo $monthList[$month] . ' ' . $year; ?></div>
                </div>

                <br />

                <div class="relative">
                    <?php $this->renderPartial('_summaryCompany', array(
                        'branchId' => $branchId,
                        'month' => $month,
                        'year' => $year,
//                        'numberOfDays' => $numberOfDays,
                        'saleReportData' => $saleReportData,
                        'saleReportAllData' => $saleReportAllData,
                        'productMasterCategoryList' => $productMasterCategoryList,
                        'serviceCategoryList' => $serviceCategoryList,
                        'monthList' => $monthList,
                        'saleReportSummaryData' => $saleReportSummaryData,
                        'saleReportSummaryAllData' => $saleReportSummaryAllData,
                    )); ?>
                </div>
                <div class="clear"></div>
                
                <div class="relative">
                    <?php $this->renderPartial('_summaryIndividual', array(
                        'branchId' => $branchId,
                        'month' => $month,
                        'year' => $year,
//                        'numberOfDays' => $numberOfDays,
                        'saleReportData' => $saleReportData,
                        'saleReportAllData' => $saleReportAllData,
                        'productMasterCategoryList' => $productMasterCategoryList,
                        'serviceCategoryList' => $serviceCategoryList,
                        'monthList' => $monthList,
                        'saleReportSummaryData' => $saleReportSummaryData,
                        'saleReportSummaryAllData' => $saleReportSummaryAllData,
                    )); ?>
                </div>
                <div class="clear"></div>
                
                <div class="relative">
                    <?php $this->renderPartial('_summaryAll', array(
                        'branchId' => $branchId,
                        'month' => $month,
                        'year' => $year,
//                        'numberOfDays' => $numberOfDays,
                        'saleReportData' => $saleReportData,
                        'saleReportAllData' => $saleReportAllData,
                        'productMasterCategoryList' => $productMasterCategoryList,
                        'serviceCategoryList' => $serviceCategoryList,
                        'monthList' => $monthList,
                        'saleReportSummaryData' => $saleReportSummaryData,
                        'saleReportSummaryAllData' => $saleReportSummaryAllData,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>