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
        checkRoles(0, 1, 310);
        checkRoles(1, 2, 310);
        checkRoles(2, 3, 6);
        checkRoles(7, 8, 16);
        checkRoles(17, 18, 25);
        checkRoles(26, 27, 36);
        checkRoles(37, 38, 45);
        checkRoles(46, 47, 54);
        checkRoles(55, 56, 87);
        checkRoles(88, 89, 110);
        checkRoles(111, 112, 124);
        checkRoles(125, 126, 130);
        checkRoles(131, 132, 165);
        checkRoles(166, 167, 208);
        checkRoles(209, 210, 224);
        checkRoles(225, 226, 258);
        checkRoles(259, 260, 295);
        checkRoles(296, 297, 320);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 310);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 2, 310);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 3, 6);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_7').click(function(){
        checkRoles(7, 8, 16);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_17').click(function(){
        checkRoles(17, 18, 25);
    });
	
    $('#" . CHtml::activeId($model, 'roles') . "_26').click(function(){
        checkRoles(26, 27, 36);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_37').click(function(){
        checkRoles(37, 38, 45);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_46').click(function(){
        checkRoles(46, 47, 54);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_55').click(function(){
        checkRoles(55, 56, 87);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_88').click(function(){
        checkRoles(88, 89, 110);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_111').click(function(){
        checkRoles(111, 112, 124);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_125').click(function(){
        checkRoles(125, 126, 130);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_131').click(function(){
        checkRoles(131, 132, 165);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_166').click(function(){
        checkRoles(166, 167, 208);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_209').click(function(){
        checkRoles(209, 210, 224);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_225').click(function(){
        checkRoles(225, 226, 258);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_259').click(function(){
        checkRoles(259, 260, 295);
    });
		
    $('#" . CHtml::activeId($model, 'roles') . "_296').click(function(){
        checkRoles(296, 297, 320);
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
                        <?php echo $form->labelEx($model, 'employee_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'employee_id', CHtml::listData($employees, 'id', 'name'), array('empty' => '-- Pilih Employee --')); ?>
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