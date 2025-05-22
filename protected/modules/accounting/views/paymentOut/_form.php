<div class="form">
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($paymentOut->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal Payment', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $paymentOut->header,
                            'attribute' => "payment_date",
                            'options'=>array(
                                'minDate' => '-1W',
                                'maxDate' => '+6M',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
//                                'value'=>date('Y-m-d'),
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'payment_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Status', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentOut->header, 'status')); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('User', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentOut->header, 'user.username')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentOut->header, 'branch.name'));?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Supplier Company', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'company')); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Name', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Address', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'address')); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Phone', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'phone')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">	
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Payment Type', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($paymentOut->header, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Payment Type --',
                            'onchange' => '
                                if ($(this).val() == 5) {
                                    $(".bank").show();
                                    $(".giro").hide();
                                    $(".deposit").hide();
                                } else if ($(this).val() == 6) {
                                    $(".bank").show();
                                    $(".giro").show();
                                    $(".deposit").hide();
                                } else if ($(this).val() == 12) {
                                    $(".bank").hide();
                                    $(".deposit").show();
                                    $(".giro").hide();
                                } else {
                                    $(".bank").hide();
                                    $(".giro").hide();
                                    $(".deposit").hide();
                                }
                            '
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'payment_type_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="giro" <?php if ((int) $paymentOut->header->payment_type_id !== 6): ?>style="display: none"<?php endif; ?>>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Giro #', ''); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($paymentOut->header, 'nomor_giro'); ?>
                            <?php echo CHtml::error($paymentOut->header, 'nomor_giro'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bank" <?php if ((int) $paymentOut->header->payment_type_id !== 5 && (int) $paymentOut->header->payment_type_id !== 6): ?>style="display: none"<?php endif; ?>>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Bank', false); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($paymentOut->header, 'bank_id', CHtml::listData(Bank::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- Select Bank --'
                            )); ?>
                            <?php echo CHtml::error($paymentOut->header, 'bank_id'); ?>
                        </div>
                    </div>
                </div>
            
                <div class="field" >
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Company Bank', false); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php
    //                            $userBranch = UserBranch::model()->findByAttributes(array('users_id' => Yii::app()->user->getId()));
    //                            $companyBranch = CompanyBranch::model()->findByAttributes(array('branch_id' => $userBranch->branch_id));
                            $branch = Branch::model()->findByPk(Yii::app()->user->branch_id); ?>
                            <?php echo CHtml::activeDropDownList($paymentOut->header, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => $branch->company_id), array('order' => 'account_name')), 'id', 'accountNameAndNumber'), array(
                                'empty' => '-- Select Company Bank --'
                            )); ?>
                            <?php echo CHtml::error($paymentOut->header, 'company_bank_id'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="deposit" <?php if ((int) $paymentOut->header->payment_type_id !== 12): ?>style="display: none"<?php endif; ?>>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('COA Deposit', false); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($paymentOut->header, 'coa_id_deposit', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_sub_category_id' => 72)), 'id', 'name'), array(
                                'empty' => '-- Select COA Deposit --'
                            )); ?>
                            <?php echo CHtml::error($paymentOut->header, 'coa_id_deposit'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Catatan', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextArea($paymentOut->header, 'notes', array('rows' => 5, 'cols' => 30)); ?>
                        <?php echo CHtml::error($paymentOut->header, 'notes'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <hr />

    <div class="row">
        <?php //if ($paymentOut->header->isNewRecord): ?>
            <?php if ($movementType == 1): ?>
                <?php echo CHtml::button('Tambah Invoice PO', array('name' => 'Search', 'onclick' => '$("#purchase-invoice-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#purchase-invoice-dialog").dialog("open"); return false; }')); ?>
            <?php elseif ($movementType == 2): ?>
                <?php echo CHtml::button('Tambah Invoice Sub Pekerjaan', array('name' => 'Search', 'onclick' => '$("#work-order-expense-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#work-order-expense-dialog").dialog("open"); return false; }')); ?>
            <?php elseif ($movementType == 3): ?>
                <?php echo CHtml::button('Tambah Pembelian non stok', array('name' => 'Search', 'onclick' => '$("#item-request-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#item-request-dialog").dialog("open"); return false; }')); ?>
            <?php endif; ?>
        <?php //endif; ?>
        <?php echo CHtml::hiddenField('PurchaseInvoiceId'); ?>
    </div>

    <br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'paymentOut' => $paymentOut,
            'receiveItem' => $receiveItem,
            'workOrderExpense' => $workOrderExpense,
            'itemRequestHeader' => $itemRequestHeader,
            'movementType' => $movementType,
        )); ?>
    </div>
	
    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <?php echo CHtml::label('Attach Images (Upload size max 2MB)', ''); ?>
            </div>
            <div class="small-8 columns">
                <?php $this->widget('CMultiFileUpload', array(
                    'model' => $paymentOut->header,
                    'attribute' => 'images',
                    'accept' => 'jpg|jpeg|png|gif',
                    'denied' => 'Only jpg, jpeg, png and gif are allowed',
                    'max' => 10,
                    'remove' => '[x]',
                    'duplicate' => 'Already Selected',
                    'options' => array(
                        'afterFileSelect' => 'function(e ,v ,m){
                            var fileSize = e.files[0].size;
                            if (fileSize > 2*1024*1024){
                                alert("Exceeds file upload limit 2MB");
                                $(".MultiFile-remove").click();
                            }                      
                            return true;
                        }',
                    ),
                )); ?>
            </div>
        </div>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<?php //if ($paymentOut->header->isNewRecord): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'purchase-invoice-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Purchase Invoice',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-invoice-grid',
        'dataProvider' => $receiveItemDataProvider,
        'filter' => $receiveItem,
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
                'name' => 'purchase_order_no',
                'header' => 'PO #',
                'value' => '$data->purchaseOrder->purchase_order_no',
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
                'name' => 'supplier_delivery_number',
                'header' => 'Supplier SJ #',
                'value' => '$data->supplier_delivery_number',
            ),
            array(
                'header' => 'Jatuh Tempo',
                'name' => 'invoice_due_date',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_due_date)'
            ),
            array(
                'header' => 'Total',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "grandTotal"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Payment',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "purchaseOrder.payment_amount"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Remaining',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "purchaseOrder.payment_left"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $paymentOut->header->id, 'movementType' => 1)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#purchase-invoice-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'work-order-expense-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Sub Pekerjaan Invoice',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'work-order-expense-grid',
        'dataProvider' => $workOrderExpenseDataProvider,
        'filter' => $workOrderExpense,
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
                'name'=>'transaction_number', 
                'header' => 'Invoice #',
                'value'=>'CHtml::link($data->transaction_number, array("/accounting/workOrderExpense/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'transaction_date', 
                'header' => 'Tanggal',
                'value'=>'$data->transaction_date',
            ),
            array(
                'header'=>'WO #', 
                'value'=>'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->work_order_number', 
            ),
            array(
                'header' => 'Customer',
                'value' => 'CHtml::value($data, "registrationTransaction.customer.name")',
            ),
            array(
                'header' => 'Plate #',
                'value' => 'CHtml::value($data, "registrationTransaction.vehicle.plate_number")',
            ),
            array(
                'header' => 'Total',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "grand_total"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Payment',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "total_payment"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Remaining',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "payment_remaining"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $paymentOut->header->id, 'movementType' => 2)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#work-order-expense-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'item-request-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Pembelian non stok',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'item-request-grid',
        'dataProvider' => $itemRequestDataProvider,
        'filter' => $itemRequestHeader,
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
                'name'=>'transaction_number', 
                'header' => 'Pembelian #',
                'value'=>'CHtml::link($data->transaction_number, array("/frontDesk/itemRequest/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'transaction_date', 
                'header' => 'Tanggal',
                'value'=>'$data->transaction_date',
            ),
            'note',
            array(
                'header' => 'Total',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "total_price"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Payment',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "total_payment"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Remaining',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "remaining_payment"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $paymentOut->header->id, 'movementType' => 3)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#item-request-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php //endif; ?>