<?php
/* @var $this VehicleCarSubModelDetailController */
/* @var $model VehicleCarSubModelDetail */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubModelDetail/admin';?>"><span class="fa fa-th-list"></span>Manage Vehicle Car Sub Model Detail</a>
<h1><?php if($model->isNewRecord){ echo "New Vehicle Car Sub Model Detail"; }else{ echo "Update Vehicle Car Sub Model Detail";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-car-sub-model-detail-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<!--<div class="row">
		<?php //echo $form->labelEx($model,'car_make_id'); ?>
		<?php //echo $form->textField($model,'car_make_id'); ?>
		<?php //echo $form->error($model,'car_make_id'); ?>
	</div>-->

	<!--<div class="row">
		<?php //echo $form->labelEx($model,'car_model_id'); ?>
		<?php //echo $form->textField($model,'car_model_id'); ?>
		<?php //echo $form->error($model,'car_model_id'); ?>
	</div>-->

	
	
	<div class="row">
							<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
								'id' => 'carsubmodel-dialog',
								// additional javascript options for the dialog plugin
								'options' => array(
									'title' => 'Vehicle Car Sub Model',
									'autoOpen' => false,
									'width' => 'auto',
									'modal' => true,
								),));
							?>

							<?php $this->widget('zii.widgets.grid.CGridView', array(
								'id'=>'carsubmodel-grid',
								'dataProvider'=>$vehicleCarSubModelDataProvider,
								'filter'=>$vehicleCarSubModel,
								// 'summaryText'=>'',
								'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
								'pager'=>array(
								   'cssFile'=>false,
								   'header'=>'',
								),
								'selectionChanged'=>'js:function(id){
									$("#VehicleCarSubModelDetail_car_sub_model_id").val($.fn.yiiGridView.getSelection(id));
									$("#carsubmodel-dialog").dialog("close");
									$.ajax({
										type: "POST",
										dataType: "JSON",
										url: "' . CController::createUrl('ajaxCarSubModel', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
										data: $("form").serialize(),
										success: function(data) {
											$("#VehicleCarSubModelDetail_car_sub_model_name").val(data.name);
										},
									});
								}',
								'columns'=>array(
									//'id',
									//'code',
									'name'
								),
							));?>
							<?php $this->endWidget(); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="small-12 medium-6 columns">			 
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($model,'car_sub_model_id',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->dropDownList($model,'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(),'id','name'),  array('prompt' => '[--Select Car Sub Model--]','disabled'=>'disabled')); ?>
						<?php echo $form->hiddenField($model,'car_sub_model_id'); ?>
						<?php echo $form->textField($model,'car_sub_model_name',array(
							'size'=>10,
							'maxlength'=>10,
							'value'=>$model->isNewRecord ? '' : $model->carSubModel->name,
							//'disabled'=>true,
							'onclick'=>'
								jQuery("#carsubmodel-dialog").dialog("open"); return false;
							'
						)); ?>
						
						<?php echo $form->error($model,'car_sub_model_id'); ?>
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
					  <?php echo $form->labelEx($model,'name',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>10,'maxlength'=>10)); ?>
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
					  <?php echo $form->labelEx($model,'chasis_code',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'chasis_code',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'chasis_code'); ?>	
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
					  <?php echo $form->labelEx($model,'assembly_year_start',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'assembly_year_start',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'assembly_year_start'); ?>	
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
					  <?php echo $form->labelEx($model,'assembly_year_end',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'assembly_year_end',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'assembly_year_end'); ?>	
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
					  <?php echo $form->labelEx($model,'transmission',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'transmission', array('Manual' => 'Manual',
									'Automatic' => 'Automatic','Sports' => 'Sports','Other' => 'Other',), array('prompt' => '[--Select Transmission--]',)); ?>
						<?php echo $form->error($model,'transmission'); ?>	
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
					  <?php echo $form->labelEx($model,'fuel_type',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'fuel_type', array('Diesel' => 'Diesel',
									'Electric' => 'Electric','Gas' => 'Gas','Gasoline' => 'Gasoline', 'Hybrid' => 'Hybrid',), array('prompt' => '[--Select Fuel--]',)); ?>
						<?php echo $form->error($model,'fuel_type'); ?>	
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
					  <?php echo $form->labelEx($model,'power',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php $array = range(1000,8000,100); ?>
						<?php echo $form->dropDownList($model,'power', array_combine($array, $array),array('prompt'=>'[--Select Power CC--]')); ?>
						<?php echo $form->error($model,'power'); ?>
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
					  <?php echo $form->labelEx($model,'drivetrain',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'drivetrain', array('4WD' => '4WD', '2WD' => '2WD','AWD'=>'AWD'),array('prompt'=>'[--Select DriveTrain--]')); ?>
						<?php echo $form->error($model,'drivetrain'); ?>	
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
					  <?php echo $form->labelEx($model,'description',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
						<?php echo $form->error($model,'description'); ?>
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
					  <?php echo $form->labelEx($model,'status',array('class'=>'prefix')); ?>
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
	
	<div class="row">
		<div class="small-12 medium-6 columns">			 
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($model,'luxury_value',array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php  echo $form->textField($model,'luxury_value',array('size'=>8,'maxlength'=>8)); ?>
						<?php echo $form->error($model,'luxury_value'); ?>
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