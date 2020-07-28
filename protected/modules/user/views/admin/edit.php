<?php $this->breadcrumbs=array(
	$model->username=>array('profile', 'id'=>$model->id),
	(UserModule::t('Update')),
); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1><?php echo "Update User"; ?></h1>

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'user-form',
            'enableAjaxValidation'=>true,
            'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form'),
        )); ?>
            <hr />
            <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

            <?php echo $form->errorSummary(array($model)); ?>

            <div class="row">
                <div class="small-12 medium-6 columns">

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model,'username', array('class'=>'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20,'readOnly' => true)); ?>
                                <?php echo $form->error($model,'username'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model,'password', array('class'=>'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
                                <?php echo $form->error($model,'password'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model,'email', array('class'=>'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
                                <?php echo $form->error($model,'email'); ?>
                            </div>
                        </div>
                    </div>

<!--                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php /*echo $form->labelEx($model,'superuser', array('class'=>'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo ($model->status == 0) ? 'No' : ' Yes'; */?>
                            </div>
                        </div>
                    </div>-->

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php /*echo $form->labelEx($model,'status', array('class'=>'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode($model->getStatusdata()); ?>
                                <?php echo $form->error($model,'status'); */?>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model,'employee_id', array('class'=>'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($model, 'employee.name')); ?>
                                <?php //echo $form->dropDownList($model,'employee_id', CHtml::listData(Employee::model()->findAll(), 'id', 'name')); ?>
                                <?php //echo $form->error($model,'employee_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($model,'branch_id', array('class'=>'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php $branch = Branch::model()->findByPk($model->branch_id); ?>
                                <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
                                <?php //echo $form->dropDownList($model,'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name')); ?>
                                <?php //echo $form->error($model,'branch_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr />
            
            <div class="field buttons text-center">
                <?php echo CHtml::submitButton(UserModule::t('Update'), array('class'=>'button cbutton')); ?>
            </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>