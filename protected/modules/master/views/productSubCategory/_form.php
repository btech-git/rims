<?php
/* @var $this ProductSubCategoryController */
/* @var $model ProductSubCategory */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/ProductSubCategory/admin';?>"><span class="fa fa-th-list"></span>Manage Product Sub Category</a>
<h1><?php if($model->isNewRecord){ echo "New Product Sub Category"; }else{ echo "Update Product Sub Category";}?></h1>
<hr />
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-sub-category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
    	<div class="small-12 medium-6 columns">
    		<div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php echo $form->labelEx($model,'product_master_category_id'); ?></label>
	                </div>
	                <div class="small-8 columns">
				      	<?php echo $form->dropDownList($model, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'),array(
			               		'prompt' => '[--Select Product Master Category--]',
			                  	'onchange'=> 'jQuery.ajax({
			                  		type: "POST",
			                  		//dataType: "JSON",
			                  		url: "' . CController::createUrl('ajaxGetProductSubMasterCategory') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                        	jQuery("#ProductSubCategory_product_sub_master_category_id").html(data);
			                    	},
			                	});'
			          		)
			          	); ?>
						<?php echo $form->error($model,'product_master_category_id'); ?>
					</div>
	            </div>
	        </div>

	        <div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php echo $form->labelEx($model,'product_sub_master_category_id'); ?></label>
	                </div>
	                <div class="small-8 columns">
				      	<?php if($model->product_master_category_id == NULL)
              			{
                			echo $form->dropDownList($model,'product_sub_master_category_id',array(),array('prompt'=>'[--Select Product Sub Master Category--]'));
              			} else {
                			echo $form->dropDownList($model,'product_sub_master_category_id',CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id'=>$model->product_master_category_id)), 'id', 'name'),array());
              			}?>
						<?php echo $form->error($model,'product_sub_master_category_id'); ?>
					</div>
	            </div>
	        </div>

			<div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php echo $form->labelEx($model,'code'); ?></label>
	                </div>
	                <div class="small-8 columns">
					    <?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'code'); ?>
					</div>
	            </div>
	        </div>

	        <div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
	                </div>
	                <div class="small-8 columns">
					    <?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
	            </div>
	        </div>

	        <div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php echo $form->labelEx($model,'description'); ?></label>
	                </div>
	                <div class="small-8 columns">
					    <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
						<?php echo $form->error($model,'description'); ?>
					</div>
	            </div>
	        </div>

	        <div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php echo $form->labelEx($model,'status'); ?></label>
	                </div>
	                <div class="small-8 columns">
					    <?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
											'Inactive' => 'Inactive', ), array('prompt' => 'Select',)); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
	            </div>
	        </div>

			<div class="field buttons text-center">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
			</div>

    	</div>
    </div>

	<?php $this->endWidget(); ?>

</div><!-- form -->