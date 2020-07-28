<?php
/* @var $this PublicDayOffController */
/* @var $model PublicDayOff */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'public-day-off-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<h1>Public Day Off</h1>
	<div class="row">
		<div class="small-6">
			<a class="button cbutton" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl.'/master/publicDayOff/admin';?>"><span class="fa fa-th-list"></span>Back to list</a>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<?php if (count($offs) > 0): ?>
				<table>
					<tr>
						<th>Date</th>
						<th>Description</th>
					</tr>
				
				<?php foreach ($offs as $key => $off): ?>
					<tr>
						<td><?php echo $off->date; ?></td>
						<td><?php echo $off->description; ?></td>
					</tr>
				<?php endforeach ?>
				</table>
			<?php else: ?>
				<?php echo "Test"; ?>
			<?php endif ?>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 columns">

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'date'); ?>
			</div>
			<div class="small-8 columns">
				<?php //echo $form->textField($model,'date'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $model,
                     'attribute' => "date",
                     // additional javascript options for the date picker plugin
                     'options'=>array(
                         'dateFormat' => 'yy-mm-dd',
                         'changeMonth'=>true,
        								 'changeYear'=>true,
        								 'yearRange'=>'1900:2020'
                     ),
                      'htmlOptions'=>array(
                        
                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                        ),
                 ));
                ?>
				<?php echo $form->error($model,'date'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'description'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'description'); ?>
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