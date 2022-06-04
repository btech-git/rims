<div class="form">
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($workOrderExpense->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal Payment', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($workOrderExpense->header, 'payment_date'))); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $workOrderExpense->header,
                            'attribute' => "transaction_date",
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
                        <?php echo CHtml::error($workOrderExpense->header, 'transaction_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('WO #', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.work_order_number')); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Customer', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.customer.name')); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Plate #', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'registrationTransaction.vehicle.plate_number')); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Status', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'status')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('User', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($workOrderExpense->header, 'user.username')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($workOrderExpense->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Branch --'
                        )); ?>
                        <?php echo CHtml::error($workOrderExpense->header, 'branch_id'); ?>
                    </div>
                </div>
            </div>		
        </div>
        
        <div class="small-12 medium-6 columns">
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

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Company', false); ?>
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
                        <?php echo CHtml::label('Address', false); ?>
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
                        <?php echo CHtml::label('COA Receivables', false); ?>
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
                        <?php echo CHtml::label('Catatan', ''); ?>
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
        <?php echo CHtml::button('Tambah Biaya', array('name' => 'Search', 'onclick' => '$("#coa-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#coa-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('CoaId'); ?>
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

<!--COA Detail-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <table>
                <thead>
                    <tr>
                        <td>Code</td>
                        <td>Name</td>
                        <!--<td>Category</td>-->
                        <td>Sub Category</td>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::activeTextField($coa, 'code', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    code: $(this).val(),
                                    name: $("#coa_name").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <?php echo CHtml::activeTextField($coa, 'name', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    name: $(this).val(),
                                    code: $("#coa_code").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
<!--                        <td>
                            <?php /*echo CHtml::activeDropDownList($coa, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateSubCategorySelect'),
                                    'update' => '#sub_category',
                                )) . '$.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    coa_category_id: $(this).val(),
                                    id: $("#coa_id").val(),
                                    code: $("#coa_code").val(),
                                    name: $("#coa_name").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            ));*/ ?>
                        </td>-->
                        
                        <td>
                            <div id="sub_category">
                                <?php echo CHtml::activeDropDownList($coa, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => 8), array('order' => 't.name')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                    $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                        coa_sub_category_id: $(this).val(),
                                        code: $("#coa_code").val(),
                                        coa_category_id: $("#coa_category_id").val(),
                                        name: $("#coa_name").val(),
                                    } } });',
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'coa-detail-grid',
                'dataProvider' => $coaDataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id) {
                    $("#CoaId").val($.fn.yiiGridView.getSelection(id));
                    $("#coa-dialog").dialog("close");
                    $.ajax({
                        type: "POST",
                        url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $workOrderExpense->header->id,)) . '",
                        data: $("form").serialize(),
                        success: function(html) { $("#detail_div").html(html); },
                    });
                }',
                'columns' => array(
                    array(
                        'name' => 'name', 
                        'value' => '$data->name', 
                        'type' => 'raw'
                    ),
                    'code',
                    array(
                        'name' => 'coa_category_id',
                        'filter' => CHtml::activeDropDownList($coa, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->coaCategory!="" ?$data->coaCategory->name:""',
                    ),
                    array(
                        'name' => 'coa_sub_category_id',
                        'filter' => CHtml::activeDropDownList($coa, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->coaSubCategory!="" ?$data->coaSubCategory->name:""'
                    ),
                    'normal_balance',
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
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
    