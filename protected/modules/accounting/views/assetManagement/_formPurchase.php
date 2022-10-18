<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-purchase-form',
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
                        <?php echo CHtml::label('Category', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'asset_category_id', CHtml::listData(AssetCategory::model()->findAll(),'id','description'), array('empty' => '-- Pilih Category --')); ?>
                        <?php echo $form->error($model,'asset_category_id'); ?>
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
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo $form->error($model,'transaction_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Item Description', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'description'); ?>
                        <?php echo $form->error($model,'description'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Harga Beli', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'purchase_value',array('size'=>18,'maxlength'=>18)); ?>
                        <?php echo $form->error($model,'purchase_value'); ?>
                    </div>
                </div>
            </div>    
            
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal Mulai Depresiasi', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $model,
                            'attribute' => "depreciation_start_date",
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
                        <?php echo $form->error($model,'depreciation_start_date'); ?>
                    </div>
                </div>
            </div>
            
<!--            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php /*echo CHtml::label('Tanggal Akhir Depresiasi', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $model,
                            'attribute' => "depreciation_end_date",
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
                        <?php echo $form->error($model,'depreciation_end_date');*/ ?>
                    </div>
                </div>
            </div>-->
            
<!--            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php /*echo CHtml::label('Status', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'status'); ?>
                        <?php echo $form->error($model,'status');*/ ?>
                    </div>
                </div>
            </div>-->
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Payment Bank', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => 7)),'id','bank.name'), array('empty' => '-- Pilih Bank --')); ?>
                        <?php echo $form->error($model,'company_bank_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Note', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model,'note', array('rows' => 5, 'column' => 20)); ?>
                        <?php echo $form->error($model,'note'); ?>
                    </div>
                </div>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>

        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->