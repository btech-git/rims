<?php
/* @var $this ForecastingController */
/* @var $model Forecasting */
/* @var $form CActiveForm */
?>


<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/accounting/forecasting/admin';?>"><span class="fa fa-th-list"></span>Manage Forecasting</a>
<h1><?php if($model->isNewRecord){ echo "New Forecasting"; }else{ echo "Update Forecasting";}?></h1>
<!-- begin FORM -->
<hr />
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forecasting-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'transaction_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'transaction_id',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled')); ?>
						<?php echo $form->error($model,'transaction_id'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'type_forecasting', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'type_forecasting',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled')); ?>
						<?php echo $form->error($model,'type_forecasting'); ?>
					</div>
				</div>
			</div>


			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'due_date', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'due_date',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled')); ?>
						<?php echo $form->error($model,'due_date'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'payment_date', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'payment_date',array('size'=>20,'maxlength'=>20)); ?>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
							'model' => $model,
							'attribute' => "payment_date",
							'options'=>array(
								'dateFormat' => 'yy-mm-dd',
								'changeMonth'=>true,
								'changeYear'=>true,
								'yearRange'=>'1900:2020',
								),
							'htmlOptions'=>array(
								'placeholder'=>'Payment Date',
								// 'value'=>$paramStartdate,
								'id'=>'payment_date',
								'style'=>'margin-bottom:0px;'
								),
							)
						);
						?>
						<?php echo $form->error($model,'payment_date'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'realization_date', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'realization_date',array('size'=>20,'maxlength'=>20)); ?>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
							'model' => $model,
							'attribute' => "realization_date",
							'options'=>array(
								'dateFormat' => 'yy-mm-dd',
								'changeMonth'=>true,
								'changeYear'=>true,
								'yearRange'=>'1900:2020',
								),
							'htmlOptions'=>array(
								'placeholder'=>'Realization Date',
								// 'value'=>$paramStartdate,
								'id'=>'realization_date',
								'style'=>'margin-bottom:0px;'
								),
							)
						);
						?>
						<?php echo $form->error($model,'realization_date'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'bank_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php if ($model->id !=null) {
						
							if ($model->type_forecasting == 'po' || $model->type_forecasting == 'so') {
								echo $form->dropDownList($model, 'bank_id', CHtml::listData(CompanyBank::model()->findAll(), 'bank_id', 'account_name'),array(
									'prompt' => '[--Select Company Bank--]',
								));
							}else{
								echo $form->dropDownList($model, 'coa_id', CHtml::listData(Coa::model()->findAll(), 'id', 'name'),array(
									'prompt' => '[--Select Company Bank--]',
								));
							}
						}else{
							echo $form->textField($model,'bank_id',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled')); 
						}
						?>
						<?php echo $form->error($model,'bank_id'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'amount', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'amount',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabledd', 'class'=>'numbers')); ?>
						<?php echo $form->error($model,'amount'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'balance', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'balance',array('size'=>20,'maxlength'=>20, 'class'=>'numbers')); ?>
						<?php echo $form->error($model,'balance'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'realization_balance', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'realization_balance',array('size'=>20,'maxlength'=>20, 'class'=>'numbers')); ?>
						<?php echo $form->error($model,'realization_balance'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'status', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'status', array('OK' => 'Ok','NOTOK' => 'Not OK', ), array('prompt' => 'Select',)); ?>
						<?php //echo $form->textField($model,'status',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'notes', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
						<?php echo $form->error($model,'notes'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'image', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
    			        <?php echo $form->fileField($model, 'image');?>
						<?php 
							echo $form->error($model, 'image', array('clientValidation' => 'js:customValidateFile(messages)'), false, true);
						//echo $form->error($model,'image'); ?>
					</div>
				</div>
			</div>

			<?php if ($model->id !=NULL) { ?>
				<div class="row">
					<div class="small-12 medium-6" style="padding: 10px;">
						<img src="<?= Yii::app()->baseUrl.'/uploads/forecasting/'.$model->image_attach?>" style="max-width:250px;">
					</div>
				</div>
			<?php } ?>
		</div>
	</div>			
	<hr>
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
 	   ', CClientScript::POS_END);
?>