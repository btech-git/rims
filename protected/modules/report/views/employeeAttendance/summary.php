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
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Periode:</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <div class="medium-5 columns">
                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'StartDate',
                                                'attribute' => $startDate,
                                                'options' => array(
                                                    'dateFormat' => 'yy-mm-dd',
                                                    'changeMonth'=>true,
                                                    'changeYear'=>true,
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => true,
                                                    'placeholder' => 'Transaction Date From'
                                                ),
                                            )); ?>
                                        </div>
                                        <div class="medium-2 columns" style="text-align: center; vertical-align: middle">
                                            S/D
                                        </div>
                                        <div class="medium-5 columns">
                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'EndDate',
                                                'attribute' => $endDate,
                                                'options' => array(
                                                    'dateFormat' => 'yy-mm-dd',
                                                    'changeMonth'=>true,
                                                    'changeYear'=>true,
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => true,
                                                    'placeholder' => 'Transaction Date To'
                                                ),
                                            )); ?>
                                        </div>
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

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'employeeData' => $employeeData,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
//                        'yearMonth' => $yearMonth,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
