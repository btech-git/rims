<?php
/* @var $this CoaController */
/* @var $model Coa */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'id', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'id', array('size' => 10, 'maxlength' => 10)); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'code', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'code', array('size' => 10, 'maxlength' => 10)); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'name', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'coa_category_id', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateSubCategorySelect'),
                                'update' => '#sub_category',
                            )) . '$.fn.yiiGridView.update("coa-grid", {data: {Coa: {
                                coa_category_id: $(this).val(),
                                id: $("#coa_id").val(),
                                code: $("#coa_code").val(),
                                name: $("#coa_name").val(),
                                coa_sub_category_id: $("#coa_sub_category_id").val(),
                            } } });',
                        )); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'coa_sub_category_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns" id="sub_category">
                        <?php echo CHtml::activeDropDownList($model, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',)); ?>
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