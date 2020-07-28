<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
	);
	?>

	<h3><?php echo UserModule::t("Registration"); ?></h3>

	<?php if(Yii::app()->user->hasFlash('registration')): ?>
		<div class="success" id="above">
			<?php echo Yii::app()->user->getFlash('registration'); ?>
		</div>
	<?php else: ?>

		<?php $form=$this->beginWidget('UActiveForm', array(
			'id'=>'registration-form',
			'enableAjaxValidation'=>true,
			'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				),
			'htmlOptions' => array('enctype'=>'multipart/form-data','class'=>'form'),
			)); ?>


			<?php echo $form->errorSummary(array($model,$profile)); ?>


			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>

			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
			<!--<p class="text-right">
				<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
			</p>-->



			<?php echo $form->labelEx($model,'verifyPassword'); ?>
			<?php echo $form->passwordField($model,'verifyPassword'); ?>
			<?php echo $form->error($model,'verifyPassword'); ?>



			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>


			<?php 
			$profileFields=$profile->getFields();
			if ($profileFields) {
				foreach($profileFields as $field) {
					?>

					<?php echo $form->labelEx($profile,$field->varname); ?>
					<?php 
					if ($widgetEdit = $field->widgetEdit($profile)) {
						echo $widgetEdit;
					} elseif ($field->range) {
						echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
					} elseif ($field->field_type=="TEXT") {
						echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
					} else {
						echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
					}
					?>
					<?php echo $form->error($profile,$field->varname); ?>

					<?php
				}
			}
			?>
			<?php if (UserModule::doCaptcha('registration')): ?>

				<?php echo $form->labelEx($model,'verifyCode'); ?>

				<?php $this->widget('CCaptcha'); ?>
				<?php echo $form->textField($model,'verifyCode'); ?>
				<?php echo $form->error($model,'verifyCode'); ?>

				<!--<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
				<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>-->

			<?php endif; ?>
			<div class="pull-right">
			<?php echo CHtml::link(UserModule::t("Login"),Yii::app()->getModule('user')->loginUrl); ?> |  <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
			</div>


			<?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'tiny button cbutton', 'style'=>'width:100%;')); ?>


			<?php $this->endWidget(); ?>
		<?php endif; ?>