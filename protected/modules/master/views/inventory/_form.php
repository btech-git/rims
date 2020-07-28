<?php
/* @var $this InventoryController */
/* @var $model Inventory */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/inventory/admin';?>"><span class="fa fa-th-list"></span>Manage Inventory</a>
	<h1><?php if($model->isNewRecord){ echo "New Inventory"; }else{ echo "Update Inventory";}?></h1>

	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'inventory-form',
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

								<?php echo $form->labelEx($model,'product_id'); ?>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($model,'product_id'); ?>
								<?php echo $form->error($model,'product_id'); ?>
							</div>
						</div>
					</div>			
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->labelEx($model,'warehouse_id'); ?>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($model,'warehouse_id'); ?>
								<?php echo $form->error($model,'warehouse_id'); ?>
							</div>
						</div>
					</div>			
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->labelEx($model,'total_stock'); ?>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($model,'total_stock'); ?>
								<?php echo $form->error($model,'total_stock'); ?>

							</div>
						</div>
					</div>			
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->labelEx($model,'minimal_stock'); ?>
							</div>

							<div class="small-8 columns">
								<?php echo $form->textField($model,'minimal_stock'); ?>
								<?php echo $form->error($model,'minimal_stock'); ?>

							</div>
						</div>
					</div>			

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->labelEx($model,'status'); ?>
							</div>

					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
						</div>
					</div>	

					<div class="row buttons">
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
					</div>
				</div>
			</div>		
		</div>

		<?php $this->endWidget(); ?>

</div><!-- form -->