<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'registration-transaction-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($registrationTransaction->header); ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

    <div class="row">
        <div class="medium-12 columns">
            <fieldset class="border border-secondary rounded mb-3 p-3">
                <legend>Customer Vehicle Data</legend>
                <?php if (!empty($customer)): ?>
                    <?php $this->renderPartial('_infoVehicle', array(
                        'registrationTransaction' => $registrationTransaction, 
                        'customer' => $customer,
                        'vehicleData' => $vehicleData,
                    )); ?>  
                <?php else: ?>
                    <?php $this->renderPartial('_formCustomerVehicle', array(
                        'registrationTransaction' => $registrationTransaction, 
                        'vehicle' => $vehicle,
                        'vehicleDataProvider' => $vehicleDataProvider,
                    )); ?>  
                <?php endif; ?>
            </fieldset>
            
            <br />

            <fieldset class="border border-secondary rounded mb-3 p-3">
                <legend>Transaction Data</legend>
                <div class="row">
                    <div class="medium-12 columns">
                        <div class="row">
                            <div class="medium-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'transaction_date'); ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'model' => $registrationTransaction->header,
                                                'attribute' => "transaction_date",
                                                'options' => array(
                                                    'minDate' => '-2W',
                                                    'maxDate' => '+6M',
                                                    'dateFormat' => 'yy-mm-dd',
                                                    'changeMonth' => true,
                                                    'changeYear' => true,
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => true,
                                                ),
                                            )); ?>
                                            <?php echo $form->error($registrationTransaction->header,'transaction_date'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'repair_type'); ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'repair_type', array(
                                                'GR' => 'GR',
                                                'BR' => 'BR',
                                            ), array("empty" => "-- Repair Type --")); ?>
                                            <?php echo $form->error($registrationTransaction->header,'repair_type'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_assign_mechanic'); ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_assign_mechanic', CHtml::listData(Employee::model()->findAllByAttributes(array(
    //                                                    "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
    //                                                    "division_id" => array(1, 3, 5),
                                                "position_id" => 1,
    //                                                    "level_id" => array(1, 2, 3, 4),
                                            )), "id", "name"), array("empty" => "--Assign Mechanic--")); ?>
                                            <?php echo $form->error($registrationTransaction->header,'employee_id_assign_mechanic'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_sales_person'); ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_sales_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
    //                                                    "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
    //                                                    "division_id" => array(2),
                                                "position_id" => 2,
    //                                                    "level_id" => array(1, 2, 3, 4),
                                            )), "id", "name"), array("empty" => "--Assign Sales--")); ?>
                                            <?php echo $form->error($registrationTransaction->header,'employee_id_sales_person'); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!empty($registrationTransaction->header->customer_id) && $customer->customer_type === 'Company'): ?>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header, 'customer_work_order_number'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($registrationTransaction->header, 'customer_work_order_number'); ?>
                                                <?php echo $form->error($registrationTransaction->header,'customer_work_order_number'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div> 
                            <!-- END COLUMN 6-->
                            <div class="medium-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'branch_id'); ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->textField($registrationTransaction->header,'branch_name',array('value'=>$registrationTransaction->header->branch->name,'readonly'=>true)); ?>
                                            <?php echo $form->error($registrationTransaction->header,'branch_id'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'user_id'); ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->hiddenField($registrationTransaction->header,'user_id'); ?>
                                            <?php echo CHtml::encode($registrationTransaction->header->user->username); ?>
                                            <?php echo $form->error($registrationTransaction->header,'user_id'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix">Car Mileage (KM)</label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->textField($registrationTransaction->header, 'vehicle_mileage'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix">Insurance Company</label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->dropDownlist($registrationTransaction->header,'insurance_company_id',CHtml::listData(InsuranceCompany::model()->findAll(array('condition' => 't.is_deleted = 0')),'id','name'),array(
                                                'prompt'=>'-- Tanpa Asuransi --',
                                            )); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->

                <div class="row">
                    <div class="medium-12 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-2 columns">
                                    <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'problem'); ?></label>
                                </div>
                                <div class="small-10 columns">
                                    <?php echo $form->textArea($registrationTransaction->header,'problem',array('rows'=>5, 'cols'=>50)); ?>
                                    <?php echo $form->error($registrationTransaction->header,'problem'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <hr />

            <div class="row">
                <div class="medium-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Jasa</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::button('Cari Jasa', array(
                                    'name' => 'SearchService', 
                                    'onclick' => '$("#service-dialog").dialog("open"); return false;', 
                                    'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }'
                                )); ?>
                                <?php echo CHtml::hiddenField('ServiceId'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="detail">
                        <div class="field" id="detail_service_div">
                            <div class="row collapse">
                                <div class="small-12 columns">
                                    <?php $this->renderPartial('_detailService', array('registrationTransaction'=>$registrationTransaction)); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Parts</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::button('Cari Parts', array(
                                    'name' => 'SearchProduct', 
                                    'onclick' => '$("#product-dialog").dialog("open"); return false;', 
                                    'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }'
                                )); ?>
                                <?php echo CHtml::hiddenField('ProductId'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="detail">
                        <div class="field" id="detail_product_div">
                            <div class="row collapse">
                                <div class="small-12 columns">
                                    <?php $this->renderPartial('_detailProduct', array(
                                        'registrationTransaction'=>$registrationTransaction,
                                        'branches' => $branches,
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="field">
                    <table>
                        <tr>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'total_service'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header,'total_service', array('readonly'=>true)); ?>
                                <span id="total_quantity_service">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($registrationTransaction->header,'total_service'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'total_service'); ?>
                            </td>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'subtotal_service'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header, 'subtotal_service'); ?>
                                <span id="sub_total_service">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal_service'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'subtotal_service'); ?>
                            </td>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'discount_service'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header,'discount_service'); ?>
                                <span id="total_discount_service">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'discount_service'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'discount_service'); ?>
                            </td>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'total_service_price'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header,'total_service_price'); ?>
                                <span id="grand_total_service">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_service_price'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'total_service_price'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'total_product'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header,'total_product'); ?>
                                <span id="total_quantity_product">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($registrationTransaction->header,'total_product'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'total_product'); ?>
                            </td>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'subtotal_product'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header,'subtotal_product'); ?>
                                <span id="sub_total_product">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal_product'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'subtotal_product'); ?>
                            </td>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'discount_product'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header,'discount_product'); ?>
                                <span id="total_discount_product">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'discount_product'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'discount_product'); ?>
                            </td>
                            <td><?php echo $form->labelEx($registrationTransaction->header,'total_product_price'); ?></td>
                            <td style="text-align: right">
                                <?php echo $form->hiddenField($registrationTransaction->header,'total_product_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                <span id="grand_total_product">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_product_price'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'total_product_price'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold"><?php echo $form->labelEx($registrationTransaction->header,'subtotal'); ?></td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo $form->hiddenField($registrationTransaction->header,'subtotal'); ?>
                                <span id="sub_total_transaction">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'subtotal'); ?>
                            </td>
                            <td style="font-weight: bold"><?php echo $form->labelEx($registrationTransaction->header,'ppn_price'); ?></td>
                            <td style="font-weight: bold">
                                <?php echo $form->dropDownList($registrationTransaction->header, 'ppn', array(
                                    '3' => 'Include PPN',
                                    '1' => 'Add PPN', 
                                    '0' => 'Non PPN',
                                ), array(
                                    'empty' => '-- Pilih PPN --',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'POST',
                                        'dataType' => 'JSON',
                                        'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)),
                                        'success' => 'function(data) {
                                            $("#grand_total_transaction").html(data.grandTotal);
                                            $("#tax_item_amount").html(data.taxItemAmount);
                                            $("#grand_total_product").html(data.grandTotalProduct);
                                            $("#sub_total_transaction").html(data.subTotalTransaction);
                                        }',
                                    )),
                                )); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($registrationTransaction->header, 'tax_percentage', array(
                                    0 => 0,
                                    10 => 10,
                                    11 => 11,
                                ), array(
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'POST',
                                        'dataType' => 'JSON',
                                        'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)),
                                        'success' => 'function(data) {
                                            $("#grand_total_transaction").html(data.grandTotal);
                                            $("#tax_item_amount").html(data.taxItemAmount);
                                            $("#grand_total_product").html(data.grandTotalProduct);
                                            $("#sub_total_transaction").html(data.subTotalTransaction);
                                        }',
                                    )),
                                )); ?>
                            </td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo $form->hiddenField($registrationTransaction->header,'ppn_price'); ?>
                                <span id="tax_item_amount">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'ppn_price'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'ppn_price'); ?>
                            </td>
                            <td style="font-weight: bold"><?php echo $form->labelEx($registrationTransaction->header,'grand_total'); ?></td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo $form->hiddenField($registrationTransaction->header,'grand_total'); ?>
                                <span id="grand_total_transaction">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'grand_total'))); ?>
                                </span>
                                <?php echo $form->error($registrationTransaction->header,'grand_total'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr />

            <div class="field buttons text-center">
                <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?> 
            </div>
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<!-- Service Dialog and Grid -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'service-dialog',
    'options' => array(
        'title' => 'Service',
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
                        <td>Kategori</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::activeTextField($service, 'code', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                    service_category_id: $("#Service_service_category_id").val(),
                                    service_type_id: $("#Service_service_type_id").val(),
                                    code: $(this).val(),
                                    name: $("#Service_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($service, 'name', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                    service_category_id: $("#Service_service_category_id").val(),
                                    service_type_id: $("#Service_service_type_id").val(),
                                    code: $("#Service_code").val(),
                                    name: $(this).val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                'onchange' => '
                                $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                    service_category_id: $(this).val(),
                                    service_type_id: $("#Service_service_type_id").val(),
                                    code: $("#Service_code").val(),
                                    name: $("#Service_name").val(),
                                } } });',
                            )); ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'service-grid',
                'dataProvider'=>$serviceDataProvider,
                'filter'=>null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'selectionChanged'=>'js:function(id){
                    $("#ServiceId").val($.fn.yiiGridView.getSelection(id));
                    $("#service-dialog").dialog("close");
                    $.ajax({
                        type: "POST",
                        url: "' . CController::createUrl('ajaxHtmlAddServiceDetail', array('id'=> $registrationTransaction->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(html) {
                            $("#detail_service_div").html(html);
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)). '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#grand_total").html(data.grandTotal);
                                    $("#total_quantity_service").html(data.totalQuantityService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#total_discount_service").html(data.totalDiscountService);
                                    $("#grand_total_service").html(data.grandTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#tax_service_amount").html(data.taxServiceAmount);
                                    $("#grand_total_transaction").html(data.grandTotal);
                                },
                            });
                        },
                    });
                }',
                'columns'=>array(
                    'code',
                    'name',
                    array(
                        'name' => 'service_category_id',
                        'value' => '$data->serviceCategory->name',
                    ),
                    array(
                        'name' => 'service_type_id',
                        'value' => '$data->serviceType->name',
                    ),
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    'options' => array(
        'title' => 'Product',
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
                    <td>ID</td>
                    <td>Code</td>
                    <td>Name</td>
                    <td>Brand</td>
                    <td>Sub Brand</td>
                    <td>Sub Brand Series</td>
                    <td>Master Kategori</td>
                    <td>Sub Master Kategori</td>
                    <td>Sub Kategori</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::activeTextField($product, 'id', array(
                            'onchange' => '
                            $.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                id: $(this).val(),
                                name: $("#Product_name").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                            'onchange' => '
                            $.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $(this).val(),
                                name: $("#Product_name").val(),
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($product, 'name', array(
                            'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                                name: $(this).val(),
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                    'update' => '#product_sub_brand',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $(this).val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                                name: $("#Product_name").val(),
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <div id="product_sub_brand">
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                    'update' => '#product_sub_brand_series',
                                )),
                            )); ?>
                        </div>
                    </td>
                    <td>
                        <div id="product_sub_brand_series">
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --')); ?>
                        </div>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                'update' => '#product_sub_master_category',
                            )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $(this).val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                                name: $("#Product_name").val(),
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <div id="product_sub_master_category">
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                    'update' => '#product_sub_category',
                                )),
                            )); ?>
                        </div>
                    </td>
                    <td>
                        <div id="product_sub_category">
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --',)); ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'product-grid',
            'dataProvider'=>$productDataProvider,
            'filter'=>null,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile'=>false,
                'header'=>'',
            ),
            'selectionChanged'=>'js:function(id){
                $("#ProductId").val($.fn.yiiGridView.getSelection(id));
                $("#product-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddProductDetail', array('id'=>$registrationTransaction->header->id)) . '",
                    data:$("form").serialize(),
                    success: function(html) {
                        $("#detail_product_div").html(html); 
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)). '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#grand_total").html(data.grandTotal);
                                $("#total_quantity_service").html(data.totalQuantityService);
                                $("#sub_total_service").html(data.subTotalService);
                                $("#total_discount_service").html(data.totalDiscountService);
                                $("#grand_total_service").html(data.grandTotalService);
                                $("#sub_total_transaction").html(data.subTotalTransaction);
                                $("#tax_item_amount").html(data.taxItemAmount);
                                $("#tax_service_amount").html(data.taxServiceAmount);
                                $("#grand_total_transaction").html(data.grandTotal);
                            },
                        });
                    },
                });
            }',
            'columns'=>array(
                'id',
                'manufacturer_code',
                'name',
                array(
                    'name'=>'product_brand_name', 
                    'value'=>'empty($data->brand_id) ? "" : $data->brand->name'
                ),
                array(
                    'header' => 'Sub Brand', 
                    'name' => 'product_sub_brand_name', 
                    'value' => 'empty($data->sub_brand_id) ? "" : $data->subBrand->name'
                ),
                array(
                    'header' => 'Sub Brand Series', 
                    'name' => 'product_sub_brand_series_name', 
                    'value' => 'empty($data->sub_brand_series_id) ? "" : $data->subBrandSeries->name'
                ),
                'masterSubCategoryCode: Kategori',
                array(
                    'name'=>'unit_id', 
                    'value'=>'empty($data->unit_id) ? "" : $data->unit->name'
                ),
                array(
                    'name'=>'retail_price',
                    'header' => 'Price',
                    'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->retail_price)',
                ),
                'vehicleCarMake.name: Car',
            ),
        )); ?>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php  Yii::app()->clientScript->registerScript('search',"
    $('#Service_findkeyword').keypress(function(e) {
            $.fn.yiiGridView.update('service-grid', {
                data: $(this).serialize()
            });
        if(e.which == 13) {
            return false;
        }
    });
"); ?>

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>