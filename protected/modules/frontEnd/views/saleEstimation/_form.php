<?php
/* @var $this RegistrationTransactionController */
/* @var $saleEstimation->header RegistrationTransaction */
/* @var $form CActiveForm */
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/generalRepairRegistration/admin';?>"><span class="fa fa-th-list"></span>Manage Estimasi</a>
        <h1><?php if($saleEstimation->header->isNewRecord){ echo "New Estimasi"; }else{ echo "Update Estimasi";}?></h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'sale-estimation-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($saleEstimation->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-12 columns">
                            <h2>Transaction</h2>
                            <hr />

                            <div class="row">
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($saleEstimation->header,'transaction_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                    'model' => $saleEstimation->header,
                                                    'attribute' => "transaction_date",
                                                    'options' => array(
                                                        'dateFormat' => 'yy-mm-dd',
                                                        'changeMonth' => true,
                                                        'changeYear' => true,
                                                    ),
                                                    'htmlOptions' => array(
                                                        'readonly' => true,
                                                    ),
                                                )); ?>
                                                <?php echo $form->error($saleEstimation->header,'transaction_date'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($saleEstimation->header,'repair_type'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($saleEstimation->header, 'repair_type', array('value'=>'GR','readonly'=>true)); ?>
                                                <?php echo $form->error($saleEstimation->header,'repair_type'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($saleEstimation->header,'employee_id_sale_person'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::activeDropDownlist($saleEstimation->header, 'employee_id_sale_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
                                                    "position_id" => 2,
                                                )), "id", "name"), array("empty" => "--Assign Sales--")); ?>
                                                <?php echo $form->error($saleEstimation->header,'employee_id_sale_person'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <!-- END COLUMN 6-->
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($saleEstimation->header,'branch_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php //echo CHtml::activeDropDownlist($saleEstimation->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), "id", "name"), array("empty" => "--all--")); ?>
                                                <?php echo $form->textField($saleEstimation->header,'branch_name',array('value'=>$saleEstimation->header->branch->name,'readonly'=>true)); ?>
                                                <?php echo $form->error($saleEstimation->header,'branch_id'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($saleEstimation->header,'user_id_created'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->hiddenField($saleEstimation->header,'user_id_created'); ?>
                                                <?php echo CHtml::encode($saleEstimation->header->userIdCreated->username); ?>
                                                <?php echo $form->error($saleEstimation->header,'user_id_created'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row">
                                            <div class="small-4 columns">
                                                <label class="prefix">Car Mileage (KM)</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($saleEstimation->header, 'vehicle_mileage'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    
                    <div class="row">
                        <div class="large-12 columns">
                            <fieldset>
                                <legend>Products</legend>

                                <div class="row">
                                    <div class="large-12 columns">
                                        <div class="detail" id="detail">
                                            <?php $this->renderPartial('_detailProduct', array('saleEstimation' => $saleEstimation)); ?>
                                        </div>
                                    </div>	
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="large-12 columns">
                            <fieldset>
                                <legend>Services</legend>

                                <div class="row">
                                    <div class="large-12 columns">
                                        <div class="detail" id="detail">
                                            <?php $this->renderPartial('_detailService', array('saleEstimation' => $saleEstimation)); ?>
                                        </div>
                                    </div>	
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row">
                                    <div class="small-2 columns">
                                        <label class="prefix"><?php echo $form->labelEx($saleEstimation->header,'problem'); ?></label>
                                    </div>
                                    <div class="small-10 columns">
                                        <?php echo $form->textArea($saleEstimation->header,'problem',array('rows'=>5, 'cols'=>50)); ?>
                                        <?php echo $form->error($saleEstimation->header,'problem'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <hr />
                            
                            <div class="field buttons text-center">
                                <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?> 
                            </div>
                            <?php echo IdempotentManager::generate(); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>