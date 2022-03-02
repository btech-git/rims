<?php
Yii::app()->clientScript->registerScript('userRoles', "
    function checkRoles(number, start, end) {
        if ($('#" . CHtml::activeId($model, 'roles') . "_' + number).prop('checked') || $('#" . CHtml::activeId($model, 'roles') . "_' + number).prop('disabled')) {
            for (i = start; i <= end; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('checked');
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).attr('disabled', true);
            }
        } else {
            for (i = start; i <= end; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
            }
        }
    }

    $(document).ready(function(){
        checkRoles(0, 1, 286);
        checkRoles(1, 2, 286);
        checkRoles(2, 3, 6);
        checkRoles(7, 8, 16);
        checkRoles(17, 18, 23);
        checkRoles(24, 25, 29);
        checkRoles(30, 31, 36);
        checkRoles(37, 38, 43);
        checkRoles(44, 45, 68);
        checkRoles(69, 70, 86);
        checkRoles(87, 88, 93);
        checkRoles(94, 95, 111);
        checkRoles(112, 113, 133);
        checkRoles(134, 135, 176);
        checkRoles(177, 178, 192);
        checkRoles(193, 194, 226);
        checkRoles(227, 228, 263);
        checkRoles(264, 265, 285);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 286);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 286);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 6);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_7').click(function(){
        checkRoles(7, 8, 16);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_17').click(function(){
        checkRoles(17, 18, 23);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_24').click(function(){
        checkRoles(24, 25, 29);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_30').click(function(){
        checkRoles(30, 31, 36);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_37').click(function(){
        checkRoles(37, 38, 43);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_44').click(function(){
        checkRoles(44, 45, 68);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_69').click(function(){
        checkRoles(69, 70, 86);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_87').click(function(){
        checkRoles(87, 88, 93);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_94').click(function(){
        checkRoles(94, 95, 111);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_112').click(function(){
        checkRoles(112, 113, 133);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_134').click(function(){
        checkRoles(134, 135, 176);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_177').click(function(){
        checkRoles(177, 178, 192);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_193').click(function(){
        checkRoles(193, 194, 226);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_227').click(function(){
        checkRoles(227, 228, 263);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_264').click(function(){
        checkRoles(264, 265, 285);
    });
");
?>

<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/user/admin'; ?>"><span class="fa fa-th-list"></span>Manage User</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New User";
        } else {
            echo "Update User";
        } ?>
    </h1>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'form'),
    )); ?>
    
    <hr />
    
    <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary(array($model)); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'username', array('class' => 'prefix')); ?>
                    </div>
                    <?php if ($model->isNewRecord): ?>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'username', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'username'); ?>
                        </div>
                    <?php else: ?>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'username'); ?>
                            <?php echo CHtml::encode(CHtml::value($model, 'username')); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($model->isNewRecord): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'password', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'email', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                </div>
            </div>

<!--            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php /*echo $form->labelEx($model, 'superuser', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
                        <?php echo $form->error($model, 'superuser');*/ ?>
                    </div>
                </div>
            </div>-->

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'branch_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlUpdateEmployeeSelect'),
                                'update' => '#employee_list',
                            )),
                        )); ?>
                        <?php echo $form->error($model, 'branch_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo 'Employee'; ?>
                    </div>
                    <div class="small-8 columns">
                        <?php if ($model->isNewRecord): ?>
                            <?php $this->renderPartial('_employeeSelect', array(
                                'model'=>$model,
                                'employees' => $employees,
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($model, 'employee.name')); ?>
                        <?php endif; ?>
                        <?php echo CHtml::error($model, 'employee_id'); ?>
                    </div>
                </div>
            </div>

            <br />

            <div class="row">
                <fieldset style="width: 100%">
                    <legend><span style="font-weight: bold">Roles</span></legend>
                    <?php $this->renderPartial('_role', array('model' => $model, 'counter' => 0)); ?>
                </fieldset>
            </div>
        </div>
    </div>

    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'button cbutton')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->