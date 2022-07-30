<?php
/* @var $this ServiceStandardPricelistController */
/* @var $model ServiceStandardPricelist */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/serviceStandardPricelist/admin'; ?>"><span class="fa fa-th-list"></span>Manage Service Pricelist</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New Standard Service Pricelist";
        } else {
            echo "Update Standard Service Pricelist";
        } ?>
    </h1>
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'service-standard-pricelist-form',
            'enableAjaxValidation' => false,
        )); ?>

        <hr />
        
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'service_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'service_id', CHtml::listData(Service::model()->findAll(), 'id', 'name'), array(
                                'prompt' => '[--Select Service--]', 
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetServiceCategory') . '" ,
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        console.log(data);
                                        jQuery("#Service_service_category_id").html(data);
                                        jQuery("#Service_code").val(" ");
                                    },
                                });'
                            )); ?>
                            <?php echo $form->error($model, 'service_id'); ?>
                        </div>
                    </div>
                </div>		
                <?php $servicePrice = GeneralStandardValue::model()->findByPK(1); ?>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'difficulty'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'difficulty', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $servicePrice->difficulty : $model->difficulty
                            )); ?>
                            <?php echo $form->error($model, 'difficulty'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'difficulty_value'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'difficulty_value', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $servicePrice->difficulty_value : $model->difficulty_value
                            )); ?>
                            <?php echo $form->error($model, 'difficulty_value'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'regular'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'regular', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $servicePrice->regular : $model->regular
                            )); ?>
                            <?php echo $form->error($model, 'regular'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'luxury'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'luxury', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $servicePrice->luxury : $model->luxury
                            )); ?>
                            <?php echo $form->error($model, 'luxury'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'luxury_value'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'luxury_value', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $servicePrice->luxury_value : $model->luxury_value
                            )); ?>
                            <?php echo $form->error($model, 'luxury_value'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'luxury_calc'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'luxury_calc', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $servicePrice->luxury_calc : $model->luxury_calc
                            )); ?>
                            <?php echo $form->error($model, 'luxury_calc'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'standard_rate_per_hour'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php $standardRate = GeneralStandardFr::model()->findByPK(1); ?>
                            <?php echo $form->textField($model, 'standard_rate_per_hour', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $standardRate->flat_rate : $model->standard_rate_per_hour
                            )); ?>
                            <?php echo $form->error($model, 'standard_rate_per_hour'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'flat_rate_hour'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'flat_rate_hour', array(
                                'size' => 10, 
                                'maxlength' => 10, 
//                                'value' => $model->isNewRecord ? $servicePrice->flat_rate_hour : $model->flat_rate_hour
                            )); ?>
                            <?php echo $form->error($model, 'flat_rate_hour'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'price'); ?></label>
                        </div>

                        <div class="small-8 columns">
                            <div class="row collapse">
                                <div class="small-2 columns">
                                    <?php echo CHtml::button('Count', array(
                                        'id' => 'count',
                                        'onclick' => '
                                            var diff = +$("#ServiceStandardPricelist_difficulty_value").val();
                                            var lux = +$("#ServiceStandardPricelist_luxury_calc").val();
                                            var standard = +$("#ServiceStandardPricelist_standard_rate_per_hour").val();
                                            var fr = +$("#ServiceStandardPricelist_flat_rate_hour").val();
                                            $.ajax({
                                                type: "POST",
                                                url: "' . CController::createUrl('ajaxGetPrice', array()) . '/diff/" +diff+"/lux/"+lux+"/standard/"+standard+"/fr/"+fr,
                                                data: $("form").serialize(),
                                                dataType: "json",
                                                success: function(data) {
                                                    console.log(data.diff);
                                                    console.log(data.lux);
                                                    console.log(data.standard);
                                                    console.log(data.fr);
                                                    console.log(data.price);
                                                    $("#ServiceStandardPricelist_price").val(data.price);
                                                },

                                            });
                                        '	
                                    )); ?>
                                </div>
                                
                                <div class="small-10 columns">
                                    <?php echo $form->textField($model, 'price', array('size' => 10, 'maxlength' => 10)); ?>
                                    <?php echo $form->error($model, 'price'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'common_price'); ?></label>
                        </div>

                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'common_price', array('size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'common_price'); ?>
                        </div>
                    </div>
                </div>		
            </div>
        </div>
        <hr />

        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>

<?php $this->endWidget(); ?>

    </div><!-- form -->