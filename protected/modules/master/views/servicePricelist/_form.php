<?php
/* @var $this ServicePricelistController */
/* @var $model ServicePricelist */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/servicePricelist/admin'; ?>"><span class="fa fa-th-list"></span>Manage Service Pricelist</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New Service Pricelist";
        } else {
            echo "Update Service Pricelist";
        } ?>
    </h1>
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'service-pricelist-form',
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
                            <?php echo $form->dropDownList($model, 'service_id', CHtml::listData(Service::model()->findAll(), 'id', 'name'), array('prompt' => '[--Select Service--]'
                                    /* 'onchange'=> 'jQuery.ajax({
                                      type: "POST",
                                      //dataType: "JSON",
                                      url: "' . CController::createUrl('ajaxGetServiceCategory') . '" ,
                                      data: jQuery("form").serialize(),
                                      success: function(data){
                                      console.log(data);
                                      jQuery("#Service_service_category_id").html(data);
                                      jQuery("#Service_code").val(" ");
                                      },
                                      });' */
                            )); ?>
                            <?php echo $form->error($model, 'service_id'); ?>
                        </div>
                    </div>
                </div>		 

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'service_group_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'service_group_id', CHtml::listData(ServiceGroup::model()->findAll(array('order' => 'id ASC')), 'id', 'name'), array(
                                'prompt' => '[--Select Group--]',
                            )); ?>
                            <?php echo $form->error($model, 'service_group_id'); ?>
                        </div>
                    </div>
                </div>		
	
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'standard_flat_rate_per_hour'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php //$standardRate = GeneralStandardFr::model()->findByPK(1); ?>
                            <?php echo $form->textField($model, 'standard_flat_rate_per_hour', array('size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'standard_flat_rate_per_hour'); ?>
                        </div>
                    </div>
                </div>		
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'flat_rate_hour'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'flat_rate_hour', array('size' => 10, 'maxlength' => 10)); ?>
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
                            <?php echo $form->textField($model, 'price', array('size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'price'); ?>
                        </div>
                        <div class="small-2 columns">
                            <?php /*echo CHtml::button('Count', array(
                                'id' => 'count',
                                'onclick' => '
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
                                        $("#ServicePricelist_price").val(data.price);
                                    },
                                });
                            '));*/ ?>
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
</div>