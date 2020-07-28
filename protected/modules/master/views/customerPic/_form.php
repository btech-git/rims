<?php
/* @var $this CustomerPicController */
/* @var $model CustomerPic */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/customerPic/admin';?>"><span class="fa fa-th-list"></span>Manage Customer Pic</a>
<h1><?php if($model->isNewRecord){ echo "New Customer Pic"; }else{ echo "Update Customer Pic";}?></h1>
<!-- begin FORM -->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-pic-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">
		
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'customer_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'customer_type',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->textField($model,'customer_id');?>
						<?php echo $form->error($model,'customer_id'); ?>
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
                  <label class="prefix"><?php echo $form->labelEx($model,'city'); ?></label>
                </div>
                <div class="small-8 columns">
				    <?php //echo  $form->dropDownList($model, 'city',	 array('prompt' => 'Select',)); ?>
					<?php echo $form->textField($model,'city',array('size'=>10,'maxlength'=>10)); ?>
					<?php echo $form->error($model,'city'); ?>
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
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix"><?php echo $form->labelEx($model,'phone'); ?></label>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo $form->error($model,'phone'); ?>
			</div>
		</div>			
	</div>
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix"><?php echo $form->labelEx($model,'mobile_phone'); ?></label>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'mobile_phone',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo $form->error($model,'mobile_phone'); ?>
			</div>
		</div>			
	</div>

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
				<label class="prefix"><?php echo $form->labelEx($model,'birthdate'); ?></label>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'birthdate'); ?>
				<?php echo $form->error($model,'birthdate'); ?>
			</div>
		</div>			
	</div>
			

	</div>
   </div>
   <hr>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	