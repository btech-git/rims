<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

    <div id="above">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>

<?php endif; ?>

<?php echo CHtml::beginForm(array('/user/login'), 'post', array('class' => 'form')); ?>

<?php //echo CHtml::errorSummary($model); ?>

<?php echo CHtml::activeLabelEx($model, 'username'); ?>
<?php echo CHtml::activeTextField($model, 'username', array('autofocus' => 'autofocus')); ?>
<?php echo CHtml::error($model, 'username'); ?>

<?php echo CHtml::activeLabelEx($model, 'password'); ?>
<?php echo CHtml::activePasswordField($model, 'password') ?>
<?php echo CHtml::error($model, 'password'); ?>

<?php echo CHtml::activeLabelEx($model, 'branchId'); ?>
<?php echo CHtml::activeDropDownList($model, 'branchId', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- Select Branch --')); ?>
<?php echo CHtml::error($model, 'branchId'); ?>

<?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
<?php echo CHtml::activeLabelEx($model, 'rememberMe'); ?>

<!--<p class="pull-right">
    <?php //echo CHtml::link(UserModule::t("Register"), Yii::app()->getModule('user')->registrationUrl); ?> | <?php //echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
</p>-->

<?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'tiny button cbutton', 'style' => 'width:100%;')); ?>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
