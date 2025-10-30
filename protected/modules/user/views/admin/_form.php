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
        checkRoles(0, 1, 479);
        checkRoles(1, 2, 479);
        checkRoles(2, 3, 7);
        checkRoles(8, 9, 29);
        checkRoles(30, 31, 40);
        checkRoles(41, 42, 55);
        checkRoles(56, 57, 66);
        checkRoles(67, 68, 77);
        checkRoles(78, 79, 116);
        checkRoles(117, 118, 143);
        checkRoles(144, 145, 156);
        checkRoles(157, 158, 162);
        checkRoles(163, 164, 183);
        checkRoles(184, 185, 269);
        checkRoles(270, 271, 314);
        checkRoles(315, 316, 335);
        checkRoles(336, 337, 384);
        checkRoles(385, 386, 433);
        checkRoles(434, 435, 466);
        checkRoles(467, 468, 479);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 479);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 479);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 7);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_8').click(function(){
        checkRoles(8, 9, 29);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_30').click(function(){
        checkRoles(30, 31, 40);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_41').click(function(){
        checkRoles(41, 42, 55);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_56').click(function(){
        checkRoles(56, 57, 66);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_67').click(function(){
        checkRoles(67, 68, 77);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_78').click(function(){
        checkRoles(78, 79, 116);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_117').click(function(){
        checkRoles(117, 118, 143);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_144').click(function(){
        checkRoles(144, 145, 156);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_157').click(function(){
        checkRoles(157, 158, 162);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_163').click(function(){
        checkRoles(163, 164, 183);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_184').click(function(){
        checkRoles(184, 185, 269);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_270').click(function(){
        checkRoles(270, 271, 314);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_315').click(function(){
        checkRoles(315, 316, 335);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_336').click(function(){
        checkRoles(336, 337, 384);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_385').click(function(){
        checkRoles(385, 386, 433);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_434').click(function(){
        checkRoles(434, 435, 466);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_467').click(function(){
        checkRoles(467, 468, 479);
    });
	
    $('#" . CHtml::activeId($model, 'is_main_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 2; i <= 467; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#main-role-panel').show();
            }
        } else {
            for (i = 2; i <= 467; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('checked');
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).attr('disabled', true);
                $('#main-role-panel').hide();
            }
        }
    });
    
    $('#" . CHtml::activeId($model, 'is_front_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 467; i <= 479; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#front-role-panel').show();
            }
        } else {
            for (i = 467; i <= 479; i++) {
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