<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Body Repair Registration'=>array('admin'),
	'Add Product Service',
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/bodyRepairRegistration/admin';?>"><span class="fa fa-th-list"></span>Manage Body Repair Registration</a>
        <h1><?php if($bodyRepairRegistration->header->isNewRecord){ echo "New Body Repair Registration"; }else{ echo "Update Body Repair Registration";}?></h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($bodyRepairRegistration->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                            'tabs' => array(
                                'Customer Info' => array(
                                    'id' => 'info1',
                                    'content' => $this->renderPartial('_infoCustomer', array(
                                        'bodyRepairRegistration' => $bodyRepairRegistration, 
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'Vehicle Info' => array(
                                    'id' => 'info2',
                                    'content' => $this->renderPartial('_infoVehicle', array(
                                        'bodyRepairRegistration' => $bodyRepairRegistration,
                                        'vehicle' => $vehicle,
                                    ), true)
                                ),
                                'Service Exception Rate' => array(
                                    'id' => 'info3',
                                    'content' => $this->renderPartial('_serviceException', array(
                                        'bodyRepairRegistration' => $bodyRepairRegistration,
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'History' => array(
                                    'id' => 'info4',
                                    'content' => $this->renderPartial('_historyTransaction', array(
                                        'bodyRepairRegistration' => $bodyRepairRegistration,
                                        'vehicle' => $vehicle,
                                    ), true)
                                ),
                            ),
                            // additional javascript options for the tabs plugin
                            'options' => array(
                                'collapsible' => true,
                            ),
                            // set id for this widgets
                            'id' => 'view_tab',
                        )); ?>  
                    </div>
                    <!-- END ROW -->
                    <br />

                    <div class="row">
                        <div class="medium-12 columns">
                            <h2>Transaction</h2>
                            <hr />
                            <table>
                                <thead>
                                    <tr>
                                        <th>Transaction #</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Car Mileage (KM)</th>
                                        <th>Branch</th>
                                        <th>User</th>
                                        <th>PPn</th>
                                        <th>PPh</th>
                                        <?php if ($bodyRepairRegistration->header->work_order_number != ""): ?>
                                            <th>WO #</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'transaction_number')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'transaction_date')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'repair_type')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'vehicle_mileage')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'branch.name')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'user.username')); ?></td>
                                        <td>
                                            <?php echo CHtml::activeCheckBox($bodyRepairRegistration->header,'ppn', array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $bodyRepairRegistration->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_item_amount").html(data.taxItemAmount);
                                                    }',
                                                )),
                                            )); ?>
                                            <?php echo CHtml::activeDropDownList($bodyRepairRegistration->header, 'tax_percentage', array(
                                                0 => 0,
                                                10 => 10,
                                                11 => 11,
                                            ), array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $bodyRepairRegistration->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_item_amount").html(data.taxItemAmount);
                                                    }',
                                                )),
                                            )); ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::activeCheckBox($bodyRepairRegistration->header,'pph', array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $bodyRepairRegistration->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_service_amount").html(data.taxServiceAmount);
                                                        $("#total_quick_service_quantity").html(data.totalQuickServiceQuantity);
                                                        $("#sub_total_quick_service").html(data.subTotalQuickService);
                                                    }',
                                                )),
                                            )); ?>
                                        </td>
                                        <?php if($bodyRepairRegistration->header->work_order_number != ""): ?>
                                            <td><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'work_order_number')); ?></td>
                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="medium-12 columns">
                                <div class="detail">                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-2 columns">
                                                <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'problem'); ?></label>
                                            </div>
                                            <div class="small-10 columns">
                                                <?php echo CHtml::encode(CHtml::value($bodyRepairRegistration->header, 'problem')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />
                            </div>
                            
                            <div class="row">
                                <div class="medium-12 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Damage</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::button('add Damage', array(
                                                    'id' => 'damage-data-button',
                                                    'name' => 'damage-detail',
                                                    'onclick' => 'jQuery("#damage-dialog").dialog("open"); return false;'
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail">
                                        <div class="field" id="damage">
                                            <div class="row collapse">
                                                <div class="small-12 columns">
                                                    <?php $this->renderPartial('_detailDamage', array(
                                                        'bodyRepairRegistration'=>$bodyRepairRegistration,
                                                        'service'=>$service,
                                                        'serviceDataProvider'=>$serviceDataProvider,
                                                    )); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Service</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::button('add Service', array(
                                                    'id' => 'service-detail-button',
                                                    'name' => 'service-detail',
                                                    // 'class'=>'button extra left',
                                                    //'disabled'=>'false',
                                                    'onclick' => 'jQuery("#service-dialog").dialog("open"); return false;'
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail">
                                        <div class="field" id="service">
                                            <div class="row collapse">
                                                <div class="small-12 columns">
                                                    <?php $this->renderPartial('_detailService', array('bodyRepairRegistration'=>$bodyRepairRegistration)); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Product</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::button('add Product', array(
                                                    'id' => 'product-detail-button',
                                                    'name' => 'product-detail',
                                                    'onclick' => '
                                                    jQuery("#product-dialog").dialog("open"); return false;'
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail">
                                        <div class="field" id="product">
                                            <div class="row collapse">
                                                <div class="small-12 columns">
                                                    <?php $this->renderPartial('_detailProduct', array(
                                                        'bodyRepairRegistration'=>$bodyRepairRegistration,
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
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'total_service'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'total_service', array('readonly'=>true)); ?>
                                                <span id="total_quantity_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'total_service'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'total_service'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'subtotal_service'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'subtotal_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'subtotal_service'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'subtotal_service'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'discount_service'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'discount_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="total_discount_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'discount_service'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'discount_service'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'total_service_price'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'total_service_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="grand_total_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'total_service_price'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'total_service_price'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'total_product'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'total_product',array('size'=>10,'maxlength'=>10,'readonly'=>true)); ?>
                                                <span id="total_quantity_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'total_product'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'total_product'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'subtotal_product'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'subtotal_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'subtotal_product'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'subtotal_product'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'discount_product'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'discount_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,'class'=>'numbers')); ?>
                                                <span id="total_discount_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'discount_product'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'discount_product'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($bodyRepairRegistration->header,'total_product_price'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'total_product_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="grand_total_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'total_product_price'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'total_product_price'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($bodyRepairRegistration->header,'subtotal'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'subtotal',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_transaction">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'subtotal'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'subtotal'); ?>
                                            </td>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($bodyRepairRegistration->header,'ppn_price'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'ppn_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="tax_item_amount">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'ppn_price'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'ppn_price'); ?>
                                            </td>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($bodyRepairRegistration->header,'pph_price'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'pph_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="tax_service_amount">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'pph_price'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'pph_price'); ?>
                                            </td>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($bodyRepairRegistration->header,'grand_total'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'grand_total',array('size'=>18,'maxlength'=>18,'readonly'=>true)); ?>
                                                <span id="grand_total_transaction">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($bodyRepairRegistration->header,'grand_total'))); ?>
                                                </span>
                                                <?php echo $form->error($bodyRepairRegistration->header,'grand_total'); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="medium-12 columns">
                                    <div class="field buttons text-center">
                                        <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                                        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                                        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>

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
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'selectionChanged'=>'js:function(id){
                    $("#service-dialog").dialog("close");
                    var vehicle = +$("#RegistrationTransaction_vehicle_id").val();
                    var repair = +$("#RegistrationTransaction_repair_type").val();
                    if((vehicle != "") && repair !=""){
                        $.ajax({
                            type: "POST",
                            url: "' . CController::createUrl('ajaxHtmlAddServiceDetail', array('id'=> $bodyRepairRegistration->header->id)).'&serviceId="+$.fn.yiiGridView.getSelection(id)+"&customerId="+ $("#RegistrationTransaction_customer_id").val()+"&custType="+$("#Customer_customer_type").val()+"&vehicleId="+$("#RegistrationTransaction_vehicle_id").val()+"&repair="+$("#RegistrationTransaction_repair_type").val(),
                            data: $("form").serialize(),
                            success: function(html) {
                                $("#service").html(html);
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $bodyRepairRegistration->header->id)). '",
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
                    }
                    else{
                        alert("Please Check if you had already choose Repair type and Vehicle.");
                    }

                    $("#service-grid").find("tr.selected").each(function(){
                        $(this).removeClass( "selected" );
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
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager'=>array(
                'cssFile'=>false,
                'header'=>'',
            ),
            'selectionChanged'=>'js:function(id){
                $("#product-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    //dataType: "JSON",
                    url: "' . CController::createUrl('ajaxHtmlAddProductDetail', array('id'=>$bodyRepairRegistration->header->id,'productId'=>'')). '" + $.fn.yiiGridView.getSelection(id),
                    data:$("form").serialize(),
                    success: function(html) {
                        $("#product").html(html);

                    },
                });
                $("#product-grid").find("tr.selected").each(function(){
                    $(this).removeClass( "selected" );
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

<!-- Damage Dialog and Grid -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'damage-dialog',
    'options' => array(
        'title' => 'Service',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<div class="row">
    <div class="medium-6 columns">
        <input id="Damage_findkeyword" placeholder="Find By Keyword" style="margin-bottom:0px;" name="Service[findkeyword]" type="text">
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'damage-grid',
    'dataProvider'=>$damageDataProvider,
    'filter'=>$damage,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'selectionChanged'=>'js:function(id){
        $("#damage-dialog").dialog("close");
        $.ajax({
            type: "POST",
            //dataType: "JSON",
            url: "' . CController::createUrl('ajaxHtmlAddDamageDetail', array('id'=> $bodyRepairRegistration->header->id,'serviceId'=>'')).'" + $.fn.yiiGridView.getSelection(id),
            data:$("form").serialize(),
            success: function(html) {
                $("#damage").html(html);
            },
        });

        $("#damage-grid").find("tr.selected").each(function(){
            $(this).removeClass( "selected" );
        });
    }',
    'columns'=>array(
        //'id',
        'code',
        'name',
        array(
            'name' => 'service_category_id',
            'filter' => CHtml::activeDropDownList($damage, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'), array(
                'empty' => ''
            )),
            'value' => '$data->serviceCategory->name',
        ),
        array(
            'name' => 'service_type_id',
            'filter' => false,
            'value' => '$data->serviceType->name',
        ),
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    
<script>
	function ClearFields() {
		$('#pic').find('input:text').val('');
		$('#CustomerPic_address').val('');
	}
</script>
<?php  Yii::app()->clientScript->registerScript('search',"
    $('#Service_findkeyword').keypress(function(e) {
            $.fn.yiiGridView.update('service-grid', {
                data: $(this).serialize()
            });
        if(e.which == 13) {
            return false;
        }
    });
    
	$('#Damage_findkeyword').keypress(function(e) {
        if(e.which == 13) {
            $.fn.yiiGridView.update('damage-grid', {
                data: $(this).serialize()
            });
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