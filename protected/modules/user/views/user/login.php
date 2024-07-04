	<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

		<div id="above">
			<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
		</div>

	<?php endif; ?>

	<?php echo CHtml::beginForm(array('/user/login'),'post', array('class'=>'form')); ?>

		<?php //echo CHtml::errorSummary($model); ?>

		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username', array('autofocus'=>'autofocus')); ?>
		<?php echo CHtml::error($model,'username'); ?>

		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password') ?>
		<?php echo CHtml::error($model,'password'); ?>

		<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
		<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
		
		<p class="pull-right">
			<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>

		<?php echo CHtml::submitButton(UserModule::t("Login"),array('class'=>'tiny button cbutton', 'style'=>'width:100%;')); ?>

		<?php echo CHtml::endForm(); ?>
	</div><!-- form -->


	<?php
	$form = new CForm(array(
		'elements'=>array(
			'username'=>array(
				'type'=>'text',
				'maxlength'=>32,
				),
			'password'=>array(
				'type'=>'password',
				'maxlength'=>32,
				),
			'rememberMe'=>array(
				'type'=>'checkbox',
				)
			),

		'buttons'=>array(
			'login'=>array(
				'type'=>'submit',
				'label'=>'Login',
				),
			),
		), $model);
		?>