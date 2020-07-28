<?php
/* @var $this SupplierController */
/* @var $model Supplier */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/supplier/admin';?>"><span class="fa fa-th-list"></span>Manage Supplier</a>
    <h1><?php if($supplier->header->isNewRecord){ echo "New Supplier"; }else{ echo "Update Supplier";}?></h1>
    <!-- begin FORM -->
    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'supplier-form',
            'enableAjaxValidation'=>false,
        )); ?>
        
        <hr />
        
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($supplier->header); ?>
        <?php echo $form->errorSummary($supplier->phoneDetails); ?>
        <?php echo $form->errorSummary($supplier->mobileDetails); ?>
        <?php echo $form->errorSummary($supplier->bankDetails); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'code'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'code',array('size'=>20,'maxlength'=>20)); ?>
                            <?php echo $form->error($supplier->header,'code'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'name'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'name',array('size'=>30,'maxlength'=>30,'style'=>'text-transform: capitalize')); ?>
                            <?php echo $form->error($supplier->header,'name'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'company'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'company',array('size'=>30,'maxlength'=>30)); ?>
                            <?php echo $form->error($supplier->header,'company'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'address'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($supplier->header,'address',array('rows'=>6, 'cols'=>50)); ?>
                            <?php echo $form->error($supplier->header,'address'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'province_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo  $form->dropDownList($supplier->header, 'province_id',  array('prompt' => 'Select',)); ?>
                            <?php echo $form->dropDownList($supplier->header, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
                                'prompt' => '[--Select Province--]',
                                'onchange'=> '$.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetCity') . '" ,
                                    data: $("form").serialize(),
                                    success: function(data){
                                        console.log(data);
                                        $("#Supplier_city_id").html(data);
                                    },
                                });'
                            )); ?>
                            <?php echo $form->error($supplier->header,'province_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                          <label class="prefix"><?php echo $form->labelEx($supplier->header,'city_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo  $form->dropDownList($supplier->header, 'city_id',	 array('prompt' => 'Select',)); ?>
                            <?php //echo $form->textField($supplier->header,'city_id',array('size'=>10,'maxlength'=>10)); ?>
                            <?php
                                if ($supplier->header->province_id == NULL) {
                                    echo $form->dropDownList($supplier->header,'city_id',array(),array('prompt'=>'[--Select City-]'));
                                } else {
                                    echo $form->dropDownList($supplier->header,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$supplier->header->province_id)), 'id', 'name'),array());
                                }
                            ?>
                            <?php echo $form->error($supplier->header,'city_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'zipcode'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
                            <?php echo $form->error($supplier->header,'zipcode'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'phone'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'phone',array('size'=>10,'maxlength'=>60)); ?>
                            <?php echo $form->error($supplier->header,'phone'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'person_in_charge'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'person_in_charge',array('size'=>10,'maxlength'=>100)); ?>
                            <?php echo $form->error($supplier->header,'person_in_charge'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Phones</label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::button('+', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'onclick' => '
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddPhoneDetail', array('id' => $supplier->header->id)) . '",
                                    data: jQuery("form").serialize(),
                                    success: function(html) {
                                        jQuery("#phone").html(html);
                                    },
                                });',
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="field" id="phone">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detailPhone', array(
                            'supplier'=>$supplier
                        )); ?>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Mobiles</label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::button('+', array(
                                'id' => 'detail-mobile-button',
                                'name' => 'DetailMobile',
                                'onclick' => '
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddMobileDetail', array('id' => $supplier->header->id)) . '",
                                    data: jQuery("form").serialize(),
                                    success: function(html) {
                                        jQuery("#mobile").html(html);
                                    },
                                });',
                            )); ?>
                        </div>
                    </div>
                </div>

                <div class="field" id="mobile">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detailMobile', array('supplier'=>$supplier)); ?>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'email_personal'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'email_personal'); ?>
                            <?php echo $form->error($supplier->header,'email_personal'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'email_company'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'email_company',array('size'=>60,'maxlength'=>60)); ?>
                            <?php echo $form->error($supplier->header,'email_company'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'npwp'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'npwp',array('size'=>20,'maxlength'=>20)); ?>
                            <?php echo $form->error($supplier->header,'npwp'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'tenor'); ?></label>
                        </div>
                        <div class="small-3 columns">
                            <?php $range = range(10,100,5 ); ?>
                            <?php echo $form->dropDownList($supplier->header,'tenor',array_combine($range, $range )); ?>
                            <?php echo $form->error($supplier->header,'tenor'); ?>
                        </div>
                        <div class="small-5 columns"><label class="sufix"><?php echo 'days' ?></label></div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'company_attribute'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo  $form->dropDownList($supplier->header, 'company_attribute', array(
                                'PKP' => 'PKP',
                                'NonPKP' => 'NonPKP',
                            ),array('prompt'=>'[-- Select Company Attribute --]')); ?>
                            <?php echo $form->error($supplier->header,'company_attribute'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'coa_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($supplier->header,'coa_id'); ?>
                            <?php echo $form->textField($supplier->header,'coa_name',array('readonly'=>true,'value'=>$supplier->header->coa_id != "" ? Coa::model()->findByPk($supplier->header->coa_id)->name : '','onclick'=>'jQuery("#coa-dialog").dialog("open"); return false;')); ?>
                            <?php echo $form->textField($supplier->header,'coa_code',array('readonly'=>true,'value'=>$supplier->header->coa_id != "" ? Coa::model()->findByPk($supplier->header->coa_id)->code : '')); ?>
                            <?php echo $form->error($supplier->header,'coa_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'coa_outstanding_order'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($supplier->header,'coa_outstanding_order'); ?>
                            <?php echo $form->textField($supplier->header,'coa_outstanding_name',array('readonly'=>true,'value'=>$supplier->header->coa_outstanding_order != "" ? Coa::model()->findByPk($supplier->header->coa_outstanding_order)->name : '','onclick'=>'jQuery("#coa-outstanding-dialog").dialog("open"); return false;')); ?>
                            <?php echo $form->textField($supplier->header,'coa_outstanding_code',array('readonly'=>true,'value'=>$supplier->header->coa_outstanding_order != "" ? Coa::model()->findByPk($supplier->header->coa_outstanding_order)->code : '')); ?>
                            <?php echo $form->error($supplier->header,'coa_outstanding_order'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'description'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($supplier->header,'description'); ?>
                            <?php echo $form->error($supplier->header,'description'); ?>
                        </div>

                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'status'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($supplier->header, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive')); ?>
                            <?php echo $form->error($supplier->header,'status'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Banks</label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::button('+', array(
                                'id' => 'detail-bank-button',
                                'name' => 'DetailBanks',
                                'onclick' => 'jQuery("#bank-dialog").dialog("open"); return false;'
                            )); ?>
                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => 'bank-dialog',
                                // additional javascript options for the dialog plugin
                                'options' => array(
                                    'title' => 'Bank',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                ),
                            )); ?>

                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'bank-grid',
                                'dataProvider'=>$bankDataProvider,
                                'filter'=>$bank,
                                // 'summaryText'=>'',
                                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                'pager'=>array(
                                   'cssFile'=>false,
                                   'header'=>'',
                                ),
                                'selectionChanged'=>'js:function(id) {
                                    $("#bank-dialog").dialog("close");
                                    $.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('supplier/ajaxHtmlAddBankDetail', array('id'=>$supplier->header->id,'bankId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            $("#bank").html(html);
                                        },
                                    });
                                    $("#bank-grid").find("tr.selected").each(function(){
                                       $(this).removeClass( "selected" );
                                    });
                                }',
                                'columns'=>array(
                                    'code',
                                    'name'
                                ),
                            )); ?>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
                <div class="field" id="bank">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detailBank', array('supplier'=>$supplier)); ?>
                    </div>
                </div> 
            </div>

            <!-- Add Product -->
            <div class="small-12 medium-6 columns">

                <?php echo CHtml::button('Add PIC', array(
                    'id' => 'detail-button',
                    'name' => 'Detail',
                    'class'=>'button extra right',
                    'onclick' => '
                        jQuery.ajax({
                            type: "POST",
                            url: "' . CController::createUrl('ajaxHtmlAddPicDetail', array('id' => $supplier->header->id)) . '",
                            data: jQuery("form").serialize(),
                            success: function(html) {
                                jQuery("#pic").html(html);
                            },
                        });
                    ',
                )); ?>
                <!-- <a class="button extra right" href="#"><span class=""></span>Add PIC</a> -->
                <h2>PIC</h2>
                <div id="pic">
                    <?php $this->renderPartial('_detailPic', array('supplier'=>$supplier)); ?>
                </div>
            </div>
        </div>

    <!-- begin RIGHT -->
        <?php echo CHtml::button('Add Multiple Product', array(
            'id' => 'product-detail-button',
            'name' => 'Product Detail',
            'style'=>'display:none;',
            'class'=>'button extra right',
            'onclick' => '
                jQuery.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddProductDetail', array('id' => $supplier->header->id)) . '",
                    data: jQuery("form").serialize(),
                    success: function(html) {
                        jQuery("#product").html(html);
                    },
                    beforeSend: function(){
                        var r = confirm("Are you sure to add new products?");
                        if(!r){return false;} 
                    }
                });
            ',
        )); ?>

        <!-- begin RIGHT -->
        <?php echo CHtml::button('Add Product', array(
            'id' => 'product-detail-button',
            'name' => 'Product Detail',
            'class'=>'button extra right',
            'onclick' => 'jQuery("#product-dialog").dialog("open"); return false;',
        )); ?>

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
            <div class="medium-12 columns" style="padding-left: 0px; padding-right: 0px;">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Sub Brand</th>
                            <th>Sub Brand Series</th>
                            <th>Master Kategori</th>
                            <th>Sub Master Kategori</th>
                            <th>Sub Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
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
                                    } } });',
                                )); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                        brand_id: $(this).val(),
                                        sub_brand_id: $("#Product_sub_brand_id").val(),
                                        sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                        product_master_category_id: $("#Product_product_master_category_id").val(),
                                        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                        product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                        manufacturer_code: $("#Product_manufacturer_code").val(),
                                        name: $("#Product_name").val(),
                                    } } });',
                                )); ?>
                            </td>
                            <td>
                                <div id="product_sub_brand">
                                    <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                            brand_id: $("#Product_brand_id").val(),
                                            sub_brand_id: $(this).val(),
                                            sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                            product_master_category_id: $("#Product_product_master_category_id").val(),
                                            product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                            product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                            manufacturer_code: $("#Product_manufacturer_code").val(),
                                            name: $("#Product_name").val(),
                                        } } });',
                                    )); ?>
                                </div>
                            </td>
                            <td>
                                <div id="product_sub_brand_series">
                                    <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                                        'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                            brand_id: $("#Product_brand_id").val(),
                                            sub_brand_id: $("#Product_sub_brand_id").val(),
                                            sub_brand_series_id: $(this).val(),
                                            product_master_category_id: $("#Product_product_master_category_id").val(),
                                            product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                            product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                            manufacturer_code: $("#Product_manufacturer_code").val(),
                                            name: $("#Product_name").val(),
                                        } } });',
                                    )); ?>
                                </div>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                                    'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                        brand_id: $("#Product_brand_id").val(),
                                        sub_brand_id: $("#Product_sub_brand_id").val(),
                                        sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                        product_master_category_id: $(this).val(),
                                        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                        product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                        manufacturer_code: $("#Product_manufacturer_code").val(),
                                        name: $("#Product_name").val(),
                                    } } });',
                                )); ?>
                            </td>
                            <td>
                                <div id="product_sub_master_category">
                                    <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                                        'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                            brand_id: $("#Product_brand_id").val(),
                                            sub_brand_id: $("#Product_sub_brand_id").val(),
                                            sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                            product_master_category_id: $("#Product_product_master_category_id").val(),
                                            product_sub_master_category_id: $(this).val(),
                                            product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                            manufacturer_code: $("#Product_manufacturer_code").val(),
                                            name: $("#Product_name").val(),
                                        } } });',
                                    )); ?>
                                </div>
                            </td>
                            <td>
                                <div id="product_sub_category">
                                    <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                                        'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                            brand_id: $("#Product_brand_id").val(),
                                            sub_brand_id: $("#Product_sub_brand_id").val(),
                                            sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                            product_master_category_id: $("#Product_product_master_category_id").val(),
                                            product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                            product_sub_category_id: $(this).val(),
                                            manufacturer_code: $("#Product_manufacturer_code").val(),
                                            name: $("#Product_name").val(),
                                        } } });',
                                    )); ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'product-grid',
            'dataProvider'=>$productDataProvider,
            'filter'=> null, 
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',	
            'pager'=>array(
               'cssFile'=>false,
               'header'=>'',
            ),
            /*'selectionChanged'=>'js:function(id){
                $("#product-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    //dataType: "JSON",
                    url: "' . CController::createUrl('ajaxHtmlAddSingleProductDetail', array('id'=>$supplier->header->id,'productId'=>'')) .'"+$.fn.yiiGridView.getSelection(id),
                    data: $("form").serialize(),
                    success: function(html) {
                        $("#product").html(html);

                    },
                });
                $("#product-grid").find("tr.selected").each(function(){
                   $(this).removeClass( "selected" );
                });
            }',*/
            'columns'=>array(
                array(
                    'name' => 'check',
                    'id' => 'selectedIds',
                    'value' => '$data->id',
                    'class' => 'CCheckBoxColumn',
                    'checked' => function($data) use($productArray) {
                        return in_array($data->id, $productArray); 
                    }, 
                    'selectableRows' => '100',	
                    'checkBoxHtmlOptions' => array(
                        'onchange'=>'
                            js: if($(this).is(":checked")==true){
                                var selected_supplier_product = $(this).val();
                                var checked_array = [];

                                jQuery("#product tr").not("thead tr").each(function(){
                                    var added_product_id = $(this).find("input[type=hidden]").val();				
                                    checked_array.push(added_product_id); 
                                });

                                if(jQuery.inArray(selected_supplier_product, checked_array)!= -1) {
                                    alert("Please select other product, this is already added");
                                    return false;
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxHtmlAddSingleProductDetail', array('id'=>$supplier->header->id,'productId'=>'')) .'"+$(this).val(),
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            $("#product").html(html);	

                                        },
                                    });
                                    $(this).parent("td").parent("tr").addClass("checked");
                                    $(this).parent("td").parent("tr").removeClass("unchecked");
                                }

                            } else {
                                //var unchecked_val= $(this).val();

                                var unselected_supplier_product = $(this).val();
                                var unselected_supplier_product_name = $(this).parent("td").siblings("td").html();
                                console.log(unselected_supplier_product);
                                var unchecked_array = [];
                                var count = 1;
                                jQuery("#product tr").not("thead tr").each(function(){
                                    //console.log("Count " + count);
                                    var removed_product_id = $(this).find("input[type=hidden]").val();																						
                                    unchecked_array.push(removed_product_id);
                                    //console.log("Removed "+removed_product_id);
                                    if(unselected_supplier_product==removed_product_id){
                                        console.log("Count: "+count);
                                        index_id = count-1;
                                        console.log(index_id);															
                                    }
                                    count++;
                                });

                                console.log(unchecked_array);

                                if(jQuery.inArray(unselected_supplier_product, unchecked_array)!= -1) {

                                    $.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxHtmlRemoveProductDetail', array()) . '/id/'.$supplier->header->id.'/index/"+index_id,
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            $("#product").html(html);					
                                        },
                                        update:"#product",
                                    });
                                } 

                                $(this).parent("td").parent("tr").removeClass("checked");
                                $(this).parent("td").parent("tr").addClass("unchecked");
                            }
                        '
                    ),											
                ),
                //'id',
                //'code',
                'name',
