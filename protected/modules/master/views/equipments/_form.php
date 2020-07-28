<?php
/* @var $this EquipmentController */
/* @var $model Equipment */ 
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipments/admin';?>"><span class="fa fa-th-list"></span>Manage Equipments</a>
<h1><?php if($equipment->header->isNewRecord){ echo "New Equipment"; }else{ echo "Update Equipment";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'equipments-form',
			'enableAjaxValidation'=>false,
		));
		Yii::app()->clientscript->registerCoreScript('jquery');
		Yii::app()->clientscript->registerCoreScript('jquery.ui');

 ?>	
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($equipment->header); ?>

   <div class="row">
		<div class="small-12 medium-6 columns">   

		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipment->header,'branch_id'); ?></label>		
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($equipment->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
			               		'prompt' => '[--Select Branch--]')); ?>
						<?php echo $form->error($equipment->header,'branch_id'); ?>
					</div>
				</div>
			 </div>	
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipment->header,'equipment_type_id'); ?></label>		
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($equipment->header, 'equipment_type_id', CHtml::listData(EquipmentType::model()->findAll(), 'id', 'name'),array(
			               		'prompt' => '[--Select Equipment Type--]',
								'onchange' => 'jQuery.ajax({
			                  		type: "POST",
			                  		//dataType: "JSON",
			                  		url: "' . CController::createUrl('ajaxGetEquipmentSubType') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                        	jQuery("#Equipments_equipment_sub_type_id").html(data);
			                        	/*if(jQuery("#Product_product_sub_master_category_id").val() == ""){
			                        		jQuery(".additional-specification").slideUp();
					    					jQuery("#Product_product_sub_category_id").html("<option value=\"\">[--Select Product Sub Category--]</option>");
					    				}*/
			                    	},
			                	});'
							)
						);?>
						<?php echo $form->error($equipment->header,'equipment_type_id'); ?>
					</div>
				</div>
			 </div>	
			 
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipment->header,'equipment_sub_type_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($equipment->header, 'equipment_sub_type_id', CHtml::listData(EquipmentSubType::model()->findAll(), 'id', 'name'),array(
			               		'prompt' => '[--Select Equipment Sub Type--]')); ?>
						<?php echo $form->error($equipment->header,'equipment_sub_type_id'); ?>
					</div>
				</div>
			 </div>	
			
		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipment->header,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($equipment->header,'name',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($equipment->header,'name'); ?>
					</div>
				</div>
			 </div>		 
		
   
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipment->header,'status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($equipment->header, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($equipment->header,'status'); ?>
					</div>
				</div>
			 </div>	  
		</div>
   <!-- begin RIGHT -->
	<div class="small-12 medium-5b columns">
   <!-- start of branch-->
		<!--<div class="row">
			<?php /*echo CHtml::button('Add Equipment Branch', array(
								'id' => 'detail-branch-button',
								'name' => 'Detail',
								'class'=>'button extra right',
								'onclick' => '
									
									jQuery("#branch-dialog").dialog("open"); return false;',

								)
							); 
							$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
								'id' => 'branch-dialog',
								// additional javascript options for the dialog plugin
								'options' => array(
									'title' => 'Branch',
									'autoOpen' => false,
									'width' => 'auto',
									'modal' => true,
								),));
							
							$this->widget('zii.widgets.grid.CGridView', array(
								'id'=>'branch-grid',
								'dataProvider'=>$branchDataProvider,
								'filter'=>$branch,
								'summaryText'=>'',
								
								'columns'=>array(
									 array(
											'name' => 'check',
											'id' => 'selectedIds',
											'value' => '$data->id',
											'class' => 'CCheckBoxColumn',
											'selectableRows' => '100',	
											'checkBoxHtmlOptions' => array(
																		 'onclick' => 'js: if($(this).is(":checked")==true){
																					var checked_val= $(this).val();
																					
																					var selected_branch = $(this).parent("td").siblings("td").html();
																					var myArray = [];

																					jQuery("#branch tr").each(function(){													
																						var savedBranches = $(this).find("input[type=text]").val();																						
																						myArray.push(savedBranches); 
																					});
																					if(jQuery.inArray(selected_branch, myArray)!= -1) {
																						alert("Please select other branch, this is already added");
																						return false;
																					} else {
																						
																							$.ajax({
																							type: "POST",
																							//dataType: "JSON",
																							url: "' . CController::createUrl('ajaxHtmlAddBranchDetail', array()) . '/id/'.$equipment->header->id.'/branchId/"+$(this).val(),
																							data: $("form").serialize(),
																							success: function(html) {
																								$("#branch").html(html);	
																								//$.fn.yiiGridView.update("#branch-grid");
																							},
																						});
																						$(this).parent("td").parent("tr").addClass("checked");
																						$(this).parent("td").parent("tr").removeClass("unchecked");
																					}
																				
																					
																			}else{
																					var unselected_branch = $(this).parent("td").siblings("td").html();
																					var myArray = [];
																					var count = 0;
																					jQuery("#branch tr").each(function(){													
																						var savedBranch = $(this).find("input[type=text]").val();																						
																						myArray.push(savedBranch);																						
																						if(unselected_branch==savedBranch){
																							index_id = count-1;																		
																						}
																						count++;
																					});
																					if(jQuery.inArray(unselected_branch, myArray)!= -1) {
																					
																						$.ajax({
																							type: "POST",
																							//dataType: "JSON",
																							url: "' . CController::createUrl('ajaxHtmlRemoveBranchDetail', array()) . '/id/'.$equipment->header->id.'/branch_name/"+unselected_branch+"/index/"+index_id,
																							data: $("form").serialize(),
																							success: function(html) {
																								$("#branch").html(html);																							
																							},
																							update:"#branch",
																						});
																					} 
																				
																					
																					$(this).parent("td").parent("tr").removeClass("checked");
																					$(this).parent("td").parent("tr").addClass("unchecked");
																			}'
																		),											
										),
									'code',
									'name'
									
								),
							)); */?>
							<?php //$this->endWidget(); ?>
			
					<div class="grid-view" id="branch" >
					<h2>Equipment Branch</h2>
					<?php //$this->renderPartial('_detailBranch', array('equipment'=>$equipment
							//)); ?>
					<div class="clearfix"></div><div style="display:none" class="keys"></div>
			</div>		
		</div>--><!-- end of branch-->
		
		<!-- Details form-->
		<div class="row">
			<?php echo CHtml::button('Add Equipment Details', array(
							'id' => 'detail-button',
							'name' => 'Detail',
							'class'=>'button extra right',
							'onclick' => '
								jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddBranchDetail', array('id' => $equipment->header->id)) . '",
									data: jQuery("form").serialize(),
									success: function(html) {
										jQuery("#eq_detail").html(html);
									},
								});',

							)
						); ?>
			<h2>Equipment Details</h2>
			<div id="eq_detail">
					<?php $this->renderPartial('_equipmentDetails', array('equipment'=>$equipment
						)); ?>
			</div>
		</div>
		<!-- End of Details form-->
		
		
		<!-- Task form-->
		<div class="row">
			<?php echo CHtml::button('Add Equipment Task', array(
							'id' => 'task-detail-button',
							'name' => 'TaskDetail',
							'class'=>'button extra right',
							'onclick' => '
								jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddTaskDetail', array('id' => $equipment->header->id)) . '",
									data: jQuery("form").serialize(),
									success: function(html) {
										jQuery("#task").html(html);
									},
								});',

							)
						); ?>
			<h2>Equipment Task</h2>
			<div id="task">
					<?php $this->renderPartial('_detailTask', array('equipment'=>$equipment
						)); ?>
			</div>
		</div>
		<!-- End of Task form-->
	
	<div></div>


<!-- end RIGHT -->		



      </div>
   </div>
	<hr>

<div class="field buttons text-center">
	<?php echo CHtml::submitButton($equipment->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	

<script type="text/javascript">
	$(function() {
		$(".date_picker").each(function(){
			$(this).datepicker({"dateFormat": "yy-mm-dd"}); 
		});
	});
	</script>