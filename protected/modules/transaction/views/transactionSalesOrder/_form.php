<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $salesOrder->header TransactionPurchaseOrder */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Sales Order', Yii::app()->baseUrl . '/transaction/transactionSalesOrder/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.transactionSalesOrder.admin"))) ?>
    <h1>
        <?php
        if ($salesOrder->header->id == "") {
            echo "New Transaction Sales Order";
        } else {
            echo "Update Transaction Sales Order";
        }
        ?>
    </h1>
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-purchase-order-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($salesOrder->header); ?>
        <?php echo $form->errorSummary($salesOrder->details); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'sale_order_date'); ?></label>
                        </div>

                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $salesOrder->header,
                                'attribute' => "sale_order_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
//                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => $salesOrder->header->isNewRecord ? date('Y-m-d') : $salesOrder->header->sale_order_date,
                                //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                ),
                            )); ?>
                            <?php echo $form->error($salesOrder->header, 'sale_order_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'status_document'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($salesOrder->header, 'status_document', array('value' => $salesOrder->header->isNewRecord ? 'Draft' : $salesOrder->header->status_document, 'readonly' => true)); ?>
                            <?php echo $form->error($salesOrder->header, 'status_document'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'customer_id'); ?></label>
                        </div>
                        <div class="small-2 columns">
                            <a class="button expand" href="<?php echo Yii::app()->baseUrl . '/master/customer/create'; ?>"><span class="fa fa-plus"></span>Add</a>
                        </div>
                        <div class="small-6 columns">

                            <?php echo CHtml::activeHiddenField($salesOrder->header, 'customer_id'); ?>
                            <?php echo CHtml::activeTextField($salesOrder->header, 'customer_name', array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                                //'disabled'=>true,
                                'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                                'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }',
                                'value' => $salesOrder->header->customer_id == "" ? '' : Customer::model()->findByPk($salesOrder->header->customer_id)->name
                            )); ?>

                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => 'customer-dialog',
                                // additional javascript options for the dialog plugin
                                'options' => array(
                                    'title' => 'Customer',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                ),
                            )); ?>

                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'customer-grid',
                                'dataProvider' => $customerDataProvider,
                                'filter' => $customer,
                                'selectionChanged' => '
                                    js:function(id){
                                        $("#TransactionSalesOrder_customer_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#customer-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#TransactionSalesOrder_customer_name").val(data.name);		                        	
                                                $("#TransactionSalesOrder_cust_type").val(data.type);		                        	
                                                $("#TransactionSalesOrder_coa_customer").val(data.coa);		                        	
                                                $("#TransactionSalesOrder_coa_name").val(data.coa_name);		                        	
                                                $("#TransactionSalesOrder_estimate_payment_date").val(data.paymentEstimation);		
                                                
                                                if (data.coa == "") {
                                                    $("#payment-text").show();
                                                    $("#payment-ddl").hide();
                                                    $("#payment-ddl select").attr("disabled","disabled");
                                                } else {
                                                    $("#payment-text").hide();
                                                    $("#payment-ddl").show();
                                                    $("#payment-ddl select").prop("disabled", false);
                                                }
                                            },
                                        });
                                    }
                                ',
                                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                'pager' => array(
                                    'cssFile' => false,
                                    'header' => '',
                                ),
                                'columns' => array(
                                    //'kode',
                                    'name',
                                    'email',
                                    array(
                                        'name' => 'customer_type',
                                        'filter' => CHtml::activeDropDownList($customer, 'customer_type', array(
                                            'Individual' => 'Individual',
                                            'Company' => 'Company',
                                                ), array('empty' => '-- Pilih --')),
                                        'value' => '$data->customer_type',
                                    ),
                                    array(
                                        'header' => 'Phone',
                                        'value' => 'empty($data->customerMobiles) ? "" : $data->customerMobiles[0]->mobile_no',
                                    ),
                                    array(
                                        'header' => 'PIC',
                                        'value' => 'empty($data->customerPics) ? "" : $data->customerPics[0]->name',
                                    ),
                                ),
                            )); ?>
                            <?php $this->endWidget(); ?>

                            <?php echo $form->error($salesOrder->header, 'customer_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'requester_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($salesOrder->header, 'requester_id', array('size' => 30, 'maxlength' => 30, 'value' => $salesOrder->header->isNewRecord ? Yii::app()->user->getId() : $salesOrder->header->requester_id, 'readonly' => true)); ?>
                            <?php echo $form->textField($salesOrder->header, 'requester_name', array('size' => 30, 'maxlength' => 30, 'value' => $salesOrder->header->isNewRecord ? Yii::app()->user->getName() : $salesOrder->header->user->username, 'readonly' => true)); ?>
                            <?php echo $form->error($salesOrder->header, 'requester_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'requester_branch_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($salesOrder->header, 'requester_branch_id', array('value' => $salesOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $salesOrder->header->requester_branch_id, 'readonly' => true)); ?>
                            <?php echo $form->textField($salesOrder->header, 'requester_branch_name', array('value' => $salesOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $salesOrder->header->requesterBranch->name, 'readonly' => true)); ?>
                            <?php echo $form->error($salesOrder->header, 'requester_branch_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <?php echo CHtml::button('Add Details', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'onclick' => '$("#product-dialog").dialog("open"); return false;
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $salesOrder->header->id)) . '",
                                    data: jQuery("form").serialize(),
                                    success: function(html) {
                                        jQuery("#detail").html(html);
                                    },
                                });',
                            )); ?>

                            <?php Yii::app()->clientScript->registerScript('updateGridView', '
                            $.updateGridView = function(gridID, name, value) {
                                $("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
                                $.fn.yiiGridView.update(gridID, {data: $.param(
                                    $("#"+gridID+" .filters input, #"+gridID+" .filters select")
                                )});
                            }
                            ', CClientScript::POS_READY); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'coa_customer'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($salesOrder->header, 'coa_customer'); ?>
                            <?php echo $form->textField($salesOrder->header, 'coa_name', array('readonly' => true, 'value' => $salesOrder->header->coa_customer != "" ? Coa::model()->findByPk($salesOrder->coa_customer)->name : '')); ?>
                            <?php echo $form->error($salesOrder->header, 'coa_customer'); ?>
                        </div>
                    </div>
                </div> 

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'estimate_arrival_date'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $salesOrder->header,
                                'attribute' => "estimate_arrival_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => $salesOrder->header->isNewRecord ? date('Y-m-d') : $salesOrder->header->estimate_arrival_date,
                                ),
                            )); ?>
                            <?php echo $form->error($salesOrder->header, 'estimate_arrival_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'estimate_payment_date'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $salesOrder->header,
                                'attribute' => "estimate_payment_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => $salesOrder->header->isNewRecord ? date('Y-m-d') : $salesOrder->header->estimate_payment_date,
                                ),
                            )); ?>
                            <?php echo $form->error($salesOrder->header, 'estimate_payment_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'payment_type'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <div id="payment-text">
                                <?php echo $form->textField($salesOrder->header, 'payment_type', array('readonly' => true, 'value' => 'Cash')); ?>
                            </div>
                            <div id="payment-ddl">
                                <?php echo $form->dropDownList($salesOrder->header, 'payment_type', array('Cash' => 'Cash', 'Credit' => 'Credit'), array(
                                    'prompt' => '[--Select Payment type--]',
                                    'onchange' => 'jQuery.ajax({
                                        type: "POST",
                                        url: "' . CController::createUrl('ajaxGetDate', array('type' => '')) . '" + $(this).val(),
                                        data: jQuery("form").serialize(),
                                        dataType: "json",
                                        success: function(data){
                                            // console.log(data.tanggal);
                                            // console.log(data.type);
                                            jQuery("#TransactionSalesOrder_estimate_payment_date").val(data.tanggal);
                                        },
                                    });'
                                )); ?>
                            </div>
                            <?php echo $form->error($salesOrder->header, 'payment_type'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($salesOrder->header, 'ppn'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($salesOrder->header, 'ppn', array('1' => 'PPN', '2' => 'Non PPN')); ?>
                            <?php echo $form->error($salesOrder->header, 'ppn'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />

        <div id="detail">
            <?php $this->renderPartial('_detailSalesOrder', array('salesOrder' => $salesOrder,)); ?>
        </div>

        <br />

        <div class="row">
            <div class="field">
                <table>
                    <thead>
                        <tr>
                            <td><?php echo $form->labelEx($salesOrder->header, 'price_before_discount'); ?></td>
                            <td><?php echo $form->labelEx($salesOrder->header, 'discount'); ?></td>
                            <td><?php echo $form->labelEx($salesOrder->header, 'subtotal'); ?></td>
                            <td><?php echo $form->labelEx($salesOrder->header, 'ppn_price'); ?></td>
                            <td><?php echo $form->labelEx($salesOrder->header, 'total_price'); ?></td>
                            <td><?php echo $form->labelEx($salesOrder->header, 'total_quantity'); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $form->error($salesOrder->header, 'price_before_discount'); ?>
                            </td>
                            <td>
                                <?php echo $form->error($salesOrder->header, 'discount'); ?>
                            </td>
                            <td>
                                <span id="sub_total">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $salesOrder->subTotal)); ?>
                                </span>
                                <?php echo $form->error($salesOrder->header, 'subtotal'); ?>
                            </td>
                            <td>
                                <span id="tax_value">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $salesOrder->taxAmount)); ?>
                                </span>
                                <?php echo $form->error($salesOrder->header, 'ppn_price'); ?>
                            </td>
                            <td>
                                <span id="grand_total">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $salesOrder->grandTotal)); ?>
                                </span>
                                <?php echo $form->error($salesOrder->header, 'total_price'); ?>
                            </td>
                            <td>
                                <span id="total_quantity">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $salesOrder->totalQuantity)); ?>
                                </span>
                                <?php echo $form->error($salesOrder->header, 'total_quantity'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="row">
                <div class="field">Note: <?php echo CHtml::activeTextArea($salesOrder->header, 'note', array('rows' => 5, 'columns' => 30)); ?></div>
            </div>

            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($salesOrder->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div><!-- form -->
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    // additional javascript options for the dialog plugin
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
                                'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $("#Product_name").val(),
                                    id: $(this).val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                                'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
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
                            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                    'update' => '#product_sub_brand',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
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
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
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
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                    'update' => '#product_sub_master_category',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
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
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
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
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-grid',
                'dataProvider' => $productDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id){
                    $("#product-dialog").dialog("close");
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $salesOrder->header->id, 'productId' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#detail").html(data);
                        },
                    });

                    $("#product-grid").find("tr.selected").each(function(){
                       $(this).removeClass( "selected" );
                    });
                }',
                'columns' => array(
                    'id',
                    'name',
                    'manufacturer_code',
                    array(
                        'header' => 'Kategori',
                        'value' => '$data->masterSubCategoryCode'
                    ),
                    array(
                        'name' => 'unit_id',
                        'value' => '$data->unit->name'
                    ),
                    array(
                        'header' => 'Brand',
                        'name' => 'product_brand_name',
                        'value' => '$data->brand->name'),
                    array(
                        'header' => 'Sub Brand',
                        'name' => 'product_sub_brand_name',
                        'value' => 'empty($data->subBrand) ? "" : $data->subBrand->name'
                    ),
                    array(
                        'header' => 'Sub Brand Series',
                        'name' => 'product_sub_brand_series_name',
                        'value' => 'empty($data->subBrandSeries) ? "" : $data->subBrandSeries->name'
                    ),
                ),
            )); ?>
        </div>
    </div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
    //$(".numbers").number( true,2, ".", ",");
', CClientScript::POS_END);
?>
<script>
    var type = $("#TransactionSalesOrder_cust_type").val();
    var coa = $("#TransactionSalesOrder_coa_customer").val();

    if (coa == "") {
        $("#payment-text").hide();
        $("#payment-ddl").show();
        $("#payment-ddl select").attr("disabled", false);
    } else {
        $("#payment-text").hide();
        $("#payment-ddl").show();
        $("#payment-ddl select").prop("disabled", false);
    }
</script>