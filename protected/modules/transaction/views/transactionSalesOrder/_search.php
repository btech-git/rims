<?php
/* @var $this TransactionSalesOrderController */
/* @var $model TransactionSalesOrder */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'sale_order_no', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'sale_order_no'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'sale_order_date', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name' => 'StartDate',
                                'attribute' => $startDate,
                                'options'=>array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions'=>array(
                                    'readonly' => true,
                                ),
                            )); ?>
                        </div>
                        <div class="medium-2 columns" style="text-align: center; vertical-align: middle">
                            S/D
                        </div>
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name' => 'EndDate',
                                'attribute' => $endDate,
                                'options'=>array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions'=>array(
                                    'readonly' => true,
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'status_document', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'status_document', array('size' => 30, 'maxlength' => 30)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'customer_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'customer_name'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'requester_branch_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'requester_branch_id', CHtml::listData(Branch::model()->findAllByPk(Yii::app()->user->branch_ids, array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'payment_type', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'payment_type', array('size' => 30, 'maxlength' => 30)); ?>
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