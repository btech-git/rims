<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/customer/admin';?>"><span class="fa fa-th-list"></span>Manage Customer</a>
<h1><?php if($model->isNewRecord){ echo "New Customer"; }else{ echo "Update Customer";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'customer_type'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'customer_type',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->dropDownList($model,'customer_type', 
													  array(
																''=>'Select',
																'Individual'=>'Individual',
																'Company'=>'Company',
															)
													  );?>
						<?php echo $form->error($model,'customer_type'); ?>
					</div>
				</div>			
			</div>

			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'address'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50));; ?>
						<?php echo $form->error($model,'address'); ?>
					</div>
				</div>			
			</div>
			
			<div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($model,'province_id'); ?></label>
                </div>
                <div class="small-8 columns">
				    <?php //echo  $form->dropDownList($model, 'province_id',  array('prompt' => 'Select',)); ?>
					<?php echo $form->dropDownList($model, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
									'prompt' => '[--Select Province--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetCity',array('province'=>'')) . '" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#Customer_city_id").html(data);
		                        	},
								});'
					)); ?>
					<?php echo $form->error($model,'province_id'); ?>
				</div>
            </div>
         </div>
		 
		 <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($model,'city_id'); ?></label>
                </div>
                <div class="small-8 columns">
				    <?php //echo  $form->dropDownList($model, 'city_id',	 array('prompt' => 'Select',)); ?>
					<?php //echo $form->textField($model,'city_id',array('size'=>10,'maxlength'=>10)); ?>
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
					<?php echo $form->error($model,'city_id'); ?>
				</div>
            </div>
         </div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'zipcode'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'zipcode'); ?>
					</div>
				</div>			
			</div>
			
			<!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php //echo $form->labelEx($model,'phone'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
						<?php //echo $form->error($model,'phone'); ?>
					</div>
				</div>			
			</div> -->
			
			<!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php //echo $form->labelEx($model,'mobile_phone'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'mobile_phone',array('size'=>20,'maxlength'=>20)); ?>
						<?php //echo $form->error($model,'mobile_phone'); ?>
					</div>
				</div>			
			</div> -->

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'fax'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'fax',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'fax'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'email'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
						<?php echo $form->error($model,'email'); ?>
					</div>
				</div>			
			</div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'note'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50));; ?>
						<?php echo $form->error($model,'note'); ?>
					</div>
				</div>			
			</div>

			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'tenor'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'tenor',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'tenor'); ?>
					</div>
				</div>			
			</div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'birthdate'); ?></label>
					</div>
					<div class="small-8 columns">
							<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $model,
                     'attribute' => "birthdate",
                     // additional javascript options for the date picker plugin
                     'options'=>array(
                         'dateFormat' => 'yy-mm-dd',
                         'changeMonth'=>true,
        								 'changeYear'=>true,
        								 'yearRange'=>'1900:2020'
                     ),
                      'htmlOptions'=>array(
                        
                        'value'=>$model->isNewRecord ? '' : Customer::model()->findByPk($model->id)->birthdate,
                        ),
                 ));
                ?>
						<?php echo $form->error($model,'birthdate'); ?>
					</div>
				</div>			
			</div>
			
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'flat_rate'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'flat_rate',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'flat_rate'); ?>
					</div>
				</div>			
			</div>
	
			 </div>
      <!-- -->
			  <div class="small-12 medium-5b columns">

		<!-- begin RIGHT -->

		<a class="button extra right" href="#"><span class=""></span>Add Vehicle</a>
		<h2>Vehicle</h2>
		<div class="grid-view">
			<table class="items">
			<thead>
			<tr>
				<th><a href="#" class="sort-link">Plate Number</a></th>
			<th><a href="#" class="sort-link">Brand</a></th>
			<th><a href="#" class="sort-link">Sub Brand</a></th>
			<th><a href="#" class="sort-link">Type</a></th>
				<th><a href="#" class="sort-link">Color</a></th>
				<th><a href="#" class="sort-link"></a></th>
			</tr>
			</thead>
			<tbody>
				<tr><td class="empty" colspan="8"><span class="empty">No results found.</span></td></tr>
			</tbody>
			</table>
			<div class="clearfix"></div><div style="display:none" class="keys"></div>
		</div>

		<div></div>



		<!-- end RIGHT -->
	
	 </div>
   </div>
   <hr>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	