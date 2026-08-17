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
                        <?php echo $form->label($model,'transaction_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'transaction_number',array('size'=>30,'maxlength'=>30)); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'Tanggal', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name'=>'StartDate',
                            'value'=>$startDate,
                            'options'=>array(
                                'dateFormat'=>'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions'=>array(
                                'style'=>'margin-bottom:0px;',
                                'placeholder'=>'Tanggal Mulai',
                            ),
                        )); ?>
                    </div>
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name'=>'EndDate',
                            'value'=>$endDate,
                            'options'=>array(
                                'dateFormat'=>'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions'=>array(
                                'style'=>'margin-bottom:0px;',
                                'placeholder'=>'Tanggal Akhir',
                            ),
                        )); ?>
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
        </div>	
        
        <div class="small-12 medium-6 columns">
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
                        <?php echo $form->label($model,'customer_name', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('CustomerName', $customerName); ?>
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