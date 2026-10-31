<div class="clearfix page-action">
    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'technical-report-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($technicalReport->header); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'document_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'document_number'); ?>
                            <?php echo $form->error($technicalReport->header, 'document_number'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'report_version', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'report_version'); ?>
                            <?php echo $form->error($technicalReport->header, 'report_version'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'date_effective', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $technicalReport->header,
                                'attribute' => "date_effective",
                                'options' => array(
                                    'minDate' => '-7W',
                                    'maxDate' => '+6M',
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                ),
                            )); ?>
                            <?php echo $form->error($technicalReport->header, 'date_effective'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'dealer_name', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'dealer_name'); ?>
                            <?php echo $form->error($technicalReport->header, 'dealer_name'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'dealer_code', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'dealer_code'); ?>
                            <?php echo $form->error($technicalReport->header, 'dealer_code'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'warranty_claim_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'warranty_claim_number'); ?>
                            <?php echo $form->error($technicalReport->header, 'warranty_claim_number'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="medium-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'vehicle_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-8 columns">
                            <?php echo CHtml::activeDropDownlist($technicalReport->header, 'vehicle_id', CHtml::listData(Vehicle::model()->findAll(array(
                                "condition" => "car_make_id = 72",
                                "order" => "car_model_id ASC, frame_number ASC",
                            )), "id", "technicalVehicleName"), array(
                                "empty" => "-- All --",
                            )); ?>
                            <?php echo $form->error($technicalReport->header, 'vehicle_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="medium-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'vehicle_mileage', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'vehicle_mileage'); ?>
                            <?php echo $form->error($technicalReport->header, 'vehicle_mileage'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="medium-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'warranty_start_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $technicalReport->header,
                                'attribute' => "warranty_start_date",
                                'options' => array(
                                    'minDate' => '-7W',
                                    'maxDate' => '+6M',
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                ),
                            )); ?>
                            <?php echo $form->error($technicalReport->header, 'warranty_start_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="medium-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'repair_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $technicalReport->header,
                                'attribute' => "repair_date",
                                'options' => array(
                                    'minDate' => '-7W',
                                    'maxDate' => '+6M',
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                ),
                            )); ?>
                            <?php echo $form->error($technicalReport->header, 'repair_date'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'main_part_name', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'main_part_name'); ?>
                            <?php echo $form->error($technicalReport->header, 'main_part_name'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'main_part_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'main_part_number'); ?>
                            <?php echo $form->error($technicalReport->header, 'main_part_number'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="medium-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'report_issue', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-8 columns">
                            <?php echo $form->textArea($technicalReport->header, 'report_issue', array('rows' => 5, 'cols' => 50)); ?>
                            <?php echo $form->error($technicalReport->header, 'report_issue'); ?>
                        </div>
                    </div>
                </div>
        
                <div class="field">
                    <div class="row collapse">
                        <div class="medium-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'failure_phenomenon', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-8 columns">
                            <?php echo $form->textArea($technicalReport->header, 'failure_phenomenon', array('rows' => 5, 'cols' => 50)); ?>
                            <?php echo $form->error($technicalReport->header, 'failure_phenomenon'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'after_repair_video', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'after_repair_video'); ?>
                            <?php echo $form->error($technicalReport->header, 'after_repair_video'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($technicalReport->header, 'failure_symptom_video', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($technicalReport->header, 'failure_symptom_video'); ?>
                            <?php echo $form->error($technicalReport->header, 'failure_symptom_video'); ?>
                        </div>
                    </div>
                </div>

                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?> 
                </div>
                <?php echo IdempotentManager::generate(); ?>

            </div>
        </div>
        
        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        Attach Files (Upload size max 10MB) : 
                        <?php $this->widget('CMultiFileUpload', array(
                            'model' => $technicalReport->header,
                            'attribute' => 'failedPartImages',
                            'accept' => 'jpg|jpeg|png|pdf',
                            'denied' => 'Only jpg, jpeg, png and pdf are allowed',
                            'max' => 10,
                            'remove' => '[x]',
                            'duplicate' => 'Already Selected',
                            'options' => array(
                                'afterFileSelect' => 'function(e ,v ,m){
                                    var fileSize = e.files[0].size;
                                    if (fileSize > 11*1024*1024) {
                                        alert("Exceeds file upload limit 10MB");
                                        $(".MultiFile-remove").click();
                                    }                      
                                    return true;
                                }',
                            ),
                        )); ?>
                        
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        Attach Files (Upload size max 10MB) : 
                        <?php $this->widget('CMultiFileUpload', array(
                            'model' => $technicalReport->header,
                            'attribute' => 'newPartImages',
                            'accept' => 'jpg|jpeg|png|pdf',
                            'denied' => 'Only jpg, jpeg, png and pdf are allowed',
                            'max' => 10,
                            'remove' => '[x]',
                            'duplicate' => 'Already Selected',
                            'options' => array(
                                'afterFileSelect' => 'function(e ,v ,m){
                                    var fileSize = e.files[0].size;
                                    if (fileSize > 11*1024*1024) {
                                        alert("Exceeds file upload limit 10MB");
                                        $(".MultiFile-remove").click();
                                    }                      
                                    return true;
                                }',
                            ),
                        )); ?>
                        
                    </div>
                </div>
            </div>
            
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        Attach Files (Upload size max 10MB) : 
                        <?php $this->widget('CMultiFileUpload', array(
                            'model' => $technicalReport->header,
                            'attribute' => 'failedPartSerialNumberImages',
                            'accept' => 'jpg|jpeg|png|pdf',
                            'denied' => 'Only jpg, jpeg, png and pdf are allowed',
                            'max' => 10,
                            'remove' => '[x]',
                            'duplicate' => 'Already Selected',
                            'options' => array(
                                'afterFileSelect' => 'function(e ,v ,m){
                                    var fileSize = e.files[0].size;
                                    if (fileSize > 11*1024*1024) {
                                        alert("Exceeds file upload limit 10MB");
                                        $(".MultiFile-remove").click();
                                    }                      
                                    return true;
                                }',
                            ),
                        )); ?>
                        
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        Attach Files (Upload size max 10MB) : 
                        <?php $this->widget('CMultiFileUpload', array(
                            'model' => $technicalReport->header,
                            'attribute' => 'odometerImages',
                            'accept' => 'jpg|jpeg|png|pdf',
                            'denied' => 'Only jpg, jpeg, png and pdf are allowed',
                            'max' => 10,
                            'remove' => '[x]',
                            'duplicate' => 'Already Selected',
                            'options' => array(
                                'afterFileSelect' => 'function(e ,v ,m){
                                    var fileSize = e.files[0].size;
                                    if (fileSize > 11*1024*1024) {
                                        alert("Exceeds file upload limit 10MB");
                                        $(".MultiFile-remove").click();
                                    }                      
                                    return true;
                                }',
                            ),
                        )); ?>
                        
                    </div>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div><!-- form -->

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>