<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/bank/admin'; ?>"><span class="fa fa-th-list"></span>Manage Bank</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New Bank";
        } else {
            echo "Update Bank";
        } ?>
    </h1>
    <!-- begin FORM -->
    <hr />
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'bank-form',
        'enableAjaxValidation' => false,
    )); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'code', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'code', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'code'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'name', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 30)); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'coa_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'coa_id', CHtml::listData(Coa::model()->findAll(array(
                            'condition' => 't.coa_sub_category_id IN (1, 2, 3, 17) AND t.is_approved = 1', 
                            'order' => 't.name'
                        )), 'id', 'name'), array('empty' => '-Pilih COA-')); ?>
                        <?php echo $form->error($model, 'coa_id'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->