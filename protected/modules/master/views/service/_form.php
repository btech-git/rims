<?php
/* @var $this ServiceController */
/* @var $service->header Service */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/service/admin';?>"><span class="fa fa-th-list"></span>Manage Services</a>
	<h1><?php if($service->header->isNewRecord){ echo "New Service"; }else{ echo "Update Service";}?></h1>
	<!-- begin FORM -->
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'service-form',
		'htmlOptions'=>array('class'=>'form'),
		'enableAjaxValidation'=>false,
	)); ?>

	<hr />
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
   <div class="row">
		<div class="small-12 medium-6 columns">         
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'service_type_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($service->header,'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'),array('prompt'=>'[--Select Service Type --]','onchange'=> '
								if($("#Service_service_type_id").val() == "2"){
									$(".bodyrepair").show();
								}
								else{
									$(".bodyrepair").hide();
								}
								jQuery.ajax({

									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetServiceCategory') . '" ,
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#Service_service_category_id").html(data);
			                        	jQuery("#Service_code").val(" ");
		                        	},
									});'
						));?>
						<?php echo $form->error($service->header,'service_type_id'); ?>
					</div>
				</div>
			 </div>		 
	
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'service_category_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($service->header,'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'),array('prompt'=>'[--Select Service Category --]',
							'onchange'=> 'jQuery.ajax({
			                  		type: "POST",
			                  		url: "' . CController::createUrl('ajaxGetCode') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                        	jQuery("#Service_code").val(data);
			                        	
			                    	},
			                	});'
						));?>
						<?php echo $form->error($service->header,'service_category_id'); ?>
					</div>
				</div>
			 </div>		 
		

	
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'code', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($service->header,'code',array('size'=>20,'maxlength'=>20,'readonly'=>true)); ?>
						<?php echo $form->error($service->header,'code'); ?>
					</div>
				</div>
			 </div>		 
		

   
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'name', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($service->header,'name',array('size'=>100,'maxlength'=>100)); ?>
						<?php echo $form->error($service->header,'name'); ?>
					</div>
				</div>
			 </div>		 
		

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'description', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($service->header,'description',array('size'=>60,'maxlength'=>60)); ?>
						<?php echo $form->error($service->header,'description'); ?>
					</div>
				</div>
			 </div>		 
		

   
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'difficulty_level', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($service->header,'difficulty_level',array(1=>'Basic',2=>'Medium',3=>'Hard'),array('prompt'=>'[--Select Difficulty Level--]')); ?>
						<?php echo $form->error($service->header,'difficulty_level'); ?>
					</div>
				</div>
			 </div>		 
			
			<div class="field">
				<div class="row collapse">
					<div class="small-12 columns">
						<?php
						    echo CHtml::button('Set Default Value', array(
						    	'id' => 'setValue',
						     	'onclick' =>'
												
									$.ajax({
                                    type: "POST",
                                   
                                    url: "' . CController::createUrl('ajaxSetValue', array()) .'",
                                    data: $("form").serialize(),
                                    dataType: "json",
                                    success: function(data) {
                                        $("#Service_difficulty").val(data.difficulty);
                                        $("#Service_difficulty_value").val(data.difficulty_value);
                                        $("#Service_regular").val(data.regular);
                                        $("#Service_luxury").val(data.luxury);
                                        $("#Service_luxury_value").val(data.luxury_value);
                                        $("#Service_luxury_calc").val(data.luxury_calc);
                                        $("#Service_flat_rate_hour").val(data.flat_rate_hour);
                                        $("#Service_standard_rate_per_hour").val(data.standard_rate);

                                    },

                                });
					
						     	'));
						?>
					</div>
				</div>
			</div>

			 <?php $servicePrice = GeneralStandardValue::model()->findByPK(1); ?>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'difficulty', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($service->header,'difficulty',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $servicePrice->difficulty : $service->header->difficulty)); ?>
						<?php echo $form->error($service->header,'difficulty'); ?>
					</div>
				</div>
			</div>		

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($service->header,'difficulty_value', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
					
						<?php echo $form->textField($service->header,'difficulty_value',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $servicePrice->difficulty_value : $service->header->difficulty_value)); ?>
						<?php echo $form->error($service->header,'difficulty_value'); ?>
					</div>
				</div>
			</div>		

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					 	<?php echo $form->labelEx($service->header,'regular', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
					
						<?php echo $form->textField($service->header,'regular',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $servicePrice->regular : $service->header->regular)); ?>
						<?php echo $form->error($service->header,'regular'); ?>
					</div>
				</div>
			</div>		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($service->header,'luxury', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
					
						<?php echo $form->textField($service->header,'luxury',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $servicePrice->luxury : $service->header->luxury)); ?>
						<?php echo $form->error($service->header,'luxury'); ?>
					</div>
				</div>
			</div>		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					 	<?php echo $form->labelEx($service->header,'luxury_value', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
					
						<?php echo $form->textField($service->header,'luxury_value',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $servicePrice->luxury_value : $service->header->luxury_value)); ?>
						<?php echo $form->error($service->header,'luxury_value'); ?>
					</div>
				</div>
			</div>		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($service->header,'luxury_calc', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						
						<?php echo $form->textField($service->header,'luxury_calc',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $servicePrice->luxury_calc : $service->header->luxury_calc)); ?>
						<?php echo $form->error($service->header,'luxury_calc'); ?>
					</div>
				</div>
			</div>		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'standard_rate_per_hour', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
					
						<?php $standardRate = GeneralStandardFr::model()->findByPK(1); ?>
						<?php echo $form->textField($service->header,'standard_rate_per_hour',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $standardRate->flat_rate : $service->header->standard_rate_per_hour)); ?>
						<?php echo $form->error($service->header,'standard_rate_per_hour'); ?>
					</div>
				</div>
			</div>
			<div class="bodyrepair">
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'bongkar', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'bongkar',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'bongkar'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'sparepart', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'sparepart',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'sparepart'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'ketok_las', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'ketok_las',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'ketok_las'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'dempul', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'dempul',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'dempul'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'epoxy', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'epoxy',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'epoxy'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'cat', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'cat',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'cat'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'pasang', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'pasang',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'pasang'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'poles', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'poles',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'poles'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'cuci', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
						
							<?php echo $form->textField($service->header,'cuci',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'cuci'); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($service->header,'finishing', array('class'=>'prefix')); ?>
						</div>
						<div class="small-5 columns">
						
							<?php echo $form->textField($service->header,'finishing',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($service->header,'finishing'); ?>
						</div>
						<div class="small-3 columns">
								<?php
								    echo CHtml::button('Recount Hr', array(
								    	'id' => 're_count',
								     	'onclick' =>'
								     		
								     		var total = (+$("#Service_bongkar").val()) + (+$("#Service_sparepart").val()) + (+$("#Service_ketok_las").val()) + (+$("#Service_dempul").val()) + (+$("#Service_epoxy").val()) + (+$("#Service_cat").val()) + (+$("#Service_pasang").val()) + (+$("#Service_poles").val()) + (+$("#Service_cuci").val()) + (+$("#Service_finishing").val());
								     		console.log(total);
								     		$("#Service_flat_rate_hour").val(total);
															
							
								     	'));
								?>
							</div>
					</div>
				</div>
			</div>		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'flat_rate_hour', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
					
						<?php echo $form->textField($service->header,'flat_rate_hour',array('size'=>10,'maxlength'=>10,'value'=>$service->header->isNewRecord ? $servicePrice->flat_rate_hour : $service->header->flat_rate_hour)); ?>
						<?php echo $form->error($service->header,'flat_rate_hour'); ?>
					</div>
				</div>
			</div>		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'price', array('class'=>'prefix')); ?>
					</div>

					<div class="small-8 columns">
						<div class="row collapse">
							<div class="small-2 columns">
								<?php
								    echo CHtml::button('Count', array(
								    	'id' => 'count',
								     	'onclick' =>'
															var diff = +$("#Service_difficulty_value").val();
																			var lux = +$("#Service_luxury_calc").val();
																			var standard = +$("#Service_standard_rate_per_hour").val();
																			var fr = +$("#Service_flat_rate_hour").val();
																			$.ajax({
		                                    type: "POST",
		                                   
		                                    url: "' . CController::createUrl('ajaxGetPrice', array()) . '/diff/" +diff+"/lux/"+lux+"/standard/"+standard+"/fr/"+fr,
		                                    data: $("form").serialize(),
		                                    dataType: "json",
		                                    success: function(data) {
		                                    		console.log(data.diff);
		                                    		console.log(data.lux);
		                                    		console.log(data.standard);
		                                    		console.log(data.fr);
		                                        console.log(data.price);
		                                        $("#Service_price").val(data.price);
		                                    },

		                                });
							
								     	'));
								?>
							</div>
							<div class="small-10 columns">
								<?php echo $form->textField($service->header,'price',array('size'=>10,'maxlength'=>10)); ?>
								<?php echo $form->error($service->header,'price'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'common_price', array('class'=>'prefix')); ?>
					</div>
					
					<div class="small-8 columns">
						<?php echo $form->textField($service->header,'common_price',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($service->header,'common_price'); ?>
					</div>
				</div>
			</div>		
   

   
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($service->header,'status', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($service->header, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($service->header,'status'); ?>
					</div>
				</div>
			 </div>	
			 <div>
					 <?php echo CHtml::button('Add Price', array(
														'id' => 'detail-price-button',
														'name' => 'DetailPrice',
														'class'=>'button extra left',
														'onclick' => '
																			jQuery.ajax({
																				type: "POST",
																				url: "' . CController::createUrl('ajaxHtmlAddPriceDetail', array('id' => $service->header->id)) . '",
																				data: jQuery("form").serialize(),
																				success: function(html) {
																					jQuery("#price").html(html);
																				},
																			});',

														)
													); ?>
					</div> <div class="clearfix"></div>	 
		</div>

		<div class="small-12 medium-6 columns">
			<?php echo CHtml::button('Add Equipment', array(
				'id' => 'detail-button',
				'name' => 'Detail',
				'class'=>'button extra right',
				'onclick' => '
					jQuery("#equipment-dialog").dialog("open"); return false;',

				)
			); ?>
			<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id' => 'equipment-dialog',
				// additional javascript options for the dialog plugin
				'options' => array(
					'title' => 'Equipment',
					'autoOpen' => false,
					'width' => 'auto',
					'modal' => true,
				),));
			?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'equipment-grid',
				'dataProvider'=>$equipmentDataProvider,
				'filter'=>$equipment,
				// 'summaryText'=>'',
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
				'selectionChanged'=>'js:function(id){
					$("#equipment-dialog").dialog("close");
					$.ajax({
						type: "POST",
						//dataType: "JSON",
						url: "' . CController::createUrl('ajaxHtmlAddEquipmentDetail', array('id'=>$service->header->id,'equipmentId'=>'')) .'"+$.fn.yiiGridView.getSelection(id),
						data: $("form").serialize(),
						success: function(html) {
							$("#equipment").html(html);
							
						},
					});
					$("#equipment-grid").find("tr.selected").each(function(){
	                   $(this).removeClass( "selected" );
	                });
				}',
				'columns'=>array(
					//'id',
					//'code',
					'name',
					 array('name'=>'equipment_type_name', 'value'=>'$data->equipmentType->name'),
					 array('name'=>'equipment_sub_type_name', 'value'=>'$data->equipmentSubType->name'),
					
				),
			));?>
			<?php $this->endWidget(); ?>

			<h2>Equipment</h2>

			<div class="grid-view" id="equipment" >
				<?php $this->renderPartial('_detailEquipment', array('service'=>$service)); ?>
				<div class="clearfix"></div>
				<div style="display:none" class="keys"></div>
			</div>
 		</div>
 		
 		
 	</div>
 	<div class="row">
 	<div class="small-12 columns">
 		<div id="price">
			<?php $this->renderPartial('_detailPrice', array('service'=>$service)); ?>
		</div>
	</div>
	<div class="small-12 columns">
		<?php echo CHtml::button('Add Material', array(
			'id' => 'material-button',
			'name' => 'Material',
			'class'=>'button extra right',
			'onclick' => '
				jQuery("#material-dialog").dialog("open"); return false;',

			)
		); ?>
		<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id' => 'material-dialog',
			// additional javascript options for the dialog plugin
			'options' => array(
				'title' => 'Material',
				'autoOpen' => false,
				'width' => 'auto',
				'modal' => true,
			),));
		?>

		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'material-grid',
			'dataProvider'=>$materialDataProvider,
			'filter'=>$material,
			// 'summaryText'=>'',
			'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
			'pager'=>array(
			   'cssFile'=>false,
			   'header'=>'',
			),
			'selectionChanged'=>'js:function(id){
				$("#material-dialog").dialog("close");
				$.ajax({
					type: "POST",
					//dataType: "JSON",
					url: "' . CController::createUrl('ajaxHtmlAddMaterialDetail', array('id'=>$service->header->id,'materialId'=>'')) .'"+$.fn.yiiGridView.getSelection(id),
					data: $("form").serialize(),
					success: function(html) {
						$("#material").html(html);
						
					},
				});
				$("#equipment-grid").find("tr.selected").each(function(){
                   $(this).removeClass( "selected" );
                });
			}',
			'columns'=>array(
				//'id',
				//'code',
				'name'
				
			),
		));?>
		<?php $this->endWidget(); ?>

			<div id="material">
				<?php $this->renderPartial('_detailMaterial', array('service'=>$service)); ?>
			</div>
		</div>
		<div class="small-12 columns">
			<?php echo CHtml::button('Add Complement', array(
				'id' => 'complement-button',
				'name' => 'complement',
				'class'=>'button extra right',
				'onclick' => '
					jQuery("#complement-dialog").dialog("open"); return false;',

				)
			); ?>
			
			<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id' => 'complement-dialog',
				// additional javascript options for the dialog plugin
				'options' => array(
					'title' => 'Complement',
					'autoOpen' => false,
					'width' => 'auto',
					'modal' => true,
				),));
			?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'complement-grid',
				'dataProvider'=>$complementDataProvider,
				'filter'=>$complement,
				// 'summaryText'=>'',
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
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
									
									var selected_complement = $(this).parent("td").siblings("td").html();
									var myArray = [];

									jQuery("#complement tr").each(function(){													
										var savedWar = $(this).find("input[type=text]").val();																						
										myArray.push(savedWar); 
									});
									if(jQuery.inArray(selected_complement, myArray)!= -1) {
										alert("Please select other Complement, this is already added");
										return false;
									} else {
										
											$.ajax({
											type: "POST",
											//dataType: "JSON",
											url: "' . CController::createUrl('ajaxHtmlAddComplementDetail', array()) . '/id/'.$service->header->id.'/complementId/"+$(this).val(),
											data: $("form").serialize(),
											success: function(html) {
												$("#complement").html(html);	
												
											},
										});
										$(this).parent("td").parent("tr").addClass("checked");
										$(this).parent("td").parent("tr").removeClass("unchecked");
									}
								
									
								}else{
									var unchecked_val= $(this).val();
									
									var unselected_complement = $(this).parent("td").siblings("td").html();
									var myArray = [];
									var count = 0;
									jQuery("#complement tr").each(function(){													
										var savedWar = $(this).find("input[type=text]").val();																						
										myArray.push(savedWar);																						
										if(unselected_complement==savedWar){
											index_id = count-1;																		
										}
										count++;
									});
									if(jQuery.inArray(unselected_complement, myArray)!= -1) {
									
										$.ajax({
											type: "POST",
											//dataType: "JSON",
											url: "' . CController::createUrl('ajaxHtmlRemoveComplementDetail', array()) . '/id/'.$service->header->id.'/war_name/"+unselected_complement+"/index/"+index_id,
											data: $("form").serialize(),
											success: function(html) {
												$("#complement").html(html);																							
											},
											update:"#complement",
										});
									} 
								
									
									$(this).parent("td").parent("tr").removeClass("checked");
									$(this).parent("td").parent("tr").addClass("unchecked");
							}'
						),											
					), 
					//'id',
					//'code',
					'name'
				),
			));?>
			
			<?php $this->endWidget(); ?>
									
			<div id="complement">
				<?php $this->renderPartial('_detailComplement', array('service'=>$service)); ?>
			</div>
		</div>
		<hr />
	
	
		<div class="field buttons text-center">
			<?php echo CHtml::submitButton($service->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
		</div>

		<?php $this->endWidget(); ?>
		</div>
</div>	
<script>
	if($("#Service_service_type_id").val() == "2"){
		$(".bodyrepair").show();
	}
	else{
		$(".bodyrepair").hide();
	}
</script>