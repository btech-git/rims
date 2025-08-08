<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>
<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

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
                                        <span class="prefix">Periode</span>
                                    </div>

                                    <div class="small-4 columns">
                                        <?php echo CHtml::dropDownList('Month', $month, array(
                                            '01' => 'Jan',
                                            '02' => 'Feb',
                                            '03' => 'Mar',
                                            '04' => 'Apr',
                                            '05' => 'May',
                                            '06' => 'Jun',
                                            '07' => 'Jul',
                                            '08' => 'Aug',
                                            '09' => 'Sep',
                                            '10' => 'Oct',
                                            '11' => 'Nov',
                                            '12' => 'Dec',
                                        )); ?>
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
                                        <span class="prefix">Branch</span>
                                    </div>
                                    <div class="small-8 columns">
                                          <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="row">                        
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">COA List</span>
                                    </div>
                                    <div class="small-10 columns">
                                          <?php echo CHtml::checkBoxList('CoaIds', $coaIds, CHtml::listData($coaList, 'id','name'), array('template' => '<div style="display: inline-block">{input}{label}</div>', 'separator' => '')); ?>
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

                <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
                <?php $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); ?>
                <?php $startDate = $yearMonth . '-01'; ?>
                <?php $endDate = $yearMonth . '-' . $daysInMonth; ?>

                <div style="font-weight: bold; text-align: center">
                    <div style="font-size: larger">
                        <?php $branch = Branch::model()->findByPk($branchId); ?>
                        Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
                    </div>
                    <div style="font-size: larger">Laporan Bank Bulanan</div>
                    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
                </div>

                <br />

                <div class="relative">
                    <?php $this->renderPartial('_summaryIn', array(
                        'paymentInList' => $paymentInList,
                        'coaList' => $coaList,
                        'month' => $month,
                        'year' => $year,
                        'numberOfDays' => $numberOfDays,
                        'selectedCoas' => $selectedCoas,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                
                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summaryOut', array(
                        'paymentOutList' => $paymentOutList,
                        'coaList' => $coaList,
                        'month' => $month,
                        'year' => $year,
                        'numberOfDays' => $numberOfDays,
                        'selectedCoas' => $selectedCoas,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>