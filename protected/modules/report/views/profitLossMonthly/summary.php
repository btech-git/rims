<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartYearMonth").val("' . $startYearMonth . '");
	$("#EndYearMonth").val("' . $endYearMonth . '");
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
                                        <?php echo CHtml::dropDownList('StartYearMonth', $startYearMonth, $yearMonthRange); ?>
                                    </div>

                                    <div class="small-4 columns">
                                        <?php echo CHtml::dropDownList('EndYearMonth', $endYearMonth, $yearMonthRange); ?>
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

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'branchId' => $branchId,
                        'startYearMonth' => $startYearMonth,
                        'endYearMonth' => $endYearMonth,
                        'profitLossInfo' => $profitLossInfo,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
