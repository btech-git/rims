<?php
/* @var $this InventoryController */
/* @var $model Inventory */
/* @var $form CActiveForm */
?>
<div class="wide form" id="advSearch">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		)); ?>

		<div class="row">
			<div class="small-12 medium-6 columns">

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'id',array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'id'); ?>
						</div>
					</div>
				</div>	


				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'product_name',array('class'=>'prefix'));?>	
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'product_name'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'manufacturer_code',array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'manufacturer_code'); ?>
						</div>
					</div>
				</div>	

			</div>
			<div class="small-12 medium-6 columns">

				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'total_stock',array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'total_stock'); ?>
						</div>
					</div>
				</div>	
				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'minimal_stock',array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'minimal_stock'); ?>
						</div>
					</div>
				</div>	
				<!-- BEGIN FIELDS -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'status',array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
							'Inactive' => 'Inactive', ), array('prompt' => 'Select',)); ?>
						</div>
					</div>
				</div>	


				<div class="row buttons text-right">
					<?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
				</div>
			</div>
		</div>
		<?php $this->endWidget(); ?>

</div><!-- search-form -->