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
        checkRoles(0, 1, 363);
        checkRoles(1, 2, 363);
        checkRoles(2, 3, 7);
        checkRoles(8, 9, 22);
        checkRoles(23, 24, 31);
        checkRoles(32, 33, 43);
        checkRoles(44, 45, 52);
        checkRoles(53, 54, 61);
        checkRoles(62, 63, 92);
        checkRoles(93, 94, 115);
        checkRoles(116, 117, 128);
        checkRoles(129, 130, 134);
        checkRoles(135, 136, 150);
        checkRoles(151, 152, 201);
        checkRoles(202, 203, 235);
        checkRoles(236, 237, 251);
        checkRoles(252, 253, 288);
        checkRoles(290, 291, 325);
        checkRoles(326, 327, 350);
        checkRoles(351, 352, 363);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 363);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 363);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 7);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_8').click(function(){
        checkRoles(8, 9, 22);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_23').click(function(){
        checkRoles(23, 24, 31);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_32').click(function(){
        checkRoles(32, 33, 43);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_44').click(function(){
        checkRoles(44, 45, 52);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_53').click(function(){
        checkRoles(53, 54, 61);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_62').click(function(){
        checkRoles(62, 63, 92);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_93').click(function(){
        checkRoles(93, 94, 115);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_116').click(function(){
        checkRoles(116, 117, 128);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_129').click(function(){
        checkRoles(129, 130, 134);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_135').click(function(){
        checkRoles(135, 136, 150);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_151').click(function(){
        checkRoles(151, 152, 201);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_202').click(function(){
        checkRoles(202, 203, 235);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_236').click(function(){
        checkRoles(236, 237, 251);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_252').click(function(){
        checkRoles(252, 253, 288);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_289').click(function(){
        checkRoles(289, 300, 325);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_326').click(function(){
        checkRoles(326, 327, 350);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_351').click(function(){
        checkRoles(351, 352, 363);
    });
    
    $('#" . CHtml::activeId($model, 'is_main_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 2; i <= 350; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#main-role-panel').show();
            }
        } else {
            for (i = 2; i <= 350; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('checked');
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).attr('disabled', true);
                $('#main-role-panel').hide();
            }
        }
    });
    
    $('#" . CHtml::activeId($model, 'is_front_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 351; i <= 363; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#front-role-panel').show();
            }
        } else {
            for (i = 351; i <= 363; i++) {
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
                        <?php echo CHtml::activeCheckBox($model, 'is_main_access'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Front Access', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeCheckBox($model, 'is_front_access'); ?>
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