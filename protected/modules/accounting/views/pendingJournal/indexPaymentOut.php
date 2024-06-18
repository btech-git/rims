<?php
Yii::app()->clientScript->registerScript('report', '

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>
<div style="text-align: center; text-decoration: underline">
    <h2><?php echo 'Pending Journal Payment Out'; ?></h2>
    <br />
</div>

<div style="text-align: right">
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        <div class="medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-6 columns">
                        <span class="prefix">Payment Out # </span>
                    </div>
                    <div class="small-6 columns">
                        <?php echo CHtml::activeTextField($model, 'payment_number'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-6 columns">
                        <span class="prefix">Branch </span>
                    </div>
                    
                    <div class="small-6 columns">
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="medium-12 columns">
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
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Sampai',
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::resetButton('Hapus');  ?>
    </div>

    <?php echo CHtml::endForm(); ?>
    
    <div class="clear"></div>
    
    <br />
    
    <?php echo ReportHelper::summaryText($paymentOutDataProvider); ?>
</div>

<div>
    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'cash-transaction-grid',
        'dataProvider' => $paymentOutDataProvider,
        'filter' => null,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array( 
                'name' => 'payment_number', 
                'value' => 'CHtml::link($data->payment_number, array("/accounting/paymentOut/view", "id"=>$data->id), array("target" => "blank"))', 
                'type' => 'raw'
            ),
            'payment_date',
            array(
                'header' => 'Supplier',
                'name' => 'supplier_id', 
                'value' => 'empty($data->supplier_id) ? "" : $data->supplier->name'
            ),
            array(
                'header' => 'Branch',
                'name' => 'branch_id', 
                'value' => '$data->branch->name'
            ),
            'status', 
        )
    )); ?>
    
    <?php echo CHtml::ajaxSubmitButton('Posting All', CController::createUrl('ajaxHtmlPostingJournalPaymentOut'), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
    )); ?>

    <?php echo CHtml::endForm(); ?>

</div>