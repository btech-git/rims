<?php
/* @var $this EmployeeBankController */
/* @var $model EmployeeBank */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/employeeBank/admin';?>"><span class="fa fa-th-list"></span>Manage Employee Banks</a>
<h1><?php if($model->isNewRecord){ echo "New Employee Bank"; }else{ echo "Update Employee Bank";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-bank-form',
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
						<label class="prefix"><?php echo $form->labelEx($model,'bank_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'bank_id', CHtml::listData(Bank::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
						<?php echo $form->error($model,'bank_id'); ?>
					</div>
				</div>			
			</div>
		</div>
	</div>
	

	<div class="row">
		<div class="small-12 medium-6 columns">		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'employee_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'employee_id', CHtml::listData(Employee::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
						<?php echo $form->error($model,'employee_id'); ?>
					</div>
				</div>			
			</div>
		</div>
	</div>

	<div class="row">
		<div class="small-12 medium-6 columns">		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'account_no'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'account_no',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'account_no'); ?>
					</div>
				</div>			
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="small-12 medium-6 columns">		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'account_name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'account_name',array('size'=>60,'maxlength'=>100)); ?>
						<?php echo $form->error($model,'account_name'); ?>
					</div>
				</div>			
			</div>
		</div>
	</div>

	<div class="row">
		<div class="small-12 medium-6 columns">			 
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