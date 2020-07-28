<?php
/* @var $this ServiceTypeController */
/* @var $model ServiceType */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/serviceType/admin';?>"><span class="fa fa-th-list"></span>Manage Service Types</a>
<h1><?php if($model->isNewRecord){ echo "New Service Type"; }else{ echo "Update Service Type";}?></h1>
<!-- begin FORM -->
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'service-type-form',
	'enableAjaxValidation'=>false,
)); ?>

	
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'code'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>

   <div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>100,'maxlength'=>100)); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>

   <div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>
   <div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'coa_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($model,'coa_id'); ?>
						<?php echo $form->textField($model,'coa_name',array('readonly'=>true,'value'=>$model->coa_id !=""? $model->coa->name : "",'onclick'=>'jQuery("#coa-dialog").dialog("open"); return false;')); ?>
						<?php echo $form->textField($model,'coa_code',array('readonly'=>true,'value'=>$model->coa_id !=""? $model->coa->code : "")); ?>
						<?php echo $form->error($model,'coa_id'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>

    <div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'coa_diskon_service'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($model,'coa_diskon_service'); ?>
						<?php echo $form->textField($model,'coa_diskon_service_name',array('readonly'=>true,'value'=>$model->coa_diskon_service !=""? $model->coaDiskonService->name : "",'onclick'=>'jQuery("#coa-diskon-dialog").dialog("open"); return false;')); ?>
						<?php echo $form->textField($model,'coa_diskon_service_code',array('readonly'=>true,'value'=>$model->coa_diskon_service !=""? $model->coaDiskonService->code : "")); ?>
						<?php echo $form->error($model,'coa_diskon_service'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>

		<hr>


	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	
<!--COA Service Category-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'coa-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'COA',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
		),));
	?>

	
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-grid',
		'dataProvider'=>$coaDataProvider,
		'filter'=>$coa,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#coa-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ServiceType_coa_id").val(data.id);
					$("#ServiceType_coa_code").val(data.code);
					$("#ServiceType_coa_name").val(data.name);
					
				},
			});
			$("#coa-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=>
		//$coumns
		array(
			'name',
			'code',
			
		),
	)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<!--COA Diskon Service Category-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'coa-diskon-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'COA Diskon',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
		),));
	?>

	
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-diskon-grid',
		'dataProvider'=>$coaDiskonDataProvider,
		'filter'=>$coaDiskon,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#coa-diskon-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ServiceType_coa_diskon_service").val(data.id);
					$("#ServiceType_coa_diskon_service_code").val(data.code);
					$("#ServiceType_coa_diskon_service_name").val(data.name);
					
				},
			});
			$("#coa-diskon-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=>
		//$coumns
		array(
			'name',
			'code',
			
		),
	)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>