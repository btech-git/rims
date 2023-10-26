<?php
/* @var $this EmployeeTimesheetController */
/* @var $model EmployeeTimesheet */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    )); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'employee_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'employee_id', CHtml::listData(Employee::model()->findAllByAttributes(array('status' => 'Active'), array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'date', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'StartDate',
                                'attribute' => $startDate,
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'placeholder' => 'Transaction Date From'
                                ),
                            )); ?>
                        </div>
                        <div class="medium-2 columns" style="text-align: center; vertical-align: middle">
                            S/D
                        </div>
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'EndDate',
                                'attribute' => $endDate,
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'placeholder' => 'Transaction Date To'
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->