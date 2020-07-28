<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-transaction-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
		<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl.'/frontDesk/RegistrationTransaction/admin';?>"><span class="fa fa-th-list"></span>Manage Registration Transaction</a>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/'.$ccontroller.'/view',array('id'=>$model->registration_transaction_id));?>">Back</a>
	</div>
	<h1>Update SPK </h1>
	<div class="row">
		<div class="large-6 columns">
		  <div class="row collapse prefix-radius">
		    <div class="small-3 columns">
		      <span class="prefix">SPK Insurance</span>
		    </div>
		    <div class="small-9 columns">
		      <?php echo $form->fileField($model,'featured_image'); ?>
		    </div>
		  </div>
		</div>
	</div>

	<div class="row buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
	</div>
<?php $this->endWidget(); ?>
</div> <!-- endform -->

