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
        checkRoles(0, 1, 440);
        checkRoles(1, 2, 440);
        checkRoles(2, 3, 7);
        checkRoles(8, 9, 25);
        checkRoles(26, 27, 36);
        checkRoles(37, 38, 51);
        checkRoles(52, 53, 62);
        checkRoles(63, 64, 73);
        checkRoles(74, 75, 112);
        checkRoles(113, 114, 139);
        checkRoles(140, 141, 152);
        checkRoles(153, 154, 158);
        checkRoles(159, 160, 179);
        checkRoles(180, 181, 230);
        checkRoles(231, 232, 275);
        checkRoles(276, 277, 296);
        checkRoles(297, 298, 345);
        checkRoles(346, 347, 394);
        checkRoles(395, 396, 427);
        checkRoles(428, 429, 440);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 440);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 440);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 7);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_8').click(function(){
        checkRoles(8, 9, 25);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_26').click(function(){
        checkRoles(26, 27, 36);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_37').click(function(){
        checkRoles(37, 38, 51);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_52').click(function(){
        checkRoles(52, 53, 62);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_63').click(function(){
        checkRoles(63, 64, 73);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_74').click(function(){
        checkRoles(74, 75, 112);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_113').click(function(){
        checkRoles(113, 114, 139);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_140').click(function(){
        checkRoles(140, 141, 152);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_153').click(function(){
        checkRoles(153, 154, 158);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_159').click(function(){
        checkRoles(159, 160, 179);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_180').click(function(){
        checkRoles(180, 181, 230);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_231').click(function(){
        checkRoles(231, 232, 275);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_276').click(function(){
        checkRoles(276, 277, 296);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_297').click(function(){
        checkRoles(297, 298, 345);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_346').click(function(){
        checkRoles(346, 347, 394);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_395').click(function(){
        checkRoles(395, 396, 427);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_428').click(function(){
        checkRoles(428, 429, 440);
    });
	
    $('#" . CHtml::activeId($model, 'is_main_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 2; i <= 427; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#main-role-panel').show();
            }
        } else {
            for (i = 2; i <= 427; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('checked');
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).attr('disabled', true);
                $('#main-role-panel').hide();
            }
        }
    });
    
    $('#" . CHtml::activeId($model, 'is_front_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 428; i <= 440; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#front-role-panel').show();
            }
        } else {
            for (i = 428; i <= 440; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('checked');
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).attr('disabled', true);
                $('#front-role-panel').hide();
            }
        }
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
        <div class="medium-12 columns">
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
                        <?php echo CHtml::activeHiddenField($model, 'employee_id'); ?>
                        <?php echo $form->labelEx($model, 'employee_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'EmployeeName',
                            'value' => CHtml::value($model, 'employee.name'),
                            'sourceUrl' => CController::createUrl('employeeCompletion'),
                            //additional javascript options for the autocomplete plugin
                            'options' => array(
                                'minLength' => '2',
                                'select' => 'js:function(event, ui) {
                                    $("#' . CHtml::activeId($model, 'employee_id') . '").val(ui.item.id);
                                }',
                            ),
                        )); ?>
                        <?php //echo CHtml::activeDropDownList($model, 'employee_id', CHtml::listData($employees, 'id', 'name'), array('empty' => '-- Pilih Employee --')); ?>
                        <?php echo CHtml::error($model, 'employee_id'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Branch Assignment', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'code'), array('empty' => '-- Pilih Branch --')); ?>
                        <?php echo CHtml::error($model, 'branch_id'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Branch Data Access', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $branches = Branch::model()->findAll(array('order' => 'code')); ?>
                        <?php $userBranches = UserBranch::model()->findAllByAttributes(array('users_id' => $model->id)); ?>
                        <?php $branchIds = array_map(function ($userBranch) { return $userBranch->branch_id; }, $userBranches); ?>
                        <?php echo CHtml::checkBoxList('BranchId[]', $branchIds, CHtml::listData($branches, 'id', 'code'), array('labelOptions'=>array('style'=>'display:inline'), 'separator'=>' ',)); ?>
                    </div>
                    <div style="color: red; font-weight: bold"><?php echo $emptyBranchErrorMessage; ?></div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Main Access', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->checkBox($model, 'is_main_access'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Front Access', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->checkBox($model, 'is_front_access'); ?>
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