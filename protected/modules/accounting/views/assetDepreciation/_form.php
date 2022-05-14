<?php
/* @var $this AssetDepreciationController */
/* @var $model AssetDepreciation */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-depreciation-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Aset', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'asset_purchase_id', CHtml::listData(AssetPurchase::model()->findAll(),'id','description'), array('empty' => '-- Pilih Aset --')); ?>
                        <?php echo $form->error($model,'asset_purchase_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Transaction Date', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $model,
                            'attribute' => "transaction_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
                                'value'=>date('Y-m-d'),
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo $form->error($model,'transaction_date'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Jumlah Depresiasi', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'amount',array('size'=>18,'maxlength'=>18)); ?>
                        <?php echo $form->error($model,'amount'); ?>
                    </div>
                </div>
            </div>    
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Bulan ke', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'number_of_month',array('size'=>18,'maxlength'=>18)); ?>
                        <?php echo $form->error($model,'number_of_month'); ?>
                    </div>
                </div>
            </div>    
            
            <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->