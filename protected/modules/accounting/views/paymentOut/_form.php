<div class="form">
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($paymentOut->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
<!--            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php //echo CHtml::label('Payment Out #', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo CHtml::encode(CHtml::value($paymentOut->header, 'payment_number')); ?>
                        <?php //echo CHtml::error($paymentOut->header, 'payment_number'); ?>
                    </div>
                </div>
            </div>-->
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal Payment', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($paymentOut->header, 'payment_date'))); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $paymentOut->header,
                            'attribute' => "payment_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
//                                'yearRange'=>'1900:2020'
                            ),
                            'htmlOptions'=>array(
                                'value'=>date('Y-m-d'),
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
                        <?php echo CHtml::activeDropDownList($paymentOut->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Branch --'
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'branch_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Payment Type', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($paymentOut->header, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Payment Type --',
                            'onchange' => '
                                if ($(this).val() == 1) {
                                    $(".giro").hide();
                                    $(".bank").hide();
                                } else {
                                    $(".bank").show();
                                    $(".giro").show();
                                }
                            '
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'payment_type_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="giro">
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
            
            <div class="bank">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Bank', false); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($paymentOut->header, 'bank_id', CHtml::listData(Bank::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Select Bank --'
                            )); ?>
                            <?php echo CHtml::error($paymentOut->header, 'bank_id'); ?>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        
        <div class="small-12 medium-6 columns">
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
            
            <div class="field" >
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Company Bank', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php
//                            $branchId = $paymentOut->header->isNewRecord ? User::model()->findByPk(Yii::app()->user->getId())->branch_id : $paymentOut->header->branch_id;
                            $userBranch = UserBranch::model()->findByAttributes(array('users_id' => Yii::app()->user->getId()));
                            $companyBranch = CompanyBranch::model()->findByAttributes(array('branch_id' => $userBranch->branch_id));
                        ?>
                        <?php echo CHtml::activeDropDownList($paymentOut->header, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => $companyBranch->company_id), array('order' => 'account_name')), 'id', 'accountNameAndNumber'), array(
                            'empty' => '-- Select Company Bank --'
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'company_bank_id'); ?>
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

<!--    <div id="product">
        <fieldset>
            <legend>Product</legend>
            <table>
                <thead>
                    <tr>
                        <td>Manufacture Code</td>
                        <td>Name</td>
                        <td>Qty</td>
                        <td>Unit</td>
                        <td>Unit Price</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php /*if (!empty($paymentOut->header->purchase_order_id)): ?>
                        <?php foreach ($purchaseOrder->transactionPurchaseOrderDetails as $purchaseOrderDetail): ?>
                            <tr>
                                <?php $product = Product::model()->findByPK($purchaseOrderDetail->product_id); ?>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($purchaseOrderDetail, 'quantity')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrderDetail, 'unit_price'))); ?></td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrderDetail, 'total_price'))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right">SUB TOTAL</td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrder, 'subtotal'))); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right">PPN 10%</td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrder, 'ppn_price'))); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right">GRAND TOTAL</td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrder, 'total_price'))); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right">PAYMENT AMOUNT</td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrder, 'payment_amount'))); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right">REMAINING</td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrder, 'payment_left')));*/ ?></td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    </div>-->
    
    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Invoice', array('name' => 'Search', 'onclick' => '$("#purchase-invoice-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#purchase-invoice-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('PurchaseInvoiceId'); ?>
    </div>

    <br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('paymentOut' => $paymentOut)); ?>
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

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

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
            'name' => 'user_id_invoice',
            'filter' => false,
            'header' => 'Admin',
            'value' => 'empty($data->user_id_invoice) ? "N/A" : $data->userIdInvoice->username',
        ),
        array(
            'header' => 'Tanggal Input',
            'value' => '$data->dateTimeCreated',
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