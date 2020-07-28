<?php
/* @var $this ProductController */
/* @var $model Product */
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
							<?php echo $form->label($model,'id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'id'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'code', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'code'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'manufacturer_code', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'manufacturer_code'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'name', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'description', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'production_year', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'production_year'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'extension', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'extension',array('size'=>50,'maxlength'=>50)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'product_master_category_id', array('class'=>'prefix')); ?>
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
			                        	jQuery("#Product_code").val("");
			                        	jQuery("#Product_product_sub_master_category_id").html(data);
			                        	if(jQuery("#Product_product_sub_master_category_id").val() == ""){
			                        		jQuery(".additional-specification").slideUp();
					    					jQuery("#Product_product_sub_category_id").html("<option value=\"\">[--Select Product Sub Category--]</option>");
					    				}
			                    	},
			                	});'
			          		)
			          	); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'product_sub_master_category_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
					    <?php echo $form->dropDownList($model, 'product_sub_master_category_id', $model->product_master_category_id != '' ? CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id'=>$model->product_master_category_id)), 'id', 'name') : array(),array(
			               		'prompt' => '[--Select Product Sub Master Category--]',
			                  	'onchange'=> 'jQuery.ajax({
			                  		type: "POST",
			                  		url: "' . CController::createUrl('ajaxGetProductSubCategory') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                        	jQuery("#Product_code").val("");
			                        	if(jQuery("#Product_product_sub_master_category_id").val() == ""){
			                        		jQuery(".additional-specification").slideUp();
			                        	}
			                        	jQuery("#Product_product_sub_category_id").html(data);
			                    	},
			                	});'
			          		)
			          	); ?>

						</div>
					</div>
				</div>	
				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'product_sub_category_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
					    <?php echo $form->dropDownList($model, 'product_sub_category_id', $model->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id'=>$model->product_sub_master_category_id)), 'id', 'name') : array(),array(
				            	'prompt' => '[--Select Product Sub Category--]',
				            	'onchange'=> 'jQuery.ajax({
			                  		type: "POST",
			                  		url: "' . CController::createUrl('ajaxGetCode') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                        	/*jQuery("#Product_code").val(data);
			                        	jQuery(".additional-specification").slideUp();
			                        	if(jQuery("#Product_product_sub_category_id").val() == 1){
			                        		jQuery("#battery-specification").slideDown();
			                        	}
			                        	if(jQuery("#Product_product_sub_category_id").val() == 2){
			                        		jQuery("#oil-specification").slideDown();
			                        	}
			                        	if(jQuery("#Product_product_sub_category_id").val() == 3){
			                        		jQuery("#tire-specification").slideDown();
			                        	}*/
			                    	},
			                	});'
				      	)); ?>
				      	</div>
					</div>
				</div>	
			</div>

			<div class="small-12 medium-6 columns">
				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'vehicle_car_make_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'vehicle_car_make_id'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'vehicle_car_model_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'vehicle_car_model_id'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'purchase_price', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'purchase_price',array('size'=>10,'maxlength'=>10)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'recommended_selling_price', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'recommended_selling_price',array('size'=>10,'maxlength'=>10)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'hpp', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'hpp',array('size'=>10,'maxlength'=>10)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'retail_price', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'retail_price',array('size'=>10,'maxlength'=>10)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'stock', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'stock'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'minimum_stock', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'minimum_stock'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'margin_type', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'margin_type'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'margin_amount', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'margin_amount'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'is_usable', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'is_usable',array('size'=>5,'maxlength'=>5)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'status', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
							'Inactive' => 'Inactive', ), array('prompt' => 'Select',)); ?>
						</div>
					</div>
				</div>	

				<div class="field buttons text-right">
					<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
				</div>
			</div>
		</div>

		<?php $this->endWidget(); ?>

</div><!-- search-form -->