<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'payment-in-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>
    <?php echo CHtml::errorSummary($saleReceipt->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal TT', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $saleReceipt->header,
                            'attribute' => "transaction_date",
                            'options'=>array(
                                'minDate' => '-8W',
                                'maxDate' => '+6M',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo CHtml::error($saleReceipt->header, 'transaction_date'); ?>
                    </div>
                </div>
            </div>
           
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Note', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextArea($saleReceipt->header, 'note'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns"> 
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Customer', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $customer = Customer::model()->findByPk($saleReceipt->header->customer_id); ?>
                        <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Status', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($saleReceipt->header, 'status')); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($saleReceipt->header, 'branch.name'));?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('User', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($saleReceipt->header, 'userIdCreated.username')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Invoice', array(
            'name' => 'Search', 
            'onclick' => '$("#invoice-dialog").dialog("open"); return false;', 
            'onkeypress' => 'if (event.keyCode == 13) { $("#invoice-dialog").dialog("open"); return false; }'
        )); ?>
        <?php echo CHtml::hiddenField('SaleInvoiceId'); ?>
    </div>

    <br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'saleReceipt' => $saleReceipt,
        )); ?>
    </div>
	
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php echo IdempotentManager::generate(); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php //if ($saleReceipt->header->isNewRecord): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'invoice-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Invoice',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'invoice-grid',
        'dataProvider' => $invoiceHeaderDataProvider,
        'filter' => $invoiceHeader,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'id' => 'InvoiceIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'name' => 'invoice_number',
                'header' => 'Invoice #',
                'value' => '$data->invoice_number',
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'invoice_date',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date)'
            ),
            array(
                'name' => 'plate_number',
                'header' => 'Plat #',
                'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->plate_number',
            ),
            array(
                'name' => 'customer_id',
                'header' => 'Customer',
                'filter' => '',
                'value' => 'empty($data->customer_id) ? "" : $data->customer->name',
            ),
            array(
                'name' => 'insurance_company_name',
                'header' => 'Asuransi',
                'value' => 'empty($data->insurance_company_id) ? "" : $data->insuranceCompany->name',
            ),
            array(
                'name' => 'total_price',
                'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->total_price))',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'payment_amount',
                'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->payment_amount))',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'payment_left',
                'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->payment_left))',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $saleReceipt->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#invoice-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php //endif; ?>