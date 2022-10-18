<?php
/* @var $this AssetSaleController */
/* @var $model AssetSale */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-sale-form',
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
                        <?php echo CHtml::encode(CHtml::value($model, 'assetPurchase.description')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Purchase #', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'assetPurchase.transaction_number')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Purchase Date', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'assetPurchase.transaction_date')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Category', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'assetPurchase.assetCategory.description')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Harga Beli', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'assetPurchase.purchase_value'))); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Akumulasi Depresiasi', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'assetPurchase.accumulated_depreciation_value'))); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Nilai Sekarang', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'assetPurchase.current_value'))); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Lama Depresiasi (Bulan)', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'assetPurchase.monthly_useful_life')); ?>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="small-12 medium-6 columns">
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
                        <?php echo CHtml::label('Harga Jual', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'sale_price',array('size'=>18,'maxlength'=>18)); ?>
                        <?php echo $form->error($model,'sale_price'); ?>
                    </div>
                </div>
            </div>    
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Payment Bank', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => 7)), 'id', 'bank.name'), array('empty' => '-- Pilih Bank --')); ?>
                        <?php echo $form->error($model,'company_bank_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('note', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model,'note'); ?>
                        <?php echo $form->error($model,'note'); ?>
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