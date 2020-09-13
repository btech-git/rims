<?php
/* @var $this VehicleCarMakeController */
/* @var $model VehicleCarMake */
/* @var $form CActiveForm */
?>


<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/vehicleCarMake/admin'; ?>"><span class="fa fa-th-list"></span>Manage Vehicle Car Makes</a>
    <h1><?php if ($model->isNewRecord) {
    echo "New Vehicle Car Make";
} else {
    echo "Update Vehicle Car Make";
} ?></h1>
    <!-- begin FORM -->
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'vehicle-car-make-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>
        <hr>
        <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php //echo $form->errorSummary($model);  ?>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'name'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
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
                            <label class="prefix"><?php echo $form->labelEx($model, 'service_difficulty_rate'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'service_difficulty_rate', array(
                                '1' => 'Easy',
                                '2' => 'Medium',
                                '3' => 'Hard',
                                '4' => 'Luxury',
                            ), array('prompt' => 'Select',)); ?>
                            <?php echo $form->error($model, 'service_difficulty_rate'); ?>
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
                            ), array('prompt' => 'Select',)); ?>
                            <?php echo $form->error($model, 'status'); ?>
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