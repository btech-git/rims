<?php
/* @var $this InspectionController */
/* @var $model Inspection */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/inspection/admin';?>"><span class="fa fa-th-list"></span>Manage Inspections</a>
<h1><?php if($inspection->header->isNewRecord){ echo "New Inspection"; }else{ echo "Update Inspection";}?></h1>
<!-- begin FORM -->

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'inspection-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($inspection->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"> <?php echo $form->labelEx($inspection->header,'code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($inspection->header,'code'); ?>
						<?php echo $form->error($inspection->header,'code'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($inspection->header,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($inspection->header,'name',array('size'=>50,'maxlength'=>50)); ?>
						<?php echo $form->error($inspection->header,'name'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="small-12 medium-5b columns">
			<?php echo CHtml::button('Add Section', array(
				'id' => 'section-button',
				'name' => 'Detail',
				'class'=>'button extra right',
				'onclick' => '
					jQuery("#section-dialog").dialog("open"); return false;',

				)
			); ?>
			<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id' => 'section-dialog',
				// additional javascript options for the dialog plugin
				'options' => array(
					'title' => 'Section',
					'autoOpen' => false,
					'width' => 'auto',
					'modal' => true,
				),));
			?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'section-grid',
				'dataProvider'=>$sectionDataProvider,
				'filter'=>$section,
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
						url: "' . CController::createUrl('ajaxHtmlAddSectionDetail', array('id'=>$inspection->header->id,'sectionId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
						data: $("form").serialize(),
						success: function(html) {
							jQuery("#section").html(html);
						},
					});

					$("#section-grid").find("tr.selected").each(function(){
	                  	$(this).removeClass( "selected" );
	                });
				}',
				'columns'=>array(
					array(
						'name' => 'check',
						'id' => 'selectedIds',
						'value' => '$data->id',
						'class' => 'CCheckBoxColumn',
						'checked' => function($data) use($sectionArray) {
	                        return in_array($data->id, $sectionArray); 
	                    }, 
						'selectableRows' => '100',	
						'checkBoxHtmlOptions' => array(
							'onclick' => 'js: if($(this).is(":checked")==true){
								var checked_val= $(this).val();
													
								var selected_warehouse = $(this).parent("td").siblings("td").html();
								var myArray = [];

								jQuery("#section tr").each(function(){													
									var savedWar = $(this).find("input[type=hidden]").val();							
									myArray.push(savedWar); 
								});
													
								if(jQuery.inArray(selected_warehouse, myArray)!= -1) {
									alert("Please select other Section, this is already added");
									return false;
								} else {
														
									$.ajax({
										type: "POST",
										//dataType: "JSON",
										url: "' . CController::createUrl('ajaxHtmlAddSectionDetail', array()) . '/id/'.$inspection->header->id.'/sectionId/"+$(this).val(),
										data: $("form").serialize(),
										success: function(html) {
											jQuery("#section").html(html);
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
								jQuery("#section tr").each(function(){													
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
										url: "' . CController::createUrl('ajaxHtmlRemoveSectionDetail', array()) . '/id/'.$inspection->header->id.'/index/"+index_id,
										data: $("form").serialize(),
										success: function(html) {
											$("#section").html(html);																							
										},
										update:"#section",
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

			<h2>Section</h2>
			<div class="grid-view" id="section" >
				<?php $this->renderPartial('_detailSection', array('inspection'=>$inspection)); ?>
				<div class="clearfix"></div><div style="display:none" class="keys"></div>
			</div>
		</div>
	</div>



	<hr>
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($inspection->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->