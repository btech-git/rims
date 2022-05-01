<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */
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
                        <?php echo $form->textField($model,'transaction_number'); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'transaction_date', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo $form->textField($model,'transaction_date'); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $model,
                            'attribute' => "transaction_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                                'yearRange'=>'1900:2020'
                            ),
                            'htmlOptions'=>array(
//                                'value'=>date('Y-m-d'),
                                'readonly' => true,
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'status', array('class'=>'prefix')); ?>
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
            
        </div>
        
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'coa_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'coa_id', CHtml::listData(Coa::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>	

            <?php if ((int) $user->branch_id == 6): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'branch_id', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAllByPk(Yii::app()->user->branch_ids, array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="field buttons text-right">
                <?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->