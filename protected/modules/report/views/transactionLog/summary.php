<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#StartLogDate").val("' . $startLogDate . '");
	$("#EndLogDate").val("' . $endLogDate . '");
            
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>
<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm tabForm customer">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Tanggal </span>
                                </div>
                                
                                <div class="small-4 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'StartDate',
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
                                    <span class="prefix">Log Date</span>
                                </div>
                                
                                <div class="small-4 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'StartLogDate',
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
                                        'name' => 'EndLogDate',
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
                                    <span class="prefix">Transaksi #</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextField($transactionLog, 'transaction_number'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Action Type</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($transactionLog, 'action_type', array(
                                        'create' => 'Create',
                                        'update' => 'Update',
                                        'approval' => 'Approval',
                                        'cancel' => 'Cancel',
                                    ), array('empty' => '-- All --')); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Transaksi</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($transactionLog, 'controller_class', LogModuleScanner::getTransactionList(), array('empty' => '-- All --')); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Username</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($transactionLog, 'user_id', CHtml::listData(Users::model()->findAll(array('order' => 'username ASC')), 'id', 'username'), array('empty' => '-- All --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clear"></div>
                
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay" style="text-align: right">
                    <?php echo ReportHelper::summaryText($transactionLogDataProvider); ?>
                </div>

                <?php $this->renderPartial('_summary', array(
                    'transactionLog' => $transactionLog,
                    'transactionLogDataProvider' => $transactionLogDataProvider,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>