//                'production_year',
                // array('name'=>'product_brand_name', 'value'=>'$data->brand->name'),
                array(
                    'name'=>'brand_id', 
                    'value'=>'$data->brand->name',
                ),
                array(
                    'name'=>'sub_brand_id', 
                    'value'=>'$data->subBrand->name',
                ),
                array(
                    'name'=>'sub_brand_series_id', 
                    'value'=>'$data->subBrandSeries->name',
                ),
                array(
                    'name'=>'product_master_category_name', 
                    'header' => 'Master Category',
                    'value'=>'$data->productMasterCategory->name'
                ),
                array(
                    'name'=>'product_sub_master_category_name', 
                    'header' => 'Sub Master Category',
                    'value'=>'$data->productSubMasterCategory->name'
                ),
                array(
                    'name'=>'product_sub_category_name', 
                    'header' => 'Sub Category',
                    'value'=>'$data->productSubCategory->name'
                ),
            ),
        ));

        echo CHtml::button(
            'Add All', array(
                'onclick' => '

                    var checked_product = [];
                    jQuery("#product-grid table tr").not("thead tr").each(function(index){
                        var addedProductId = $(this).find("#selectedIds_"+index).val();				
                        checked_product.push(addedProductId); 
                    });

                    // console.log(checked_product);
                    jQuery.ajax({
                        type: "POST",
                        url: "' . CController::createUrl('ajaxHtmlAddProductDetailAlt', array('id' => $supplier->header->id)) . '",
                        data: {checked_product:checked_product},
                        success: function(html) {
                            // console.log(html);
                            jQuery("#product").html(html);
                        },
                        beforeSend: function(){
                            var r = confirm("Are you sure to add new products?");
                            if(!r){return false;} 
                        }
                    });'
            )); ?>
        <?php echo CHtml::endForm(); ?>
        <?php $this->endWidget(); ?>
        <h2>Product</h2>
        <?php /*
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($supplier->header,'product_master_category_id'); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->dropDownList($supplier->header, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'),array(
                            'prompt' => '[--Select Product Master Category--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                //dataType: "JSON",
                                url: "' . CController::createUrl('ajaxGetProductSubMasterCategory') . '",
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);
                                    jQuery("#Supplier_product_sub_master_category_id").html(data);
                                    if(jQuery("#Supplier_product_sub_master_category_id").val() == ""){
                                        jQuery(".additional-specification").slideUp();
                                        jQuery("#Product_product_sub_category_id").html("<option value=\"\">[--Select Product Sub Category--]</option>");
                                    }
                                },
                            });'
                        )
                    ); ?>
                    <?php echo $form->error($supplier->header,'product_master_category_id'); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($supplier->header,'product_sub_master_category_id'); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->dropDownList($supplier->header, 'product_sub_master_category_id', $supplier->header->product_master_category_id != '' ? CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id'=>$supplier->header->product_master_category_id)), 'id', 'name') : array(),array(
                            'prompt' => '[--Select Product Sub Master Category--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxGetProductSubCategory') . '",
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);
                                    if(jQuery("#Supplier_product_sub_master_category_id").val() == ""){
                                        jQuery(".additional-specification").slideUp();
                                    }
                                    jQuery("#Supplier_product_sub_category_id").html(data);
                                },
                            });'
                        )
                    ); ?>
                    <?php echo $form->error($supplier->header,'product_sub_master_category_id'); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($supplier->header,'product_sub_category_id'); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->dropDownList($supplier->header, 'product_sub_category_id', $supplier->header->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id'=>$supplier->header->product_sub_master_category_id)), 'id', 'name') : array(),array(
                            'prompt' => '[--Select Product Sub Category--]',
                    )); ?>
                    <?php echo $form->error($supplier->header,'product_sub_category_id'); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($supplier->header,'production_year'); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php $range = range(date('Y', strtotime('+1 years')),1988); ?>
                    <?php echo $form->dropDownList($supplier->header, 'production_year', array_combine($range, $range), array('prompt' => '[--Select Production Year--]',)); ?>
                    <?php echo $form->error($supplier->header,'production_year'); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($supplier->header,'brand_id'); ?></label>
                </div>
               <div class="small-8 columns">
                    <?php echo $form->dropDownList($supplier->header, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'),array(
                            'prompt' => '[--Select Brand--]',
                            'onchange'=> 'jQuery.ajax({
                                /*type: "POST",
                                //dataType: "JSON",
                                url: "' . CController::createUrl('ajaxGetSubBrand') . '",
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);

                                    jQuery("#ProductSpecificationBattery_sub_brand_id").html(data);
                                    jQuery("#ProductSpecificationOil_sub_brand_id").html(data);
                                    jQuery("#ProductSpecificationTire_sub_brand_id").html(data);

                                    if(jQuery("#ProductSpecificationBattery_sub_brand_id").val() == ""){
                                        //jQuery(".additional-specification").slideUp();
                                        jQuery("#ProductSpecificationBattery_sub_brand_series_id").html("<option value=\"\">[--Select Sub Brand Series--]</option>");
                                        jQuery("#ProductSpecificationOil_sub_brand_series_id").html("<option value=\"\">[--Select Sub Brand Series--]</option>");
                                        jQuery("#ProductSpecificationTire_sub_brand_series_id").html("<option value=\"\">[--Select Sub Brand Series--]</option>");
                                    }
                                },* /
                            });'
                        )
                    ); ?>
                    <?php echo $form->error($supplier->header,'brand_id'); ?>
                </div>
            </div>
        </div>*/?>


        <div id="product">
            <?php $this->renderPartial('_detailProduct', array('supplier'=>$supplier)); ?>
        </div>
    <hr>
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($supplier->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
    </div>

    <?php $this->endWidget(); ?>

    </div>
</div><!-- form -->
<!--COA Supplier-->
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
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'coa-grid',
        'dataProvider'=>$coaDataProvider,
        'filter'=>$coa,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'selectionChanged'=>'js:function(id){
            $("#coa-dialog").dialog("close");
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                data: $("form").serialize(),
                success: function(data) {

                    $("#Supplier_coa_id").val(data.id);
                    $("#Supplier_coa_code").val(data.code);
                    $("#Supplier_coa_name").val(data.name);

                },
            });
            $("#coa-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
        }',
        'columns'=>
        array(
            'name',
            'code',
        ),
    )); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<!--COA Outstanding Supplier-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-outstanding-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA Outstanding Order',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-outstanding-grid',
		'dataProvider'=>$coaOutstandingDataProvider,
		'filter'=>$coaOutstanding,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#coa-outstanding-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#Supplier_coa_outstanding_order").val(data.id);
					$("#Supplier_coa_outstanding_code").val(data.code);
					$("#Supplier_coa_outstanding_name").val(data.name);
					
				},
			});
			$("#coa-outstanding-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=>
		//$coumns
		array(
			'name',
			'code',
		),
	)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>