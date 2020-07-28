<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success" id="above">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<?php echo CHtml::beginForm('','',array('class'=>'form')); ?>

	<p class="hint"><?php echo UserModule::t("Please enter your user login or email address."); ?></p>

	<?php //echo CHtml::errorSummary($form); ?>
	
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
		<?php echo CHtml::error($form,'login_or_email'); ?>

		<div class="pull-right">
			<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Login"),Yii::app()->getModule('user')->loginUrl); ?>
		</div>

		<?php echo CHtml::submitButton(UserModule::t("Restore"),array('class'=>'tiny button cbutton', 'style'=>'width:100%;')); ?>
<?php echo CHtml::endForm(); ?>
<?php endif; ?>