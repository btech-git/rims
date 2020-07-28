<?php
/* @var $this EquipmentDetailsController */
/* @var $equipmentDetail EquipmentDetails */
/* @var $form CActiveForm */
?>
<?php foreach ($equipment->equipmentDetails as $i => $equipmentDetail): ?>

		
			<!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					<label class="prefix">
						<?php //echo CHtml::activeLabelEx($equipmentDetail,"[$i]equipment_id"); ?>
						
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($equipmentDetail,'equipment_id'); ?>
						<?php  //echo CHtml::activeDropDownList($equipmentDetail, "[$i]equipment_id", CHtml::listData(Equipments::model()->findAll(), 'id', 'name'),array(
								//		'prompt' => '[--Select Equipments--]'));?>
					</div>
				</div>
			 </div>	-->	 
		     
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					<label class="prefix">
						<?php  echo CHtml::activeLabelEx($equipmentDetail,"[$i]equipment_code"); ?>
					</div>
					<div class="small-8 columns">
						<?php  echo CHtml::activeTextField($equipmentDetail,"[$i]equipment_code",array('size'=>60,'maxlength'=>100)); ?>
						<?php //echo $form->error($equipmentDetail,'[$i]equipment_code'); ?>
					</div>
				</div>
			 </div>		 
		

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					    <label class="prefix">
							<?php echo CHtml::activeLabelEx($equipmentDetail,"[$i]brand"); ?>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($equipmentDetail,"[$i]brand",array('size'=>60,'maxlength'=>100)); ?>
						<?php //echo $form->error($equipmentDetail,'[$i]brand'); ?>
					</div>
				</div>
			 </div>		 
		        
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">
					<?php echo CHtml::activeLabelEx($equipmentDetail,"[$i]purchase_date"); ?>
					</div>
					<div class="small-8 columns">
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $equipmentDetail,
											 'attribute' => "[$i]purchase_date",
											 // additional javascript options for the date picker plugin
											 'options'=>array(
												'dateFormat' => 'yy-mm-dd',
												'changeMonth'=>true,
												 'changeYear'=>true,
												 'yearRange'=>'1900:2020',															 
												
											),	
											'htmlOptions'=>array(
													'onchange'=>  'jQuery.ajax({
																type: "POST",
																//dataType: "JSON",
																url: "' . CController::createUrl('ajaxGetAge') .'/purchase_date/"+$(this).val() ,
																data: jQuery("form").serialize(),
																success: function(data){
																	//alert(data)
																	jQuery("#EquipmentDetails_'.$i.'_age").val(data);
																},
															});',
															'placeholder' => 'Purchase Date',
															'class'=>'date_picker',
													),
										 )); ?>
					<?php //echo $form->error($equipmentDetail,'[$i]purchase_date'); ?>
				</div>
				</div>
			 </div>	
			 
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">
						<?php echo CHtml::activeLabelEx($equipmentDetail,"[$i]age"); ?>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($equipmentDetail,"[$i]age"); ?>
						<?php //echo $form->error($equipmentDetail,'[$i]age'); ?>
					</div>
				</div>
			 </div>		 
		       
			 <!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">
						<?php //echo CHtml::activeLabelEx($equipmentDetail,"[$i]quantity"); ?>
					</div>
					<div class="small-8 columns">
						<?php //echo CHtml::activeTextField($equipmentDetail,"[$i]quantity"); ?>
						<?php // echo $form->error($equipmentDetail,'[$i]quantity'); ?>
					</div>
				</div>
			 </div> -->		 
		      
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">
						<?php echo CHtml::activeLabelEx($equipmentDetail,"[$i]status"); ?>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeDropDownList($equipmentDetail, "[$i]status", array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php //echo $form->error($equipmentDetail,'[$i]status'); ?>
					</div>
				</div>
			 </div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">						
					</div>
					<div class="small-8 columns">
						<?php
						echo CHtml::button('X', array(
							'class' =>'button extra right',
							'onclick' => CHtml::ajax(array(
								'type' => 'POST',
								'url' => CController::createUrl('ajaxHtmlRemoveBranchDetail', array('id' => $equipment->header->id, 'index' => $i)),
								'update' => '#eq_detail',
							)),
						));
					?>	
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<br/>