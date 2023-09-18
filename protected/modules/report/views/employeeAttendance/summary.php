<?php
Yii::app()->clientScript->registerScript('report', '
	$("#YearMonth").val("' . $yearMonth . '");
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
                                    <div class="small-8 columns">
                                        <span class="prefix">Periode:</span>
                                    </div>
                                    <?php list($yearNow, $monthNow) = explode('-', $yearMonthNow); ?>
                                    <?php $currentYear = intval($yearNow); ?>
                                    <?php $currentMonth = intval($monthNow); ?>
                                    <?php $yearMonthRange = array(); ?>
                                    <?php for ($i = 0; $i < 36; $i++): ?>
                                        <?php $month = str_pad($currentMonth, 2, '0', STR_PAD_LEFT); ?>
                                        <?php $yearMonthRange[$currentYear . '-' . $month] = date('F', mktime(null, null, null, $currentMonth)) . ' ' . $currentYear; ?>
                                        <?php $currentMonth--; ?>
                                        <?php if ($currentMonth === 0): ?>
                                            <?php $currentMonth = 12; ?>
                                            <?php $currentYear--; ?>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <div class="small-4 columns">
                                        <?php echo CHtml::dropDownList('YearMonth', $yearMonth, $yearMonthRange); ?>
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

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'employeeData' => $employeeData,
                        'yearMonth' => $yearMonth,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
