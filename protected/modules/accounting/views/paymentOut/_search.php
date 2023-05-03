<?php /*Yii::app()->clientScript->registerScript('report', '
	$("#header").addClass("hide");
	$("#mainmenu").addClass("hide");
	$(".breadcrumbs").addClass("hide");
	$("#footer").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
');*/ ?>

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
                        <?php echo $form->label($model,'purchase_order_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'purchase_order_id'); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'payment_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'payment_number',array('size'=>50,'maxlength'=>50)); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'payment_date', array('class'=>'prefix')); ?>
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
                        <?php echo $form->label($model,'notes', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'notes'); ?>
                    </div>
                </div>
            </div>	

        </div>
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'supplier_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'supplier_name'); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'payment_type_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- all --')); ?>
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
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAllByPk(Yii::app()->user->branch_ids, array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'user_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'user_id', CHtml::listData(Users::model()->findAll(array('order' => 'username')), 'id', 'username'), array('empty' => '-- all --')); ?>
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