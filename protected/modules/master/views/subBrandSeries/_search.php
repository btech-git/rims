<?php
/* @var $this SubBrandSeriesController */
/* @var $model SubBrandSeries */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		)); ?>
		<div class="row">
			<div class="small-12 medium-6 columns">
				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'sub_brand_id', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',)); ?>
						</div>
					</div>
				</div>
				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'name', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>

				<div class="row buttons text-right">
					<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
				</div>
			</div>
		</div>

		<?php $this->endWidget(); ?>

</div><!-- search-form -->