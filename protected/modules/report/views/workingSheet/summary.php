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

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
                    <div class="row">
                        <div class="medium-6 columns">
<!--                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Tahun</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php //echo CHtml::dropDownList('Year', $year, $yearList); ?>
                                    </div>
                                </div>
                            </div>-->
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>

                                    <div class="small-4 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'StartDate',
                                            'value' => $startDate,
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
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
                                            'value' => $endDate,
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Sampai',
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Posisi Cashflow</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('CashflowPosition', $cashflowPosition, array(
                                            'Saldo Laba' => 'Saldo Laba',
                                            'Pendanaan' => 'Pendanaan',
                                            'Operasional' => 'Operasional',
                                            'Laba Bersih' => 'Laba Bersih',
                                            'Kas' => 'Kas',
                                            'Investasi' => 'Investasi',
                                        ), array('empty' => '-- All --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Category</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('CoaCategoryId', $coaCategoryId, CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Sub Category</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('CoaSubCategoryId', $coaSubCategoryId, CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
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

                <div class="relative">
                    <div class="reportDisplay">
                        <?php //$dataCount = count($coas); ?>
                        <?php //if ($dataCount > 0): ?>
                            <?php //echo "Displaying 1-{$dataCount} of {$dataCount} result(s)."; ?>
                        <?php //endif; ?>
                    </div>
                    
                    <?php $this->renderPartial('_summary', array(
                        'workingSheetReportData' => $workingSheetReportData,
//                        'year' => $year,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'coas' => $coas,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
