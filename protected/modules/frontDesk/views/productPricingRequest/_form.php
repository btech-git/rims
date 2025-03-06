<div class="clearfix page-action">
    <!--<a class="button cbutton right" href="<?php //echo Yii::app()->baseUrl . 'admin';  ?>"><span class="fa fa-th-list"></span>Manage</a>-->
    <h1>New Permintaan Harga</h1>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-pricing-request-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    )); ?>

    <hr />
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="medium-12 columns">
            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($model, 'Nama Barang'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($model, 'product_name'); ?>
                                <?php echo CHtml::error($model, 'product_name'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($model, 'Tahun Produksi'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($model, 'production_year'); ?>
                                <?php echo CHtml::error($model, 'production_year'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Vehicle Car Make</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model, "vehicle_car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array(
                                    'prompt' => '[--Select Vehicle Car Make--]',
                                    'onchange' => 'jQuery.ajax({
	                  		type: "POST",
	                  		//dataType: "JSON",
	                  		url: "' . CController::createUrl('ajaxGetVehicleCarModel') . '",
	                  		data: jQuery("form").serialize(),
	                  		success: function(data) {
                                            jQuery("#ProductPricingRequest_vehicle_car_model_id").html(data);
                                        },
                                    });'
                                )); ?>
                                <?php echo $form->error($model,'vehicle_car_make_id');  ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Vehicle Car Model</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model, "vehicle_car_model_id", CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array(
                                    'prompt' => '[--Select Vehicle Car Model--]',
                                )); ?>
                                <?php echo $form->error($model,'vehicle_car_model_id');  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model, 'brand_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($model, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'prompt' => '[--Select Brand--]',
                                    'onchange' => 'jQuery.ajax({
                                        type: "POST",
                                        url: "' . CController::createUrl('ajaxGetSubBrand') . '",
                                        data: jQuery("form").serialize(),
                                        success: function(data) {
                                            jQuery("#ProductPricingRequest_sub_brand_id").html(data);
                                            if (jQuery("#ProductPricingRequest_sub_brand_id").val() == "") {
                                                jQuery("#ProductPricingRequest_sub_brand_series_id").html("<option value=\"\">[--Select Sub Brand Series--]</option>");
                                            }
                                        },
                                    });'
                                )); ?>
                                <?php echo $form->error($model, 'brand_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($model, 'sub_brand_id'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($model, 'sub_brand_id', $model->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $model->brand_id)), 'id', 'name') : array(), array(
                                    'prompt' => '[--Select Sub Brand--]',
                                    'onchange' => 'jQuery.ajax({
                                        type: "POST",
                                        url: "' . CController::createUrl('ajaxGetSubBrandSeries') . '",
                                        data: jQuery("form").serialize(),
                                        success: function(data){
                                            jQuery("#ProductPricingRequest_sub_brand_series_id").html(data);
                                        },
                                    });'
                                )); ?>
                                <?php echo $form->error($model, 'sub_brand_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($model, 'sub_brand_series_id'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($model, 'sub_brand_series_id', $model->sub_brand_id != '' ? CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $model->sub_brand_id)), 'id', 'name') : array(), array(
                                    'prompt' => '[--Select Sub Brand Series--]',
                                )); ?>
                                <?php echo $form->error($model, 'sub_brand_series_id'); ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model, 'product_master_category_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($model, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'nameAndCode'), array(
                                    'prompt' => '[--Select Product Master Category--]',
                                    'onchange' => 'jQuery.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxGetProductSubMasterCategory') . '",
                                        data: jQuery("form").serialize(),
                                        success: function(data){
                                            console.log(data);
                                            jQuery("#ProductPricingRequest_product_sub_master_category_id").html(data);
                                            if (jQuery("#ProductPricingRequest_product_sub_master_category_id").val() == ""){
                                                jQuery("#ProductPricingRequest_product_sub_category_id").html("<option value=\"\">[--Select Product Sub Category--]</option>");
                                            }
                                        },
                                    });'
                                )); ?>
                                <?php echo $form->error($model, 'product_master_category_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model, 'product_sub_master_category_id', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($model, 'product_sub_master_category_id', $model->product_master_category_id != '' ? CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $model->product_master_category_id)), 'id', 'nameAndCode') : array(), array(
                                    'prompt' => '[--Select Product Sub Master Category--]',
                                    'onchange' => 'jQuery.ajax({
                                        type: "POST",
                                        url: "' . CController::createUrl('ajaxGetProductSubCategory') . '",
                                        data: jQuery("form").serialize(),
                                        success: function(data){
                                            jQuery("#ProductPricingRequest_product_sub_category_id").html(data);
                                        },
                                    });'
                                )); ?>
                                <?php echo $form->error($model, 'product_sub_master_category_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model, 'product_sub_category_id', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($model, 'product_sub_category_id', $model->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $model->product_sub_master_category_id)), 'id', 'nameAndCode') : array(), array(
                                    'prompt' => '[--Select Product Sub Category--]',
                                    'onchange' => 'jQuery.ajax({
                                        type: "POST",
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
                                <?php echo $form->error($model, 'product_sub_category_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($model, 'Quantity'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($model, 'quantity'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($model, 'Catatan'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextArea($model, 'request_note', array('rows' => 5)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div style="text-align: center">
        <h2>Upload Image</h2>
        <?php echo CHtml::label('Foto Barang: ', FALSE); ?>
        <?php echo CHtml::fileField('file'); ?>
        <?php echo CHtml::error($model, 'file'); ?>
    </div>

    <hr />

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'SubmitButton')); ?>
    </div>

<?php echo IdempotentManager::generate(); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
