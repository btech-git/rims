<?php
/* @var $this InspectionChecklistTypeController */
/* @var $model InspectionChecklistType */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/inspectionChecklistType/admin';?>"><span class="fa fa-th-list"></span>Manage Inspection Checklist Types</a>
<h1><?php if($checklistType->header->isNewRecord){ echo "New Inspection Checklist Type"; }else{ echo "Update Inspection Checklist Type";}?></h1>
<!-- begin FORM -->

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'inspection-checklist-type-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($checklistType->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"> <?php echo $form->labelEx($checklistType->header,'code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($checklistType->header,'code'); ?>
						<?php echo $form->error($checklistType->header,'code'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($checklistType->header,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($checklistType->header,'name',array('size'=>50,'maxlength'=>50)); ?>
						<?php echo $form->error($checklistType->header,'name'); ?>
					</div>
				</div>
			</div>
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($checklistType->header,'type'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'type',array('size'=>50,'maxlength'=>50)); ?>
						<?php echo $form->dropDownList($checklistType->header,'type',array('Radio'=>'Radio','Text'=>'Text')); ?>
						<?php echo $form->error($checklistType->header,'type'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($checklistType->header,'show_label'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'type',array('size'=>50,'maxlength'=>50)); ?>
						<?php echo $form->dropDownList($checklistType->header,'show_label',array('Yes'=>'Yes','No'=>'No')); ?>
						<?php echo $form->error($checklistType->header,'show_label'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="small-12 medium-5b columns">
			<?php echo CHtml::button('Add Checklist Module', array(
				'id' => 'checklist-module-button',
				'name' => 'Detail',
				'class'=>'button extra right',
				'onclick' => '
					jQuery("#checklist-module-dialog").dialog("open"); return false;',

				)
			); ?>
			<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id' => 'checklist-module-dialog',
				// additional javascript options for the dialog plugin
				'options' => array(
					'title' => 'Checklist Module',
					'autoOpen' => false,
					'width' => 'auto',
					'modal' => true,
				),));
			?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'checklist-module-grid',
				'dataProvider'=>$checklistModuleDataProvider,
				'filter'=>$checklistModule,
				//'summaryText'=>'',
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
				'selectionChanged'=>'js:function(id){
					
					$.ajax({
						type: "POST",
						//dataType: "JSON",
						url: "' . CController::createUrl('ajaxHtmlAddChecklistModuleDetail', array('id'=>$checklistType->header->id,'checklistModuleId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
						data: $("form").serialize(),
						success: function(html) {
							jQuery("#checklistModule").html(html);
						},
					});
					$("#checklist-module-grid").find("tr.selected").each(function(){
	                  	$(this).removeClass( "selected" );
	                });
				}',
				'columns'=>array(
					array(
						'name' => 'check',
						'id' => 'selectedIds',
						'value' => '$data->id',
						'class' => 'CCheckBoxColumn',
						'checked' => function($data) use($checklistModuleArray) {
	                        return in_array($data->id, $checklistModuleArray); 
	                    }, 
						'selectableRows' => '100',	
						'checkBoxHtmlOptions' => array(
							'onclick' => 'js: if($(this).is(":checked")==true){
								var checked_val= $(this).val();
													
								var selected_warehouse = $(this).parent("td").siblings("td").html();
								var myArray = [];

								jQuery("#checklistModule tr").each(function(){													
									var savedWar = $(this).find("input[type=hidden]").val();							
									myArray.push(savedWar); 
								});
													
								if(jQuery.inArray(selected_warehouse, myArray)!= -1) {
									alert("Please select other Checklist Module, this is already added");
									return false;
								} else {
														
									$.ajax({
										type: "POST",
										//dataType: "JSON",
										url: "' . CController::createUrl('ajaxHtmlAddChecklistModuleDetail', array()) . '/id/'.$checklistType->header->id.'/checklistModuleId/"+$(this).val(),
										data: $("form").serialize(),
										success: function(html) {
											jQuery("#checklistModule").html(html);
										},
									});

									$(this).parent("td").parent("tr").addClass("checked");
									$(this).parent("td").parent("tr").removeClass("unchecked");
								}
												
													
							}else{
								var unchecked_val= $(this).val();
													
								var unselected_warehouse = $(this).parent("td").siblings("td").html();
								var myArray = [];
								var count = 0;
								jQuery("#checklistModule tr").each(function(){													
									var savedWar = $(this).find("input[type=hidden]").val();																						
									myArray.push(savedWar);																						
									if(unchecked_val==savedWar){
										index_id = count-1;																	
									}
									count++;
								});
								if(jQuery.inArray(unchecked_val, myArray)!= -1) {
												
									$.ajax({
										type: "POST",
										//dataType: "JSON",
										url: "' . CController::createUrl('ajaxHtmlRemoveChecklistModuleDetail', array()) . '/id/'.$checklistType->header->id.'/index/"+index_id,
										data: $("form").serialize(),
										success: function(html) {
											$("#checklistModule").html(html);																							
										},
										update:"#checklistModule",
									});
								} 
											
												
								$(this).parent("td").parent("tr").removeClass("checked");
								$(this).parent("td").parent("tr").addClass("unchecked");
							}'
						),											
					),
					'name'
				),
			));?>
			<?php $this->endWidget(); ?>

			<h2>Checklist Module</h2>
			<div class="grid-view" id="checklistModule" >
				<?php $this->renderPartial('_detailChecklistModule', array('checklistType'=>$checklistType)); ?>
				<div class="clearfix"></div><div style="display:none" class="keys"></div>
			</div>
		</div>
	</div>



	<hr>
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($checklistType->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->