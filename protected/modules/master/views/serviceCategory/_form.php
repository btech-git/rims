<?php
/* @var $this ServiceCategoryController */
/* @var $model ServiceCategory */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/serviceCategory/admin'; ?>"><span class="fa fa-th-list"></span>Manage Service Categories</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New Service Category";
        } else {
            echo "Update Service Category";
        } ?>
    </h1>
    <!-- begin FORM -->
    <div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'service-category-form',
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
                            <label class="prefix"><?php echo $form->labelEx($model, 'service_type_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'), array('prompt' => '[--Select Service Type --]')); ?>
                            <?php echo $form->error($model, 'service_type_id'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'code'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'code', array('size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'code'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'name'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 30)); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>
        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'service_number'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'service_number'); ?>
                            <?php echo $form->error($model, 'service_number'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'status'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'status', array(
                                'Active' => 'Active',
                                'Inactive' => 'Inactive',
                            )); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>
        
        <hr/>
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>	