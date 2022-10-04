<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>
<?php //echo 'here1'; exit;   ?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/employee/admin'; ?>"><span class="fa fa-th-list"></span>Manage Employee</a>
    <h1>
        <?php echo "Employee Payroll"; ?>
    </h1>
    <!-- begin FORM -->

    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'employee-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>
        <hr />
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'branch_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'branch.name')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'name'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeHiddenField($employee->header, 'id'); ?>
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'name')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'id_card'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'id_card')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'local_address'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'local_address')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'province_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'province.name')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'city_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'city.name')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'home_address'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'home_address')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'home_province'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'home_province')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'home_city'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'home_city')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'sex'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'sex')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'email'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'email')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'driving_license'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'driving_license')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'skills'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($employee->header, 'skills')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>

            <div class="small-12 medium-6 columns">
                <div class="row">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'salary_type'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($employee->header, 'salary_type'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><p style="color:#c00;"><?php echo "Basic Salary* Rp"; ?></p></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($employee->header, 'basic_salary'); ?>
                        </div>
                    </div>
                </div>
                    
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($employee->header, 'payment_type'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($employee->header, 'payment_type'); ?>
                        </div>
                    </div>
                </div> 

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Banks</label>
                            </div>
                            
                            <div class="small-8 columns">
                                <?php echo CHtml::button('+', array(
                                    'id' => 'detail-bank-button',
                                    'name' => 'DetailBanks',
                                    'onclick' => 'jQuery("#bank-dialog").dialog("open"); return false;'
                                )); ?>
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'bank-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Bank',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'bank-grid',
                                    'dataProvider' => $bankDataProvider,
                                    'filter' => $bank,
                                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                    'pager' => array(
                                        'cssFile' => false,
                                        'header' => '',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#bank-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            //dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxHtmlAddBankDetail', array('id' => $employee->header->id, 'bankId' => '')) . '"+$.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(html) {
                                                $("#bank").html(html);
                                            },
                                        });

                                        $("#bank-grid").find("tr.selected").each(function(){
                                            $(this).removeClass( "selected" );
                                        });
                                    }',
                                    'columns' => array(
                                        'code',
                                        'name'
                                    ),
                                )); ?>
                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field" id="bank">
                        <div class="row collapse">
                            <?php $this->renderPartial('_detailBank', array('employee' => $employee)); ?>
                        </div>
                    </div>


                    <!-- Deduction details-->
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Deduction</label>
                            </div>
                            
                            <div class="small-8 columns">
                                <?php echo CHtml::button('+', array(
                                    'id' => 'detail-deduction-button',
                                    'name' => 'Detaildeductions',
                                    'onclick' => 'jQuery("#deduction-dialog").dialog("open"); return false;'
                                )); ?>
                                
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'deduction-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Deduction',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'deduction-grid',
                                    'dataProvider' => $deductionDataProvider,
                                    'filter' => $deduction,
                                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                    'pager' => array(
                                        'cssFile' => false,
                                        'header' => '',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#deduction-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                        //dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxHtmlAddDeductionDetail', array('id' => $employee->header->id, 'deductionId' => '')) . '"+$.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(html) {
                                                $("#deduction").html(html);
                                            },
                                        });
                                        
                                        $("#deduction-grid").find("tr.selected").each(function(){
                                            $(this).removeClass( "selected" );
                                        });
                                    }',
                                    'columns' => array(
                                        'id',
                                        'name',
                                        'amount'
                                    ),
                                )); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field" id="deduction">
                        <div class="row collapse">
                            <?php $this->renderPartial('_detail_deduction', array('employee' => $employee)); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>		 
                    <!-- end of Deduction details-->

                    <!-- incentives details-->
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Incentive</label>
                            </div>
                            
                            <div class="small-8 columns">
                                <?php echo CHtml::button('+', array(
                                    'id' => 'detail-incentive-button',
                                    'name' => 'Detailincentives',
                                    'onclick' => 'jQuery("#incentive-dialog").dialog("open"); return false;'
                                )); ?>
                                
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'incentive-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Incentive',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'incentive-grid',
                                    'dataProvider' => $incentiveDataProvider,
                                    'filter' => $incentive,
                                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                    'pager' => array(
                                        'cssFile' => false,
                                        'header' => '',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#incentive-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            //dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxHtmlAddIncentiveDetail', array('id' => $employee->header->id, 'incentiveId' => '')) . '"+$.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(html) {
                                                $("#incentive").html(html);
                                            },
                                        });
                                        
                                        $("#incentive-grid").find("tr.selected").each(function(){
                                            $(this).removeClass( "selected" );
                                        });
                                    }',
                                    'columns' => array(
                                        'id',
                                        'name',
                                        'amount'
                                    ),
                                )); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field" id="incentive">
                        <div class="row collapse">
                            <?php $this->renderPartial('_detailIncentive', array('employee' => $employee)); ?>
                        </div>
                    </div>
                    <!-- end of incentives details-->
                    <!-- end RIGHT -->
                </div>
            </div>
            
            <hr />
            
            <div class="field buttons text-center">
                <?php echo CHtml::submitButton($employee->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
            </div>
            <?php $this->endWidget('CActiveForm'); ?>
        </div>
    </div>
</div>
<!-- end of form-->