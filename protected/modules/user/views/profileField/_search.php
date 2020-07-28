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
                            <?php echo $form->label($model,'varname', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'varname',array('size'=>50,'maxlength'=>50)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'title', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'field_type', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model,'field_type',ProfileField::itemAlias('field_type')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'field_size', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'field_size'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'field_size_min', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'field_size_min'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'required', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model,'required',ProfileField::itemAlias('required')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'match', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'match',array('size'=>60,'maxlength'=>255)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'range', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'range',array('size'=>60,'maxlength'=>255)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'error_message', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'error_message',array('size'=>60,'maxlength'=>255)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'other_validator', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'other_validator',array('size'=>60,'maxlength'=>5000)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'default', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'default',array('size'=>60,'maxlength'=>255)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'widget', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'widget',array('size'=>60,'maxlength'=>255)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'widgetparams', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'widgetparams',array('size'=>60,'maxlength'=>5000)); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'position', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model,'position'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'visible', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model,'visible',ProfileField::itemAlias('visible')); ?>
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