<?php
$this->breadcrumbs = array(
    'Employee Attendance',
    'Absency',
        // 'Outstanding ',
);
?>
<div id="maincontent">
    <div class="row">
        <div class="small-12 medium-12 columns">
            <h1 class="report-title">Absency</h1>
        </div>
        
        <div class="small-12 medium-12 columns">
            <?php Yii::app()->clientScript->registerScript('report', '$("#month").val("' . $month . '");'); ?>
            <div class="tab reportTab">
                <div class="tabHead">
                    <?php //$this->renderPartial('../../../admin/views/layouts/_menu_report'); ?>
                </div>
                
                <div class="tabBody">
                    <div id="detail_div">
                        <div>
                            <div class="myForm">

                                <?php echo CHtml::beginForm(array(''), 'get'); ?>

                                <div class="row">
                                    <div class="small-12 medium-6 columns">
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Branch </span>
                                                </div>
                                                
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::dropDownlist('branch', $branch, CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Division </span>
                                                </div>
                                                
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::dropDownlist('division', $division, CHtml::listData(Division::model()->findAll(), 'id', 'name'), array('empty' => '-- All Division --')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Position </span>
                                                </div>
                                                
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::dropDownlist('position', $position, CHtml::listData(Position::model()->findAll(), 'id', 'name'), array('empty' => '-- All Position --')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Level </span>
                                                </div>
                                                
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::dropDownlist('level', $level, CHtml::listData(Level::model()->findAll(), 'id', 'name'), array('empty' => '-- All Level --')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="small-12 medium-6 columns">
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Salary Type </span>
                                                </div>
                                                
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::dropDownlist('type', $type, array('Hourly' => 'Hourly', 'Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly'), array('prompt' => 'All')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Year </span>
                                                </div>
                                                
                                                <div class="small-8 columns">
                                                    <?php $range = range(date('Y'), 2011); ?>
                                                    <?php echo CHtml::dropDownlist('year', $year, array_combine($range, $range)); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Month </span>
                                                </div>
                                                
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::dropDownlist('month', $month, array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="clear"></div>
                                <?php //echo CHtml::hiddenField('sort', '', array('id'=>'CurrentSort'));  ?>
                                <div class="row buttons">
                                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                                </div>

                                <?php echo CHtml::endForm(); ?>
                                <div class="clear"></div>

                            </div>

                            <hr />

                            <div class="relative">
                                <div class="reportDisplay">
                                    <?php //echo ReportHelper::summaryText($saleSummary->dataProvider);  ?>
                                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                                </div>
                                <?php $this->renderPartial('_attendances', array('attendances' => $attendances, 'year' => $year, 'month' => $month, 'type' => $type, 'branch' => $branch, 'division' => $division, 'position' => $position, 'level' => $level)); ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>