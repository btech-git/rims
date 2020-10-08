<?php
/* @var $this CoaController */
/* @var $model Coa */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'coa-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">
            <?php if (!$model->isNewRecord): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model,'code'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'code',array('readOnly' => true)); ?>
                            <?php echo $form->error($model,'code'); ?>
                        </div>
                    </div>
                </div>		
            <?php endif; ?>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model,'COA Grouping'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'coa_id', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_id' => null)),'id','name'), array('empty' => '-- Pilih Group --')); ?>
                        <?php echo $form->error($model, 'coa_id'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model,'name'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
                        <?php echo $form->error($model,'name'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model,'coa_sub_category_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model,'coa_sub_category_id',CHtml::listData(CoaSubCategory::model()->findAll(),'id','name')); ?>
                        <?php echo $form->error($model,'coa_sub_category_id'); ?>
                    </div>
                </div>
            </div>	
        
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model,'normal_balance'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model,'normal_balance',array('DEBIT'=>'DEBIT','KREDIT'=>'KREDIT')); ?>
                        <?php echo $form->error($model,'normal_balance'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model,'status'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model,'status',array(
                            'Approved'=>'Approved',
                            'Not Approved'=>'Not Approved'
                        )); ?>
                        <?php echo $form->error($model,'status'); ?>
                    </div>
                </div>
            </div>	

            <div class="field buttons text-center">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
            </div>
        </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->