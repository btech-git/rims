<?php if(Yii::app()->user->getState('user_id') == null): ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'htmlOptions'=>array('class'=>'form'),
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php if(Yii::app()->user->hasFlash('forgetPassword')): ?>
        <div id="above">
            <?php echo Yii::app()->user->getFlash('forgetPassword'); ?>
        </div>
    <?php endif; ?>

    <?php echo $form->labelEx($model, 'username',array('class'=>'required')); ?>
    <?php echo $form->textField($model, 'username'); ?>
    <?php echo $form->error($model, 'username'); ?>
    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password'); ?>
    <?php echo $form->error($model, 'password'); ?>
    <div class="checkbox-control">
    	<?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
        <?php echo CHtml::link('Forget Password', array('/site/forgetPassword')); ?>
    </div>
    <?php echo CHtml::submitButton('Login',array('class'=>'tiny button cbutton', 'style'=>'width:100%;')); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>