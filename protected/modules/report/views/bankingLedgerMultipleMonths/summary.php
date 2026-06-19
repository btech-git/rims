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
                                        <span class="prefix">COA Bank</span>
                                    </div>
                                    <div class="small-8 columns">
                                          <?php echo CHtml::dropDownlist('CoaId', $coaId, CHtml::listData($coaList, 'id','name'), array('empty'=>'-- Pilih Bank --')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">Periode</span>
                                    </div>

                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('StartMonth', $startMonth, $monthList); ?>
                                    </div>

                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('StartYear', $startYear, $yearList); ?>
                                    </div>

                                    <div class="small-2 columns">
                                        <span class="prefix">Sampai</span>
                                    </div>

                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('EndMonth', $endMonth, $monthList); ?>
                                    </div>

                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('EndYear', $endYear, $yearList); ?>
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

                    <div class="clear"></div>
                    
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div style="font-weight: bold; text-align: center">
                    <div style="font-size: larger">
                        <?php $branch = Branch::model()->findByPk($branchId); ?>
                        Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
                    </div>
                    <div style="font-size: larger">Rincian Transaksi Bank Multi Bulan</div>
                    <div>
                        <?php $coa = Coa::model()->findByPk($coaId); ?>
                        <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?>
                    </div>
                </div>

                <br />

                <div class="relative">
                    <?php $this->renderPartial('_summaryIn', array(
                        'transactionInDataProviders' => $transactionInDataProviders,
                        'yearMonths' => $yearMonths,
                        'monthList' => $monthList,
                    )); ?>
                </div>
                
                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summaryOut', array(
                        'transactionOutDataProviders' => $transactionOutDataProviders,
                        'yearMonths' => $yearMonths,
                        'monthList' => $monthList,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>