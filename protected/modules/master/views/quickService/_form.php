<?php
/* @var $this QuickServiceController */
/* @var $quickService->header QuickService */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/quickService/admin';?>"><span class="fa fa-th-list"></span>Manage Quick Service</a>
	<h1><?php if($quickService->header->isNewRecord){ echo "New Quick Service"; }else{ echo "Update Quick Service";}?></h1>
	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'quick-service-form',
			'enableAjaxValidation'=>false,
			)); ?>

			<p class="note">Fields with <span class="required">*</span> are required.</p>

			<?php echo $form->errorSummary($quickService->header); ?>

			<div class="row">
				<div class="small-12 medium-6 columns">			 

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($quickService->header,'code'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($quickService->header,'code',array('size'=>30,'maxlength'=>30)); ?>
								<?php echo $form->error($quickService->header,'code'); ?>
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
								<label class="prefix"><?php echo $form->labelEx($quickService->header,'name'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($quickService->header,'name',array('size'=>30,'maxlength'=>30)); ?>
								<?php echo $form->error($quickService->header,'name'); ?>
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
								<label class="prefix"><?php echo $form->labelEx($quickService->header,'status'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo  $form->dropDownList($quickService->header, 'status', array('Active' => 'Active',
								'Inactive' => 'Inactive', )); ?>
								<?php echo $form->error($quickService->header,'status'); ?>
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
								<label class="prefix"><?php echo $form->labelEx($quickService->header,'rate'); ?></label>
							</div>
							<div class="small-8 columns">
								<div class="row collapse">
									<div class="small-2 columns">
										<?php 
										echo CHtml::button('Count', array(
											'id' => 'count',
											'onclick' =>'
											$.ajax({
												type: "POST",
												url: "' . CController::createUrl('ajaxGetTotal', array('id' => $quickService->header->id,)) . '",
												data: $("form").serialize(),
												dataType: "json",
												success: function(data) {

													$("#QuickService_rate").val(data.total);


												},
											});',)); ?>
										</div>
										<div class="small-10 columns">
											<?php echo $form->textField($quickService->header,'rate',array('size'=>18,'maxlength'=>18)); ?>
											<?php echo $form->error($quickService->header,'rate'); ?>
										</div>
									</div>
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
									<label class="prefix"><?php echo $form->labelEx($quickService->header,'hour'); ?></label>
								</div>
								<div class="small-8 columns">
									<div class="row collapse">
										<div class="small-2 columns">
											<?php 
											echo CHtml::button('Count', array(
												'id' => 'count_hour',
												'onclick' =>'
												$.ajax({
													type: "POST",
													url: "' . CController::createUrl('ajaxGetTotalHr', array('id' => $quickService->header->id,)) . '",
													data: $("form").serialize(),
													dataType: "json",
													success: function(data) {

														$("#QuickService_hour").val(data.total);


													},
												});',)
											); 
											?>
										</div>
										<div class="small-10 columns">
											<?php echo $form->textField($quickService->header,'hour',array('size'=>18,'maxlength'=>18)); ?>
											<?php echo $form->error($quickService->header,'hour'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>		

					</div>
				</div>

				<div class="row">
					<div class="small-12 medium-6 columns">
						<?php 
						echo CHtml::button('Add Service', array(
							'id' => 'detail-button',
							'name' => 'detail',
							'class'=>'button extra left',
							'onclick' => '
							jQuery("#service-dialog").dialog("open"); return false;',
							)
						); 
						?>
						<?php 
						$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'service-dialog',
								// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Service',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
								),)
						);
						?>

						<?php 
						$this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'service-grid',
							'dataProvider'=>$serviceDataProvider,
							'filter'=>$service,
										// 'summaryText'=>'',
							'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
							'pager'=>array(
								'cssFile'=>false,
								'header'=>'',
								),
							'columns'=> array(
								array(
									'name' => 'check',
									'id' => 'selectedIds',
									'value' => '$data->id',
									'class' => 'CCheckBoxColumn',
									'checked' => function($data) use($serviceArray) {
										return in_array($data->id, $serviceArray); 
									}, 
									'selectableRows' => '100',	
									'checkBoxHtmlOptions' => array('onclick' => 'js: if($(this).is(":checked")==true){
										var checked_val= $(this).val();

										var selected_price = $(this).parent("td").siblings("td").html();
										var myArray = [];

										jQuery(".detail tr").each(function(){													
											var savedWar = $(this).find("input[type=hidden]").val();																						
											myArray.push(savedWar); 
										});
										if(jQuery.inArray(selected_price, myArray)!= -1) {
											alert("Please select other Service, this is already added");
											return false;
										} else {

											$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array()) . '/id/'.$quickService->header->id.'/serviceId/"+$(this).val(),
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	

												},
											});
											$(this).parent("td").parent("tr").addClass("checked");
											$(this).parent("td").parent("tr").removeClass("unchecked");
										}

									}else{

										var unchecked_val= $(this).val();

										var unselected_price = $(this).parent("td").siblings("td").html();
										var myArray = [];
										var count = 0;
										jQuery(".detail tr").each(function(){													
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
												url: "' . CController::createUrl('ajaxHtmlRemoveDetail', array()) . '/id/'.$quickService->header->id.'/war_name/"+unchecked_val+"/index/"+index_id,
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);																							
												},
												update:".detail",
											});
										} 


										$(this).parent("td").parent("tr").removeClass("checked");
										$(this).parent("td").parent("tr").addClass("unchecked");
									}
									'
									),											
									), 
								//'id',
								//'code',
								'name',
								'price',
								//array('name'=>'service_price','value'=>'$data->service_price'),
								),
							)
						);
						?>

						<?php 
						$this->endWidget(); ?>
					</div>
				</div>

				<div class="detail">
					<?php $this->renderPartial('_detail', array('quickService'=>$quickService), false, true); ?>
				</div>


				<div class="row buttons text-center">
					<?php echo CHtml::submitButton($quickService->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
				</div>

				<?php $this->endWidget(); ?>

</div><!-- form -->