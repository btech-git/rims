<div id="advSearch">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        )); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'id', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'id'); ?>
                        </div>
                    </div>
                </div>  

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'username', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
                        </div>
                    </div>
                </div>  

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'email', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
                        </div>
                    </div>
                </div>  

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'activkey', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'activkey',array('size'=>60,'maxlength'=>128)); ?>
                        </div>
                    </div>
                </div>  

            </div>
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'create_at', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'create_at'); ?>
                        </div>
                    </div>
                </div>  

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'lastvisit_at', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'lastvisit_at'); ?>
                        </div>
                    </div>
                </div>  

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'superuser', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model,'superuser',$model->itemAlias('AdminStatus')); ?>
                        </div>
                    </div>
                </div>  

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'status', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model,'status',$model->itemAlias('UserStatus')); ?>
                        </div>
                    </div>
                </div>  

                <div class="field buttons text-right">
                    <?php echo CHtml::submitButton(UserModule::t('Search'),array('class'=>'button cbutton')); ?>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>

</div><!-- search-form -->