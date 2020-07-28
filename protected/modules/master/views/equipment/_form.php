<?php
/* @var $this EquipmentController */
/* @var $model Equipment */
/* @var $form CActiveForm */
?>


<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipment/admin';?>"><span class="fa fa-th-list"></span>Manage Equipments</a>
<h1><?php if($model->isNewRecord){ echo "New Equipment"; }else{ echo "Update Equipment";}?></h1>
<!-- begin FORM -->
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">         
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
		</div>		
  </div>


	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					<label class="prefix"><?php echo $form->labelEx($model,'purchase_date'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $model,
                     'attribute' => "purchase_date",
                     // additional javascript options for the date picker plugin
                     'options'=>array(
                         'dateFormat' => 'yy-mm-dd',
                         'changeYear'=>true,
                         'changeMonth'=>true,
                         'yearRange'=>'1990:2060'
                        
                     ),
                      'htmlOptions'=>array(
                        
                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                        ),
                 ));
                ?>
						<?php echo $form->error($model,'purchase_date'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'maintenance_schedule'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $model,
                     'attribute' => "maintenance_schedule",
                     // additional javascript options for the date picker plugin
                     'options'=>array(
                         'dateFormat' => 'yy-mm-dd',
                         'changeYear'=>true,
                         'changeMonth'=>true,
                         'yearRange'=>'2012:2060'
                        
                     ),
                      'htmlOptions'=>array(
                        
                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                        ),
                 ));
                ?>
						<?php echo $form->error($model,'maintenance_schedule'); ?>
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
						<label class="prefix"><?php echo $form->labelEx($model,'period'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'period'); ?>
						<?php echo $form->error($model,'period'); ?>
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
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
  </div>

		<hr>

	
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->
</div>	