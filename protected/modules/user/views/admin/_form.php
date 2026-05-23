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
        checkRoles(0, 1, 510);
        checkRoles(1, 2, 510);
        checkRoles(2, 3, 7);
        checkRoles(8, 9, 40);
        checkRoles(41, 42, 49);
        checkRoles(50, 51, 66);
        checkRoles(67, 68, 75);
        checkRoles(76, 77, 83);
        checkRoles(84, 85, 119);
        checkRoles(120, 121, 141);
        checkRoles(142, 143, 155);
        checkRoles(156, 157, 166);
        checkRoles(167, 168, 193);
        checkRoles(194, 195, 230);
        checkRoles(231, 232, 263);
        checkRoles(264, 265, 308);
        checkRoles(309, 310, 325);
        checkRoles(326, 327, 346);
        checkRoles(347, 348, 363);
        checkRoles(364, 365, 384);
        checkRoles(385, 386, 393);
        checkRoles(394, 395, 406);
        checkRoles(407, 408, 497);
        checkRoles(498, 499, 510);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 542);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 542);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 7);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_8').click(function(){
        checkRoles(8, 9, 40);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_41').click(function(){
        checkRoles(41, 42, 49);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_50').click(function(){
        checkRoles(50, 51, 66);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_67').click(function(){
        checkRoles(67, 68, 75);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_76').click(function(){
        checkRoles(76, 77, 83);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_84').click(function(){
        checkRoles(84, 85, 119);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_120').click(function(){
        checkRoles(120, 121, 141);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_142').click(function(){
        checkRoles(142, 143, 155);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_156').click(function(){
        checkRoles(156, 157, 166);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_167').click(function(){
        checkRoles(167, 168, 193);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_194').click(function(){
        checkRoles(194, 195, 230);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_231').click(function(){
        checkRoles(231, 232, 263);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_264').click(function(){
        checkRoles(264, 265, 308);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_309').click(function(){
        checkRoles(309, 310, 325);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_326').click(function(){
        checkRoles(326, 327, 346);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_347').click(function(){
        checkRoles(347, 348, 363);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_364').click(function(){
        checkRoles(364, 365, 384);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_385').click(function(){
        checkRoles(385, 386, 393);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_394').click(function(){
        checkRoles(394, 395, 406);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_407').click(function(){
        checkRoles(407, 408, 497);
    });
			
    $('#" . CHtml::activeId($model, 'roles') . "_498').click(function(){
        checkRoles(498, 499, 510);
    });

    $('#" . CHtml::activeId($model, 'is_main_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 2; i <= 497; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#main-role-panel').show();
            }
        } else {
            for (i = 2; i <= 497; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('checked');
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).attr('disabled', true);
                $('#main-role-panel').hide();
            }
        }
    });
    
    $('#" . CHtml::activeId($model, 'is_front_access') . "').click(function(){
        if ($(this).prop('checked')) {
            for (i = 497; i <= 510; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
                $('#front-role-panel').show();
            }
        } else {
            for (i = 497; i <= 510; i++) {
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