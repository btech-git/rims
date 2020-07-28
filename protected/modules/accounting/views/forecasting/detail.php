<?php $model = new Forecasting; ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forecasting-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php 
	foreach ($modelforecasting as $key => $value) {
		// echo $value->id .' => '. $value->amount;
		// echo "<br />";
?>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<h1>Update Forecasting for ID #<?php echo $value->id; ?></h1>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'transaction_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($model,'['.$key.']id',array('size'=>20,'maxlength'=>20, 'value'=>$value->id)); ?>

						<?php echo $form->textField($model,'['.$key.']transaction_id',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled', 'value'=>$value->transaction_id)); ?>
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
						<?php echo $form->textField($model,'['.$key.']type_forecasting',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled', 'value'=>$value->type_forecasting)); ?>
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
						<?php echo $form->textField($model,'['.$key.']due_date',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled', 'value'=>$value->due_date)); ?>
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
							'attribute' => "[$key]payment_date",
							'options'=>array(
								'dateFormat' => 'yy-mm-dd',
								'changeMonth'=>true,
								'changeYear'=>true,
								'yearRange'=>'1900:2020',
								),
							'htmlOptions'=>array(
								'placeholder'=>'Payment Date',
								'value'=>$value->payment_date,
								'id'=>'payment_date_'.$value->id,
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
							'attribute' => "[$key]realization_date",
							'options'=>array(
								'dateFormat' => 'yy-mm-dd',
								'changeMonth'=>true,
								'changeYear'=>true,
								'yearRange'=>'1900:2020',
								),
							'htmlOptions'=>array(
								'placeholder'=>'Realization Date',
								'value'=>$value->realization_date,
								'id'=>'realization_date_'.$value->id,
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
						
							if ($value->type_forecasting == 'po' || $value->type_forecasting == 'so') {
								echo $form->dropDownList($model, '['.$key.']bank_id', CHtml::listData(CompanyBank::model()->findAll(), 'bank_id', 'account_name'),array(
									'prompt' => '[--Select Company Bank--]',
								));
							}else{
								echo $form->dropDownList($model, '['.$key.']coa_id', CHtml::listData(Coa::model()->findAll(), 'id', 'name'),array(
									'prompt' => '[--Select Company Bank--]',
								));
							}
						}else{
							if ($value->type_forecasting == 'po' || $value->type_forecasting == 'so') {
								echo $form->textField($model,'['.$key.']bank_id',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled', 'value'=>$value->bank_id));
							}else{
								echo $form->textField($model,'['.$key.']coa_id',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabled', 'value'=>$value->coa_id));
							}
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
						<?php echo $form->textField($model,'['.$key.']amount',array('size'=>20,'maxlength'=>20, 'disabled'=>'disabledd', 'class'=>'numbers', 'value'=>$value->amount)); ?>
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
						<?php echo $form->textField($model,'['.$key.']balance',array('size'=>20,'maxlength'=>20, 'class'=>'numbers', 'value'=>$value->balance)); ?>
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
						<?php echo $form->textField($model,'['.$key.']realization_balance',array('size'=>20,'maxlength'=>20, 'class'=>'numbers', 'value'=>$value->realization_balance)); ?>
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
						<?php echo $form->dropDownList($model, '['.$key.']status', array('OK' => 'Ok','NOTOK' => 'Not OK', ), array('prompt' => 'Select',)); ?>
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
						<?php echo $form->textArea($model,'['.$key.']notes',array('rows'=>6, 'cols'=>50, 'value'=>$value->notes)); ?>
						<?php echo $form->error($model,'notes'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php /*
		<div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'['.$key.']image', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
    			        <?php echo $form->fileField($model, '['.$key.']image');?>
						<?php 
							echo $form->error($model, '['.$key.']image', array('clientValidation' => 'js:customValidateFile(messages)'), false, true);
						//echo $form->error($model,'image'); ?>
					</div>
				</div>
			</div>

			<?php if ($value->id !=NULL) { ?>
				<div class="row">
					<div class="small-12 medium-6" style="padding: 10px;">
						<img src="<?= Yii::app()->baseUrl.'/uploads/forecasting/'.$value->image_attach?>" style="max-width:250px;">
					</div>
				</div>
			<?php } ?>
		</div>*/?>
	</div>			

<?php } ?>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<div class="field buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
			</div>
		</div>
	</div>
<?php $this->endWidget(); ?>

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
 	   ', CClientScript::POS_END);
?>