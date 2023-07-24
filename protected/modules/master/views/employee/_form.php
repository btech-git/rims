<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>
<?php //echo 'here1'; exit;  ?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/employee/admin'; ?>"><span class="fa fa-th-list"></span>Manage Employee</a>
    <h1>
        <?php
        if ($employee->header->isNewRecord) {
            echo "New Employee";
        } else {
            echo "Update Employee";
        }
        ?>
    </h1>
    <!-- begin FORM -->

    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'employee-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        )); ?>
        <hr />
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($employee->header); ?>
        <?php //echo $form->errorSummary($employee->phoneDetails); ?>
        <?php //echo $form->errorSummary($employee->mobileDetails); ?>

        <fieldset>
            <h3>Data Karyawan</h3>
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'code'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'code', array('size' => 60, 'maxlength' => 100, 'style' => 'text-transform: capitalize')); ?>
                                <?php echo $form->error($employee->header, 'code'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($employee->header, 'recruitment_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                    'model' => $employee->header,
                                    'attribute' => "recruitment_date",
                                    'options'=>array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth'=>true,
                                        'changeYear'=>true,
        //                                'yearRange'=>'1900:2020'
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly' => true,
                                    ),
                                )); ?>
                                <?php echo $form->error($employee->header, 'recruitment_date'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'name'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'name', array('size' => 60, 'maxlength' => 100, 'style' => 'text-transform: capitalize')); ?>
                                <?php echo $form->error($employee->header, 'name'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'employee_head_id'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'employee_head_id', CHtml::listData(Employee::model()->findAll(), 'id', 'name'), array('empty' => '-- Select Atasan --')); ?>
                                <?php echo $form->error($employee->header, 'employee_head_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'employment_type'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'employment_type', array(
                                    'Tetap' => 'Tetap',
                                    'Probation' => 'Probation',
                                )); ?>
                                <?php echo $form->error($employee->header, 'employment_type'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'branch_id'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                    'prompt' => '[--Select Branch--]',
                                    'onchange' => ''
                                )); ?>
                                <?php echo $form->error($employee->header, 'branch_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'division_id'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'division_id', CHtml::listData(Division::model()->findAll(), 'id', 'name'), array(
                                    'prompt' => '[--Select Division--]',
                                )); ?>
                                <?php echo $form->error($employee->header, 'division_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'position_id'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'position_id', CHtml::listData(Position::model()->findAll(), 'id', 'name'), array(
                                    'prompt' => '[--Select Position--]',
                                )); ?>
                                <?php echo $form->error($employee->header, 'position_id'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'level_id'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'level_id', CHtml::listData(Level::model()->findAll(), 'id', 'name'), array(
                                    'prompt' => '[--Select Level--]',
                                )); ?>
                                <?php echo $form->error($employee->header, 'level_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'Kuota Cuti'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'onleave_allocation'); ?>
                                <?php echo $form->error($employee->header, 'onleave_allocation'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'off_day'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'off_day', array(
                                    'Senin' => 'Senin',
                                    'Selasa' => 'Selasa', 
                                    'Rabu' => 'Rabu', 
                                    'Kamis' => 'Kamis', 
                                    'Jumat' => 'Jumat', 
                                    'Sabtu' => 'Sabtu', 
                                    'Minggu' => 'Minggu'
                                ), array('prompt' => '[--Select Day Off--]')); ?>
                                <?php echo $form->error($employee->header, 'off_day'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <h2>Information</h2>
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'birth_place'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'birth_place', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'birth_place'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($employee->header, 'birth_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                    'model' => $employee->header,
                                    'attribute' => "birth_date",
                                    'options'=>array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'yearRange'=>'-70:+0',
                                        'changeMonth'=>true,
                                        'changeYear'=>true,
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly' => true,
                                    ),
                                )); ?>
                                <?php echo $form->error($employee->header, 'birth_date'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'id_card'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'id_card', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'id_card'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'family_card_number'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'family_card_number', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'family_card_number'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'mother_name'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'mother_name', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'mother_name'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'sex'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'sex', array(
                                    'Laki-laki' => 'Laki-laki',
                                    'Perempuan' => 'Perempuan',
                                )); ?>
                                <?php echo $form->error($employee->header, 'sex'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'skills'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textArea($employee->header, 'skills', array('rows' => 6, 'cols' => 50)); ?>
                                <?php echo $form->error($employee->header, 'skills'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'religion'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'religion', array(
                                    'Islam' => 'Islam',
                                    'Kristen' => 'Kristen',
                                    'Katolik' => 'Katolik',
                                    'Hindu' => 'Hindu',
                                    'Budha' => 'Budha',
                                )); ?>
                                <?php echo $form->error($employee->header, 'religion'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'marriage_status'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'marriage_status', array(
                                    'TK' => 'TK',
                                    'K0' => 'K0', 
                                    'K1' => 'K1', 
                                    'K2' => 'K2', 
                                    'K3' => 'K3', 
                                ), array('prompt' => '[--Select Status--]')); ?>
                                <?php echo $form->error($employee->header, 'marriage_status'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'home_address'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textArea($employee->header, 'home_address', array('rows' => 6, 'cols' => 50)); ?>
                                <?php echo $form->error($employee->header, 'home_address'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'local_address'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textArea($employee->header, 'local_address', array('rows' => 6, 'cols' => 50)); ?>
                                <?php echo $form->error($employee->header, 'local_address'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <h2>Contact Information</h2>
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'mobile_phone_number'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'mobile_phone_number', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'mobile_phone_number'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'email'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'email', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'email'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'school_degree'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'school_degree', array(
                                    'SD' => 'SD',
                                    'SMP' => 'SMP',
                                    'SMA' => 'SMA',
                                    'D1' => 'D1',
                                    'D2' => 'D2',
                                    'D3' => 'D3',
                                    'D4' => 'D4',
                                    'S1' => 'S1',
                                    'S2' => 'S2',
                                )); ?>
                                <?php echo $form->error($employee->header, 'school_degree'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'school_subject'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'school_subject', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'school_subject'); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'bank_name'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'bank_name', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'bank_name'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'bank_account_number'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'bank_account_number', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'bank_account_number'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'tax_registration_number'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'tax_registration_number', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'tax_registration_number'); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </fieldset>

        <fieldset>
            <h2>Kontak Darurat</h2>
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'emergency_contact_name'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'emergency_contact_name', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'emergency_contact_name'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'emergency_contact_relationship'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownList($employee->header, 'emergency_contact_relationship', array(
                                    'Orang Tua' => 'Orang Tua',
                                    'Kakak' => 'Kakak', 
                                    'Adik' => 'Adik', 
                                    'Pasangan' => 'Pasangan', 
                                    'Saudara' => 'Saudara', 
                                ), array('prompt' => '[--Select Hubungan--]')); ?>
                                <?php echo $form->error($employee->header, 'emergency_contact_relationship'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'emergency_contact_mobile_phone'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($employee->header, 'emergency_contact_mobile_phone', array('size' => 20, 'maxlength' => 60)); ?>
                                <?php echo $form->error($employee->header, 'emergency_contact_mobile_phone'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($employee->header, 'emergency_contact_address'); ?></label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textArea($employee->header, 'emergency_contact_address', array('rows' => 6, 'cols' => 50)); ?>
                                <?php echo $form->error($employee->header, 'emergency_contact_address'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        
        <hr />
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($employee->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>
        <?php $this->endWidget('CActiveForm'); ?>
    </div>
</div>

        <!-- end of form-->