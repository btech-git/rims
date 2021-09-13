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

    $(document).ready(function(){
        checkRoles(0, 1, 100);
        checkRoles(1, 2, 100);
        checkRoles(2, 3, 6);
        checkRoles(7, 8, 21);
        checkRoles(22, 23, 28);
        checkRoles(29, 30, 35);
        checkRoles(36, 40, 42);
        checkRoles(43, 44, 49);
        checkRoles(50, 51, 74);
        checkRoles(75, 76, 81);
        checkRoles(75, 76, 81);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 100);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 100);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 14);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_15').click(function(){
        checkRoles(15, 16, 21);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_22').click(function(){
        checkRoles(22, 23, 28);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_29').click(function(){
        checkRoles(29, 30, 38);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_39').click(function(){
        checkRoles(39, 40, 63);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_64').click(function(){
        checkRoles(64, 65, 79);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_80').click(function(){
        checkRoles(80, 81, 86);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_87').click(function(){
        checkRoles(87, 88, 89);
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