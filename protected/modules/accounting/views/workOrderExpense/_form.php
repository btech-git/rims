<div class="form">
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($workOrderExpense->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('Tanggal Transaksi', false); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $workOrderExpense->header,
                            'attribute' => "transaction_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
                                'value'=>date('Y-m-d'),
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo CHtml::error($workOrderExpense->header, 'transaction_date'); ?>
                    </div>
                </div>
            </div>

            <?php if ($workOrderExpense->header->isNewRecord): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo 'Work Order'; ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($workOrderExpense->header, 'registration_transaction_id', array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                                'onclick' => '$("#registration-dialog").dialog("open"); return false;',
                                'onkeypress' => 'if (event.keyCode == 13) { $("#registration-dialog").dialog("open"); return false; }',
                            )); ?>
                            <?php echo CHtml::error($workOrderExpense->header, 'registration_transaction_id'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('WO #', ''); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'work_order_number')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.work_order_number')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo 'Tanggal WO'; ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'work_order_date')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.transaction_date')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo 'Repair Type'; ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'work_order_type')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.repair_type')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo 'Customer'; ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'work_order_customer')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.customer.name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo 'Plate #'; ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'work_order_plate')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.vehicle.plate_number')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo 'Vehicle'; ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'work_order_vehicle')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.vehicle.carSubModel.name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <?php if ($workOrderExpense->header->isNewRecord): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo CHtml::label('Supplier', ''); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($workOrderExpense->header, 'supplier_id', array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                                'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                                'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }',
                            )); ?>
                            <?php echo CHtml::error($workOrderExpense->header, 'supplier_id'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('Company', false); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'supplier_company')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'supplier.company')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('Address', false); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'supplier_address')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'supplier.address')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('COA Receivables', false); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'supplier_coa')); ?>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'supplier.coa.name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('Status', ''); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'status')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('User', ''); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'user.username')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('Branch', false); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($workOrderExpense->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Branch --'
                        )); ?>
                        <?php echo CHtml::error($workOrderExpense->header, 'branch_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo CHtml::label('Catatan', ''); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextArea($workOrderExpense->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                        <?php echo CHtml::error($workOrderExpense->header, 'note'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <hr />

    <div class="row">
        <div class="medium-12 columns">
            <div id="detail_service">
                <?php $this->renderPartial('_detailService', array(
                    'workOrderExpense' => $workOrderExpense,
                )); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Pekerjaan', array('name' => 'AddDetail',
            'onclick' => CHtml::ajax(array(
                'type' => 'POST',
                'url' => CController::createUrl('ajaxHtmlAddDetail', array('id' => $workOrderExpense->header->id)),
                'update' => '#detail_div',
            )),
        )); ?>
    </div>

    <br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('workOrderExpense' => $workOrderExpense)); ?>
    </div>
	
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<?php if ($workOrderExpense->header->isNewRecord): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'registration-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Work Order',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'registration-grid',
        'dataProvider' => $registrationTransactionDataProvider,
        'filter' => $registrationTransaction,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id) {
            $("#' . CHtml::activeId($workOrderExpense->header, 'registration_transaction_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#registration-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#work_order_number").html("");
                $("#work_order_date").html("");
                $("#work_order_customer").html("");
                $("#work_order_vehicle").html("");
                $("#work_order_plate").html("");
                $("#work_order_type").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonWorkOrder', array('id' => $workOrderExpense->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#work_order_number").html(data.workOrderNumber);
                        $("#work_order_date").html(data.workOrderDate);
                        $("#work_order_customer").html(data.workOrderCustomer); 
                        $("#work_order_vehicle").html(data.workOrderVehicle); 
                        $("#work_order_plate").html(data.workOrderPlate);
                        $("#work_order_type").html(data.workOrderType);

                    },
                });
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddService', array('id' => $workOrderExpense->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) { $("#detail_service").html(html); },
                });
            }
        }',
        'columns' => array(
            array(
                'name' => 'work_order_number',
                'header' => 'WO #',
                'value' => '$data->work_order_number',
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'transaction_date',
                'filter' => false, 
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->transaction_date)',
            ),
            'repair_type',
            array(
                'header' => 'Customer',
                'filter' => CHtml::textField('CustomerName', $customerName, array('size' => '30', 'maxLength' => '60')),
                'value' => 'CHtml::value($data, "customer.name")',
            ),
            array(
                'header' => 'Plate #',
                'filter' => CHtml::textField('VehicleNumber', $vehicleNumber),
                'value' => 'CHtml::value($data, "vehicle.plate_number")',
            ),
            'note',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'supplier-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Supplier',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'supplier-grid',
        'dataProvider' => $supplierDataProvider,
        'filter' => $supplier,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id) {
            $("#' . CHtml::activeId($workOrderExpense->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#supplier-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#supplier_name").html("");
                $("#supplier_company").html("");
                $("#supplier_address").html("");
                $("#supplier_coa").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $workOrderExpense->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#supplier_name").html(data.supplier_name);
                        $("#supplier_company").html(data.supplier_company);
                        $("#supplier_address").html(data.supplier_address); 
                        $("#supplier_coa").html(data.supplier_coa);                                                             
                    },
                });
            }
        }',
        'columns' => array(
            'name',
            'company',
            'address',
            'phone',
            'coa.name: COA',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php endif; ?>
    