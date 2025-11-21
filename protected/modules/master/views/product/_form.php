<?php
/* @var $this ProductController */
/* @var $product->header Product */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/product/admin'; ?>"><span class="fa fa-th-list"></span>Manage Product</a>
    <h1>
        <?php
        if ($product->header->isNewRecord) {
            echo "New Product";
        } else {
            echo "Update Product";
        }
        ?>
    </h1>

    <hr />

    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($product->header); ?>

        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'product_master_category_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'nameAndCode'), array(
                                'prompt' => '[--Select Product Master Category--]',
                                'onchange' => '
                                    $("#' . CHtml::activeId($product->header, 'tire_size_id') . '").val("");
                                    $("#' . CHtml::activeId($product->header, 'oil_sae_id') . '").val("");
                                    $("#tire_size_div").hide();
                                    $("#oil_sae_div").hide();
                                    jQuery.ajax({
                                        type: "POST",
                                        url: "' . CController::createUrl('ajaxGetProductSubMasterCategory') . '",
                                        data: jQuery("form").serialize(),
                                        success: function(data){
                                            jQuery("#Product_code").val("");
                                            jQuery("#Product_product_sub_master_category_id").html(data);
                                            if (jQuery("#Product_product_sub_master_category_id").val() == ""){
                                                jQuery(".additional-specification").slideUp();
                                                jQuery("#Product_product_sub_category_id").html("<option value=\"\">[--Select Product Sub Category--]</option>");
                                            }
                                        },
                                    });
                                '
                            )); ?>
                            <?php echo $form->error($product->header, 'product_master_category_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'product_sub_master_category_id', array('class' => 'prefix')); ?>
                        </div>

                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'product_sub_master_category_id', $product->header->product_master_category_id != '' ? CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $product->header->product_master_category_id)), 'id', 'nameAndCode') : array(), array(
                                'prompt' => '[--Select Product Sub Master Category--]',
                                'onchange' => '
                                    $("#' . CHtml::activeId($product->header, 'tire_size_id') . '").val("");
                                    $("#' . CHtml::activeId($product->header, 'oil_sae_id') . '").val("");
                                    $("#tire_size_div").hide();
                                    $("#oil_sae_div").hide();
                                    if ($(this).val() === "26") {
                                        $("#tire_size_div").show();
                                    } else if ($(this).val() === "39" || $(this).val() === "40") {
                                        $("#oil_sae_div").show();
                                    }
                                    jQuery.ajax({
                                        type: "POST",
                                        url: "' . CController::createUrl('ajaxGetProductSubCategory') . '",
                                        data: jQuery("form").serialize(),
                                        success: function(data){
                                            jQuery("#Product_code").val("");
                                            if (jQuery("#Product_product_sub_master_category_id").val() == ""){
                                                jQuery(".additional-specification").slideUp();
                                            }
                                            jQuery("#Product_product_sub_category_id").html(data);
                                        },
                                    });
                                '
                            )); ?>
                            <?php echo $form->error($product->header, 'product_sub_master_category_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'product_sub_category_id', array('class' => 'prefix')); ?>
                        </div>

                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'product_sub_category_id', $product->header->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $product->header->product_sub_master_category_id)), 'id', 'nameAndCode') : array(), array(
                                'prompt' => '[--Select Product Sub Category--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxGetCode') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        console.log(data);
                                        jQuery("#Product_code").val(data);
                                        jQuery(".additional-specification").slideUp();
                                        if (jQuery("#Product_product_sub_category_id").val() == 263){
                                            jQuery("#battery-specification").slideDown();
                                        }
                                        if (jQuery("#Product_product_sub_category_id").val() == 540 || jQuery("#Product_product_sub_category_id").val() == 541 || jQuery("#Product_product_sub_category_id").val() == 542 || jQuery("#Product_product_sub_category_id").val() == 543){
                                            jQuery("#oil-specification").slideDown();
                                        }
                                        if (jQuery("#Product_product_sub_category_id").val() == 442 || jQuery("#Product_product_sub_category_id").val() == 443){
                                            jQuery("#tire-specification").slideDown();
                                        }
                                    },
                                });'
                            )); ?>
                            <?php echo $form->error($product->header, 'product_sub_category_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'code', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'code', array('size' => 20, 'maxlength' => 20, 'readOnly' => true)); ?>
                            <?php echo $form->error($product->header, 'code'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'barcode', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'barcode', array('size' => 50, 'maxlength' => 50, 'readOnly' => true)); ?>
                            <?php echo $form->error($product->header, 'barcode'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'manufacturer_code', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'manufacturer_code', array('size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($product->header, 'manufacturer_code'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'name', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'name', array('size' => 20, 'maxlength' => 30)); ?>
                            <?php echo $form->error($product->header, 'name'); ?>
                        </div>
                    </div>
                </div>

                <div class="field" id="tire_size_div" style="display: <?php echo $product->header->product_sub_master_category_id !== null && $product->header->product_sub_master_category_id == 26 ? 'block' : 'none'; ?>">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'tire_size_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'tire_size_id', CHtml::listData(TireSize::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Pilih Ukuran Ban',
                            )); ?>
                            <?php echo $form->error($product->header, 'tire_size_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field" id="oil_sae_div" style="display: <?php echo $product->header->product_sub_master_category_id !== null && ($product->header->product_sub_master_category_id == 39 || $product->header->product_sub_master_category_id == 40) ? 'block' : 'none'; ?>">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'oil_sae_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'oil_sae_id', CHtml::listData(OilSae::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Pilih SAE',
                            )); ?>
                            <?php echo $form->error($product->header, 'oil_sae_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'unit_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'unit_id', CHtml::listData(Unit::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'prompt' => '[--Select Unit--]'
                            ));
                            ?>
                            <?php echo $form->error($product->header, 'unit_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'production_year', array('class' => 'prefix')); ?>
                        </div>

                        <div class="small-8 columns">
                            <?php $range = range(date('Y', strtotime('+1 years')), date('Y', strtotime('-5 years'))); ?>
                            <?php echo $form->dropDownList($product->header, 'production_year', array_combine($range, $range)); ?>
                            <?php echo $form->error($product->header, 'production_year'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'brand_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'prompt' => '[--Select Brand--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetSubBrand') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        console.log(data);

                                        jQuery("#Product_sub_brand_id").html(data);
                                        jQuery("#ProductSpecificationBattery_sub_brand_id").html(data);
                                        jQuery("#ProductSpecificationOil_sub_brand_id").html(data);
                                        jQuery("#ProductSpecificationTire_sub_brand_id").html(data);

                                        if (jQuery("#ProductSpecificationBattery_sub_brand_id").val() == "") {
                                            //jQuery(".additional-specification").slideUp();
                                            jQuery("#ProductSpecificationBattery_sub_brand_series_id").html("<option value=\"\">[--Select Sub Brand Series--]</option>");
                                            jQuery("#ProductSpecificationOil_sub_brand_series_id").html("<option value=\"\">[--Select Sub Brand Series--]</option>");
                                            jQuery("#ProductSpecificationTire_sub_brand_series_id").html("<option value=\"\">[--Select Sub Brand Series--]</option>");
                                        }
                                    },
                                });'
                            )); ?>
                            <?php echo $form->error($product->header, 'brand_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($product->header, 'sub_brand_id'); ?></label>
                        </div>

                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'sub_brand_id', $product->header->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $product->header->brand_id)), 'id', 'name') : array(), array(
                                'prompt' => '[--Select Sub Brand--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxGetSubBrandSeries') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        jQuery("#Product_sub_brand_series_id").html(data);
                                    },
                                });'
                            )); ?>
                            <?php echo $form->error($product->header, 'sub_brand_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($product->header, 'sub_brand_series_id'); ?></label>
                        </div>

                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'sub_brand_series_id', $product->header->sub_brand_id != '' ? CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $product->header->sub_brand_id)), 'id', 'name') : array(), array(
                                'prompt' => '[--Select Sub Brand Series--]',
                            )); ?>
                            <?php echo $form->error($product->header, 'sub_brand_series_id'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-5b columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'description', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($product->header, 'description', array('rows' => 6, 'cols' => 50)); ?>
                            <?php echo $form->error($product->header, 'description'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'extension', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'extension', array('size' => 20, 'maxlength' => 30)); ?>
                            <?php echo $form->error($product->header, 'extension'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'retail_price', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'retail_price', array('size' => 10, 'maxlength' => 10,
                                'onchange' => '
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonPricing', array('id' => $product->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#tax_value").html(data.taxValue);
                                        $("#retail_after_tax").html(data.retailAfterTax);
                                        $("#recommended_selling_price").html(data.recommendedSellingPrice);
                                    },
                                });	
                            ',
                            )); ?>
                            <?php echo $form->error($product->header, 'retail_price'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'PPn', array('class' => 'prefix')); ?>
                        </div>

                        <div class="small-8 columns">
                            <span id="tax_value">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($product->header, 'purchasePriceTax'))); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'Retail + PPn', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <span id="retail_after_tax">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($product->header, 'retailPriceAfterTax'))); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'margin_type', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'margin_type', array(
                                '1' => 'Percent',
                                '2' => 'Amount',
                                    ), array('prompt' => 'Select',
                                'onchange' => '
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonPricing', array('id' => $product->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#recommended_selling_price").html(data.recommendedSellingPrice);
                                    },
                                });	
                            ',
                            )); ?>
                            <?php echo $form->error($product->header, 'margin_type'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'margin_amount', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'margin_amount', array(
                                'onchange' => '
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonPricing', array('id' => $product->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#recommended_selling_price").html(data.recommendedSellingPrice);
                                    },
                                });	
                            ',
                            )); ?>
                            <?php echo $form->error($product->header, 'margin_amount'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'recommended_selling_price', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <span id="recommended_selling_price">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($product->header, 'recommended_selling_price'))); ?>
                            </span>
                            <?php echo $form->hiddenField($product->header, 'recommended_selling_price'); ?>
                            <?php echo $form->error($product->header, 'recommended_selling_price'); ?>
                        </div>
                    </div>
                </div>

                <?php if (Yii::app()->user->checkAccess('director')): ?>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($product->header, 'HPP', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php if ($product->header->isNewRecord): ?>
                                    <?php echo $form->textField($product->header, 'hpp'); ?>
                                <?php else: ?>
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($product->header, 'hpp'))); ?>
                                <?php endif; ?>
                                <?php echo $form->error($product->header, 'hpp'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'minimum_stock', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($product->header, 'minimum_stock'); ?>
                            <?php echo $form->error($product->header, 'minimum_stock'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'is_usable', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'is_usable', array(
                                'No' => 'No',
                                'Yes' => 'Yes'
                            )); ?>
                            <?php echo $form->error($product->header, 'is_usable'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($product->header, 'status', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($product->header, 'status', array(
                                'Active' => 'Active',
                                'Inactive' => 'Inactive'
                            )); ?>
                            <?php echo $form->error($product->header, 'status'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <?php $this->renderPartial('_battery', array('form' => $form, 'product' => $product, 'productSpecificationBattery' => $productSpecificationBattery)); ?>
                <?php $this->renderPartial('_oil', array('form' => $form, 'product' => $product, 'productSpecificationOil' => $productSpecificationOil)); ?>
                <?php $this->renderPartial('_tire', array('form' => $form, 'product' => $product, 'productSpecificationTire' => $productSpecificationTire)); ?>

                <div class="clearfix"></div>

                <?php echo CHtml::button('Add Vehicle', array(
                    'id' => 'detail-button',
                    'name' => 'Detail',
                    'class' => 'button extra right',
                    'onclick' => '
                        jQuery.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlAddVehicleDetail', array('id' => $product->header->id)) . '",
                                data: jQuery("form").serialize(),
                                success: function(html) {
                                        jQuery("#vehicle").html(html);
                                },
                        });',
                )); ?>
                <h2>Vehicle</h2>
                <div id="vehicle">
                    <?php $this->renderPartial('_detailVehicle', array('product' => $product,)); ?>
                </div>

                <div class="clearfix"></div>
            </div>
            <!-- begin RIGHT -->
            <div class="small-12 medium-5b columns">
                <?php echo CHtml::button('Add Product Complement', array(
                    'id' => 'product-complement-button',
                    'name' => 'product-complement',
                    'class' => 'button extra right',
                    'onclick' => 'jQuery("#product-complement-dialog").dialog("open"); return false;',
                )); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'product-complement-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Product Complement',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                )); ?>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'product-complement-grid',
                    'dataProvider' => $productComplementSubstituteDataProvider,
                    'filter' => $productComplementSubstitute,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'check',
                            'id' => 'selectedIds',
                            'value' => '$data->id',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => '100',
                            'checkBoxHtmlOptions' => array(
                                'onclick' => '
                                    js: if ($(this).is(":checked")==true){								
                                        var selected_product_complement = $(this).val();
                                        var checked_array = [];

                                        jQuery("#product-complement tr").not("thead tr").each(function(){
                                            var added_product_complement_id = $(this).find("input[type=hidden]").val();				
                                            checked_array.push(added_product_complement_id);
                                        });

                                        if (jQuery.inArray(selected_product_complement, checked_array)!= -1) {
                                            alert("Please select other Complement, this is already added");
                                            return false;
                                        } else {
                                            $.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxHtmlAddProductComplementDetail', array()) . '/id/' . $product->header->id . '/productComplementId/"+$(this).val(),
                                                data: $("form").serialize(),
                                                success: function(html) {
                                                    $("#product-complement").html(html);
                                                },
                                            });
                                            $(this).parent("td").parent("tr").addClass("checked");
                                            $(this).parent("td").parent("tr").removeClass("unchecked");
                                        }
                                    } else {
                                        //var unchecked_val= $(this).val();

                                        var unselected_complement = $(this).val();
                                        var unchecked_array = [];
                                        var count = 1;
                                        jQuery("#product-complement tr").not("thead tr").each(function(){		
                                            var removed_product_complement_id = $(this).find("input[type=hidden]").val();																						
                                            unchecked_array.push(removed_product_complement_id);																						
                                            if (unselected_complement==removed_product_complement_id){
                                                index_id = count-1;																		
                                            }
                                            count++;
                                        });

                                        console.log(unchecked_array);

                                        if (jQuery.inArray(unselected_complement, unchecked_array)!= -1) {									
                                            $.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxHtmlRemoveProductComplementDetail', array()) . '/id/' . $product->header->id . '/index/"+index_id,
                                                data: $("form").serialize(),
                                                success: function(html) {
                                                    $("#product-complement").html(html);						
                                                },
                                                update:"#product-complement",
                                            });
                                        } 
                                        $(this).parent("td").parent("tr").removeClass("checked");
                                        $(this).parent("td").parent("tr").addClass("unchecked");
                                    }
                                '
                            ),
                        ),
                        'name',
                        array('name' => 'product_master_category_name', 'value' => '$data->productMasterCategory->name'),
                        array('name' => 'product_sub_master_category_name', 'value' => '$data->productSubMasterCategory->name'),
                        array('name' => 'product_sub_category_name', 'value' => '$data->productSubCategory->name'),
                    ),
                )); ?>
                <?php $this->endWidget(); ?>

                <div id="product-complement">
                    <?php $this->renderPartial('_detailComplement', array('product' => $product)); ?>
                </div>
                <!-- End Product Complement -->

                <!-- Product Substitute -->
                <?php echo CHtml::button('Add Product Substitute', array(
                    'id' => 'product-substitute-button',
                    'name' => 'product-substitute',
                    'class' => 'button extra right',
                    'onclick' => 'jQuery("#product-substitute-dialog").dialog("open"); return false;',
                )); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'product-substitute-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Product Substitute',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                )); ?>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'product-substitute-grid',
                    'dataProvider' => $productComplementSubstituteDataProvider,
                    'filter' => $productComplementSubstitute,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'check',
                            'id' => 'selectedIds',
                            'value' => '$data->id',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => '100',
                            'checkBoxHtmlOptions' => array(
                                'onclick' => '
                                    js: if ($(this).is(":checked")==true){								
                                        var selected_product_substitute = $(this).val();
                                        var checked_array = [];

                                        jQuery("#product-substitute tr").not("thead tr").each(function(){
                                            var added_product_substitute_id = $(this).find("input[type=hidden]").val();				
                                            checked_array.push(added_product_substitute_id);
                                        });

                                        if (jQuery.inArray(selected_product_substitute, checked_array)!= -1) {
                                            alert("Please select other Substitute, this is already added");
                                            return false;
                                        } else {
                                            $.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxHtmlAddProductSubstituteDetail', array()) . '/id/' . $product->header->id . '/productSubstituteId/"+$(this).val(),
                                                data: $("form").serialize(),
                                                success: function(html) {
                                                        $("#product-substitute").html(html);
                                                },
                                            });
                                            $(this).parent("td").parent("tr").addClass("checked");
                                            $(this).parent("td").parent("tr").removeClass("unchecked");
                                        }
                                    } else {
                                        var unselected_substitute = $(this).val();
                                        var unchecked_array = [];
                                        var count = 1;
                                        jQuery("#product-substitute tr").not("thead tr").each(function(){		
                                            var removed_product_substitute_id = $(this).find("input[type=hidden]").val();																						
                                            unchecked_array.push(removed_product_substitute_id);																						
                                            if (unselected_substitute==removed_product_substitute_ids) {
                                                index_id = count-1;																		
                                            }
                                            count++;
                                        });

                                        console.log(unchecked_array);

                                        if (jQuery.inArray(unselected_substitute, unchecked_array)!= -1) {									
                                            $.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxHtmlRemoveProductSubstituteDetail', array()) . '/id/' . $product->header->id . '/index/"+index_id,
                                                data: $("form").serialize(),
                                                success: function(html) {
                                                    $("#product-substitute").html(html);						
                                                },
                                                update:"#product-substitute",
                                            });
                                        } 
                                        $(this).parent("td").parent("tr").removeClass("checked");
                                        $(this).parent("td").parent("tr").addClass("unchecked");
                                    }
                                '
                            ),
                        ),
                        'name',
                        array('name' => 'product_master_category_name', 'value' => '$data->productMasterCategory->name'),
                        array('name' => 'product_sub_master_category_name', 'value' => '$data->productSubMasterCategory->name'),
                        array('name' => 'product_sub_category_name', 'value' => '$data->productSubCategory->name'),
                    ),
                )); ?>
                <?php $this->endWidget(); ?>

                <div id="product-substitute">
                    <?php $this->renderPartial('_detailSubstitute', array('product' => $product)); ?>
                </div>

                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton($product->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
                </div>
            </div>
            <!-- end RIGHT -->
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>