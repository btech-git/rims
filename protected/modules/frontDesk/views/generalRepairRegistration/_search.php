<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */
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
                        <?php echo $form->label($model,'transaction_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'transaction_number',array('size'=>30,'maxlength'=>30)); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'transaction_date', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'StartDate',
                                'attribute' => $startDate,
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'placeholder' => 'Transaction Date From'
                                ),
                            )); ?>
                            <?php /*$attribute = 'transaction_date'; ?>
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'id' => CHtml::activeId($model, $attribute . '_0'),
                                'model' => $model,
                                'attribute' => $attribute . "_from",
                                'options' => array('dateFormat' => 'yy-mm-dd'),
                                'htmlOptions' => array(
                                    'style' => 'margin-bottom:0px; width: 155px',
                                    'placeholder' => 'Transaction Date From'
                                ),
                            ));*/ ?>
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
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'placeholder' => 'Transaction Date To'
                                ),
                            )); ?>
                            <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'id' => CHtml::activeId($model, $attribute . '_1'),
                                'model' => $model,
                                'attribute' => $attribute . "_to",
                                'options' => array('dateFormat' => 'yy-mm-dd'),
                                'htmlOptions' => array(
                                    'style' => 'margin-bottom:0px; width: 155px',
                                    'placeholder' => 'Transaction Date To'
                                ),
                            ));*/ ?>
                        </div>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'plate_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'plate_number'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'car_make_code', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'car_make_code',array('size'=>18,'maxlength'=>18)); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'car_model_code', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'car_model_code',array('size'=>18,'maxlength'=>18)); ?>
                    </div>
                </div>
            </div>	

            <div class="row buttons text-right">
                <?php echo CHtml::submitButton('Search', array('class'=>'button cbutton')); ?>
            </div>
        </div>

        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'customer_name', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'customer_name'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'work_order_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'work_order_number'); ?>
                    </div>
                </div>
            </div>	

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
                        <?php echo $form->label($model,'status', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::dropDownList('RegistrationTransaction[status]', $model->status, array(
                            '' => '-- All --',
                            'Registration' => 'Registration',
                            'Pending' => 'Pending',
                            'Available' => 'Available',
                            'On Progress' => 'On Progress',
                            'Finished' => 'Finished'
                        ), array("style" => "margin-bottom:0px;")); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'problem', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model,'problem',array('rows'=>3, 'cols'=>50)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->