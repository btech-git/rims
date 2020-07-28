<?php
/* @var $this InspectionSectionController */
/* @var $model InspectionSection */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/inspectionSection/admin';?>"><span class="fa fa-th-list"></span>Manage Inspection Sections</a>
<h1><?php if($section->header->isNewRecord){ echo "New Inspection Section"; }else{ echo "Update Inspection Section";}?></h1>
<!-- begin FORM -->

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'inspection-section-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($section->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"> <?php echo $form->labelEx($section->header,'code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($section->header,'code'); ?>
						<?php echo $form->error($section->header,'code'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($section->header,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($section->header,'name',array('size'=>50,'maxlength'=>50)); ?>
						<?php echo $form->error($section->header,'name'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="small-12 medium-5b columns">
			<?php echo CHtml::button('Add Module', array(
				'id' => 'module-button',
				'name' => 'Detail',
				'class'=>'button extra right',
				'onclick' => '
					jQuery("#module-dialog").dialog("open"); return false;',

				)
			); ?>
			<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id' => 'module-dialog',
				// additional javascript options for the dialog plugin
				'options' => array(
					'title' => 'Module',
					'autoOpen' => false,
					'width' => 'auto',
					'modal' => true,
				),));
			?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'module-grid',
				'dataProvider'=>$moduleDataProvider,
				'filter'=>$module,
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
						url: "' . CController::createUrl('ajaxHtmlAddModuleDetail', array('id'=>$section->header->id,'moduleId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
						data: $("form").serialize(),
						success: function(html) {
							jQuery("#module").html(html);
						},
					});

					$("#module-grid").find("tr.selected").each(function(){
	                  	$(this).removeClass( "selected" );
	                });
				}',
				'columns'=>array(
					array(
						'name' => 'check',
						'id' => 'selectedIds',
						'value' => '$data->id',
						'class' => 'CCheckBoxColumn',
						'checked' => function($data) use($moduleArray) {
	                        return in_array($data->id, $moduleArray); 
	                    }, 
						'selectableRows' => '100',	
						'checkBoxHtmlOptions' => array(
							'onclick' => 'js: if($(this).is(":checked")==true){
								var checked_val= $(this).val();
													
								var selected_warehouse = $(this).parent("td").siblings("td").html();
								var myArray = [];

								jQuery("#module tr").each(function(){													
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
										url: "' . CController::createUrl('ajaxHtmlAddModuleDetail', array()) . '/id/'.$section->header->id.'/moduleId/"+$(this).val(),
										data: $("form").serialize(),
										success: function(html) {
											jQuery("#module").html(html);
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
								jQuery("#module tr").each(function(){													
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
										url: "' . CController::createUrl('ajaxHtmlRemoveModuleDetail', array()) . '/id/'.$section->header->id.'/index/"+index_id,
										data: $("form").serialize(),
										success: function(html) {
											$("#module").html(html);																							
										},
										update:"#module",
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

			<h2>Module</h2>
			<div class="grid-view" id="module" >
				<?php $this->renderPartial('_detailModule', array('section'=>$section)); ?>
				<div class="clearfix"></div><div style="display:none" class="keys"></div>
			</div>
		</div>
	</div>



	<hr>
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($section->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

