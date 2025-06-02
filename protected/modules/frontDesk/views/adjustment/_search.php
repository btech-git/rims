<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'stock_adjustment_number', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'stock_adjustment_number', array('size' => 30, 'maxlength' => 30)); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'date_posting', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'StartDate',
                            'attribute' => $startDate,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Date From'
                            ),
                        )); ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'EndDate',
                            'attribute' => $endDate,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Date To'
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>	
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'branch_id', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'transaction_type', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'transaction_type', array(
                            'Selisih Cabang' => 'Selisih Cabang',
                            'Hilang' => 'Hilang / Lebih',
                        ), array('empty' => '-- all --')); ?>
                    </div>
                </div>
            </div>

            <div class="row buttons text-right">
                <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->