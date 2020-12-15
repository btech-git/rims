<?php
Yii::app()->clientScript->registerScript('userRoles', "
    function checkRoles(number, start, end) {
        if ($('#" . CHtml::activeId($model, 'roles') . "_' + number).attr('checked') || $('#" . CHtml::activeId($model, 'roles') . "_' + number).attr('disabled')) {
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
        checkRoles(0, 1, 93);
        checkRoles(1, 2, 93);
        checkRoles(2, 3, 14);
        checkRoles(3, 4, 4);
        checkRoles(5, 6, 6);
        checkRoles(8, 9, 9);
        checkRoles(10, 11, 11);
        checkRoles(12, 13, 13);
        checkRoles(14, 15, 15);
        checkRoles(16, 17, 17);
        checkRoles(18, 19, 19);
        checkRoles(20, 21, 21);
        checkRoles(22, 23, 23);
        checkRoles(24, 25, 25);
        checkRoles(26, 27, 27);
        checkRoles(28, 29, 29);
        checkRoles(30, 31, 31);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 31);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 31);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 31);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_3').click(function(){
        checkRoles(3, 4, 4);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_5').click(function(){
        checkRoles(5, 6, 6);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_8').click(function(){
        checkRoles(8, 9, 9);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_10').click(function(){
        checkRoles(10, 11, 11);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_12').click(function(){
        checkRoles(12, 13, 13);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_14').click(function(){
        checkRoles(14, 15, 15);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_16').click(function(){
        checkRoles(16, 17, 17);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_18').click(function(){
        checkRoles(18, 19, 19);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_20').click(function(){
        checkRoles(20, 21, 21);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_22').click(function(){
        checkRoles(22, 23, 23);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_24').click(function(){
        checkRoles(24, 25, 25);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_26').click(function(){
        checkRoles(26, 27, 27);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_28').click(function(){
        checkRoles(28, 29, 29);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_30').click(function(){
        checkRoles(30, 31, 31);
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