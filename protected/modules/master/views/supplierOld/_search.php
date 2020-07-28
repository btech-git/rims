<?php
/* @var $this SupplierController */
/* @var $model Supplier */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		)); ?>

		<div class="row">
			<div class="small-12 medium-6 columns">

				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'date',array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">	
							<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
								'model' => $model,
								'attribute' => "date",
                     // additional javascript options for the date picker plugin
								'options'=>array(
									'dateFormat' => 'yy-mm-dd',
									'changeMonth'=>true,
									'changeYear'=>true,
						 // 'yearRange'=>'1900:2020'
									),
								'htmlOptions'=>array(
									
                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
									),
								));
								?>

								<?php //echo $form->textField($model,'date',array('size'=>60,'maxlength'=>100)); ?>            
							</div>
						</div>
					</div>
					<!-- BEGIN field -->
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->label($model,'code',array('class'=>'prefix')); ?>
								
							</div>
							<div class="small-8 columns">	
								<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>     
							</div>
						</div>
					</div>
					
					<!-- BEGIN field -->
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								
								<?php echo $form->label($model,'name',array('class'=>'prefix')); ?>
								
							</div>
							<div class="small-8 columns">	
								<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>     
							</div>
						</div>
					</div>
					
					<!-- BEGIN field -->
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->label($model,'company',array('class'=>'prefix')); ?>
								
							</div>
							<div class="small-8 columns">	
								<?php echo $form->textField($model,'company',array('size'=>30,'maxlength'=>30)); ?>
							</div>
						</div>
					</div>
					
					<!-- BEGIN field -->
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->label($model,'position',array('class'=>'prefix')); ?>
								
							</div>
							<div class="small-8 columns">	
								<?php echo $form->textField($model,'position',array('size'=>30,'maxlength'=>30)); ?>      
							</div>
						</div>
					</div>
					
					<!-- BEGIN field -->
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->label($model,'address',array('class'=>'prefix')); ?>
								
							</div>
							<div class="small-8 columns">	
								<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?> 
							</div>
						</div>
					</div>
				</div>		
				<div class="small-12 medium-6 columns">
					<!-- BEGIN field -->
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->label($model,'province_id',array('class'=>'prefix')); ?>
								
							</div>
							<div class="small-8 columns">	
								<?php //echo $form->textField($model,'province_id'); ?>
								<?php echo $form->dropDownList($model, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
									'prompt' => '[--Select Province--]',
									'onchange'=> 'jQuery.ajax({
										type: "POST",
							//dataType: "JSON",
										url: "' . CController::createUrl('ajaxGetCity') . '" ,
										data: jQuery("form").serialize(),
										success: function(data){
											console.log(data);
											jQuery("#Supplier_city_id").html(data);
										},
									});'
									)); ?>					
								</div>
							</div>
						</div>
						
						<!-- BEGIN field -->
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php echo $form->label($model,'city_id',array('class'=>'prefix')); ?>
									
								</div>
								<div class="small-8 columns">	
									<?php //echo $form->textField($model,'city_id'); ?>
									<?php
									if($model->province_id == NULL)
									{
										echo $form->dropDownList($model,'city_id',array(),array('prompt'=>'[--Select City-]'));
									}
									else
									{
										echo $form->dropDownList($model,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$model->province_id)), 'id', 'name'),array());
									}
									?>
								</div>
							</div>
						</div>

						<!-- BEGIN field -->
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php echo $form->label($model,'zipcode',array('class'=>'prefix')); ?>
									
								</div>
								<div class="small-8 columns">	
									<?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
								</div>
							</div>
						</div>

						<!-- BEGIN field -->
						<!-- <div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php //echo $form->label($model,'fax',array('class'=>'prefix')); ?>
									
								</div>
								<div class="small-8 columns">	
									<?php //echo $form->textField($model,'fax',array('size'=>20,'maxlength'=>20)); ?>
									
								</div>
							</div>
						</div> -->

						<!-- BEGIN field -->
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php echo $form->label($model,'email_personal',array('class'=>'prefix')); ?>
									
								</div>
								<div class="small-8 columns">	
									<?php echo $form->textField($model,'email_personal'); ?>
									
								</div>
							</div>
						</div>

						<!-- BEGIN field -->
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php echo $form->label($model,'email_company',array('class'=>'prefix')); ?>
								</div>
								<div class="small-8 columns">	
									<?php echo $form->textField($model,'email_company',array('size'=>60,'maxlength'=>60)); ?>
								</div>
							</div>
						</div>

						<!-- BEGIN field -->
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php echo $form->label($model,'npwp',array('class'=>'prefix')); ?>
									
								</div>
								<div class="small-8 columns">	
									<?php echo $form->textField($model,'npwp',array('size'=>20,'maxlength'=>20)); ?>
								</div>
							</div>
						</div>

						<!-- BEGIN field -->
						<!-- <div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php //echo $form->label($model,'description',array('class'=>'prefix')); ?>
									
								</div>
								<div class="small-8 columns">	
									<?php //echo $form->textField($model,'description',array('size'=>60,'maxlength'=>60)); ?>
								</div>
							</div>
						</div> -->

						<!-- BEGIN field -->
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<?php echo $form->label($model,'tenor',array('class'=>'prefix')); ?>
									
								</div>
								<div class="small-8 columns">	
									<?php echo $form->textField($model,'tenor'); ?>
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