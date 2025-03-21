<?php
/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'code', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'code', array('size' => 20, 'maxlength' => 20)); ?>
                    </div>
                </div>
            </div>
            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'name', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 30)); ?>
                    </div>
                </div>
            </div>

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'difficulty_level', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'difficulty_level'); ?>
                    </div>
                </div>
            </div>

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'description', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 60)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'service_type_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo CHtml::activeDropDownList($model, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateServiceCategorySelect'),
                                'update' => '#service_category',
                            )) . '$.fn.yiiGridView.update("service-grid", {data: {Service: {
                                service_type_id: $(this).val(),
                                service_category_id: $("#Service_service_category_id").val(),
                            } } });',
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'service_category_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns" id="service_category">
                        <?php echo CHtml::activeDropDownList($model, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',)); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'status', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive',), array('prompt' => 'Select',)); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'is_deleted', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'is_deleted', array(
                            1 => 'Show Deleted',
                            0 => 'Hide Deleted',
                        ), array('prompt' => 'Select',)); ?>
                    </div>
                </div>
            </div>

            <div class="field buttons text-right">
                <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->