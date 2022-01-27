<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    )); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'movement_out_no', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'movement_out_no',array('size'=>30,'maxlength'=>30)); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'date_posting', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'date_posting'); ?>
                    </div>
                </div>
            </div>
            
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'branch_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'customer_name', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('CustomerName', $customerName); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo 'WO #'; ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('WorkOrderNumber', $workOrderNumber); ?>
                    </div>
                </div>
            </div>	
        </div>	
        
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'registration_transaction_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'registration_transaction_number'); ?>
                    </div>
                </div>
            </div>

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'status', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'status', array(
                            'Draft' => 'Draft',
                            'Revised' => 'Need Revision',
                            'Rejected'=>'Rejected',
                            'Approved' => 'Approved',
                        ), array('empty' => '-- all --')); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'plate_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('PlateNumber', $plateNumber); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'Car Make', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::dropDownList('CarMake', $carMake, CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'car_model', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::dropDownList('CarModel', $carModel, CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>	

            <div class="field buttons text-right">
                <?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->