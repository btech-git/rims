<?php
/* @var $this AssetDepreciationController */
/* @var $assetDepreciation->header AssetDepreciation */
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

    <?php //echo $form->errorSummary($assetDepreciation->header); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Depreciation Period', false); ?>
                    </div>
                    <div class="small-4 columns">
                        <?php echo CHtml::activeDropDownList($assetDepreciation->header, 'depreciation_period_month', array(
                            '1' => 'Jan',
                            '2' => 'Feb',
                            '3' => 'Mar',
                            '4' => 'Apr',
                            '5' => 'May',
                            '6' => 'Jun',
                            '7' => 'Jul',
                            '8' => 'Aug',
                            '9' => 'Sep',
                            '10' => 'Oct',
                            '11' => 'Nov',
                            '12' => 'Dec',
                        )); ?>
                        <?php echo $form->error($assetDepreciation->header,'depreciation_period_month'); ?>
                    </div>
                    <div class="small-4 columns">
                        <?php echo CHtml::activeDropDownList($assetDepreciation->header, 'depreciation_period_year', $assetDepreciation->header->yearsRange); ?>
                        <?php echo $form->error($assetDepreciation->header,'depreciation_period_year'); ?>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="small-12 medium-6 columns">
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('User', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $user = Users::model()->findByPk($assetDepreciation->header->user_id); ?>
                        <?php echo CHtml::encode(CHtml::value($user, 'username')); ?>
                    </div>
                </div>
            </div>    
            
        </div>
        
        <hr />

        <br />

        <div id="detail_div">
            <?php $this->renderPartial('_detailDepreciation', array('assetDepreciation' => $assetDepreciation)); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>

    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->