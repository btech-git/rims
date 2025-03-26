<?php
/* @var $this ProductSubCategoryController */
/* @var $model ProductSubCategory */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    
    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'product_master_category_id', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                    <?php echo CHtml::activeDropDownList($model, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                        'empty' => '-- All --',
                        'order' => 'name',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                            'update' => '#product_sub_master_category',
                        )),
                    )); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'product_sub_master_category_id', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns" id="product_sub_master_category">
                    <?php echo CHtml::activeDropDownList($model, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',)); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'status', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo  $form->dropDownList($model, 'status', array(
                            'Active' => 'Active',
                            'Inactive' => 'Inactive', 
                        ), array('prompt' => 'Select',)); ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="small-12 medium-6 columns">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'code', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20));?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'name', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30));?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'description', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50));?>
                    </div>
                </div>
            </div>

            <div class="row buttons text-right">
                <?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
            </div>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget(); ?>

</div><!-- search-form -->