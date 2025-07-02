<?php
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
                                        <span class="prefix">Employee</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('EmployeeId', $employeeId, CHtml::listData(Employee::model()->findAll(array('condition' => "position_id IN (1, 16) AND status = 'Active'", 'order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Pilih Employee --')); ?>
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
                        'monthlySingleMechanicTransactionReportData' => $monthlySingleMechanicTransactionReportData,
                        'monthlySingleMechanicTransactionServiceReportData' => $monthlySingleMechanicTransactionServiceReportData,
                        'year' => $year,
                        'month' => $month,
                        'employeeId' => $employeeId,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>