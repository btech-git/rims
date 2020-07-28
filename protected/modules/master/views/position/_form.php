<?php
/* @var $this PositionController */
/* @var $position->header Position */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/position/admin';?>"><span class="fa fa-th-list"></span>Manage Position</a>
	<h1><?php if($position->header->isNewRecord){ echo "New Position"; }else{ echo "Update Position";}?></h1>
	<!-- begin FORM -->

	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'position-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			)); ?>
			<hr />
			<p class="note">Fields with <span class="required">*</span> are required.</p>


			<div class="row">
				<div class="small-12 medium-6 columns">


					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<?php echo $form->labelEx($position->header,'name',array('class'=>'prefix')); ?>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($position->header,'name',array('size'=>60,'maxlength'=>100)); ?>
								<?php echo $form->error($position->header,'name'); ?>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($position->header,'status'); ?></label>  
							</div>
							<div class="small-8 columns">
								<?php echo $form->dropDownList($position->header, 'status', array('Active' => 'Active',
								'Inactive' => 'Inactive', )); ?>
								<?php echo $form->error($position->header,'status'); ?>
							</div>
						</div>
					</div>



				</div>
				<div class="small-12 medium-6 columns">

					<!-- begin RIGHT -->

					<?php echo CHtml::button('Add Detail', array(
						'id' => 'detail-button',
						'name' => 'Detail',
						'class'=>'button extra right',
						'onclick' => '
						jQuery("#level-dialog").dialog("open"); return false;',

						)
						); ?>
					<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id' => 'level-dialog',
							// additional javascript options for the dialog plugin
						'options' => array(
							'title' => 'Level',
							'autoOpen' => false,
							'width' => 'auto',
							'modal' => true,
							),)
					);
					?>

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'level-grid',
						'dataProvider'=>$levelDataProvider,
						'filter'=>$level,
							// 'summaryText'=>'',
				        // 'htmlOptions' => array('class' => 'example','id'=>'level'),
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
							'cssFile'=>false,
							'header'=>'',
							),
						'columns'=>array(
								//'id',
							array(
								'name' => 'check',
								'id' => 'selectedIds',
								'value' => '$data->id',
								// 'htmlOptions'=>array('class'=>'checkbox_level'),
								'class' => 'CCheckBoxColumn',
								'checked' => function($data) use($levelArray) {
									return in_array($data->id, $levelArray); 
								}, 
								'selectableRows' => '100',
								'checkBoxHtmlOptions' => array(
									'onclick' => 
									'js: if($(this).is(":checked")==true){
										var checked_level= $(this).val();

										var selected_level = $(this).parent("td").siblings("td").html();
										
										var myArray = [];

										jQuery("#level tr").each(function(){													
											var savedLevel = $(this).find("input[type=hidden]").val();
											// alert(savedLevel);
											myArray.push(savedLevel); 
											// console.log(myArray);
										});
										if(jQuery.inArray(selected_level, myArray)!= -1) {
											alert("Please select other level, this is already added");
											return false;
										} else {

											$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddLevelDetail', array()) . '/id/'.$position->header->id.'/positionId/"+$(this).val(),
												data: $("form").serialize(),
												success: function(html) {
													$("#level").html(html);	
													//$.fn.yiiGridView.update("#level-grid");
												},
											});
											$(this).parent("td").parent("tr").addClass("checked");
											$(this).parent("td").parent("tr").removeClass("unchecked");
										}


									}else{
										//start from this with editing for level
										var unchecked_val= $(this).val();

										var unselected_level = $(this).parent("td").siblings("td").html();
										// console.log(unchecked_val);
										var myArray = [];
										var count = 1;
										jQuery("#level tr").not("thead tr").each(function(){													
											var removed_savedLevel = $(this).find("input[type=hidden]").val();																						
											myArray.push(removed_savedLevel);																						
											if(unchecked_val==removed_savedLevel){
												index_id = count-1;			
												// console.log(index_id);															
											}
											count++;
										});
										// console.log(myArray);
										if(jQuery.inArray(unchecked_val, myArray)!= -1) {

											$.ajax({
												type: "POST",
																							//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlRemoveLevelDetail', array()) . '/id/'.$position->header->id.'/index/"+index_id,
												data: $("form").serialize(),
												success: function(html) {
													$("#level").html(html);																							
												},
												update:"#level",
											});
										} 


										$(this).parent("td").parent("tr").removeClass("checked");
										$(this).parent("td").parent("tr").addClass("unchecked");
									}'
									),											
								),
								//'code',
							'name'

							),
						)
					);
					?>
					<?php $this->endWidget(); ?>
					<h2>Level</h2>
					<div class="grid-view" id="level" >
						<?php $this->renderPartial('_detailLevel', array('position'=>$position)); ?>
						<div class="clearfix"></div><div style="display:none" class="keys"></div>
					</div>


					<div>

					</div>

					<!-- end RIGHT -->

				</div>
			</div>

			<hr>	
			<div class="field buttons text-center">
				<?php echo CHtml::submitButton(	$position->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
			</div>
			<?php $this->endWidget(); ?>

		</div>
	</div>
	<?php
		Yii::app()->clientScript->registerScript('myjquery', '
			var value_ada = [];
			$( "#detail-button" ).click(function() {
				jQuery("#level tr").each(function(){													
					var savedLevel = $(this).find("input[type=hidden]").val();
					value_ada.push(savedLevel); 
				});

				// console.log(value_ada);
				$("[id^=selectedIds_]").filter(function () {    
				    if (value_ada.indexOf($(this).val()) != -1)
				          return $(this).closest("td").find(":checkbox");
				}).prop("checked", true);

			});
		');
	?>