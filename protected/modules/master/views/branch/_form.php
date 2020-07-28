<?php
/* @var $this BranchController */
/* @var $branch->header Branch */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/branch/admin';?>"><span class="fa fa-th-list"></span>Manage Branch</a>
<h1><?php if($branch->header->isNewRecord){ echo "New Branch"; }else{ echo "Update Branch";}?></h1>
<!-- begin FORM -->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'branch-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<hr />
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($branch->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">			 
			 <!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php //echo $form->labelEx($branch->header,'code'); ?>
					  </div>
					<div class="small-8 columns">
						<?php //echo $form->textField($branch->header,'code',array('size'=>20,'maxlength'=>20)); ?>
						<?php //echo $form->error($branch->header,'code'); ?>
					</div>
				</div>
			 </div>	 -->		 
		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($branch->header,'name', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($branch->header,'name',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($branch->header,'name'); ?>
					</div>
				</div>
			 </div>			 
		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($branch->header,'code', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($branch->header,'code',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($branch->header,'code'); ?>
					</div>
				</div>
			 </div>		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($branch->header,'address', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($branch->header,'address',array('rows'=>6, 'cols'=>50)); ?>
						<?php echo $form->error($branch->header,'address'); ?>
					</div>
				</div>
			 </div>			 
		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					 	<?php echo $form->labelEx($branch->header,'province_id'); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($branch->header, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
		                  'prompt' => '[--Select Province--]',
		                  'onchange'=> 'jQuery.ajax({
		                  type: "POST",
		                  //dataType: "JSON",
		                  url: "' . CController::createUrl('ajaxGetCity') . '",
		                  data: jQuery("form").serialize(),
		                  success: function(data){
		                                console.log(data);
		                                jQuery("#Branch_city_id").html(data);
		                              },
		                });'
		         		 )); ?>
						<?php echo $form->error($branch->header,'province_id'); ?>
					</div>
				</div>
			 </div>			 
		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($branch->header,'city_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php
							if($branch->header->province_id == NULL)
							{
								echo $form->dropDownList($branch->header,'city_id',array(),array('prompt'=>'[--Select City-]'));
							}
							else
							{
								echo $form->dropDownList($branch->header,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$branch->header->province_id)), 'id', 'name'),array());
							}
						?>
						<?php echo $form->error($branch->header,'city'); ?>
					</div>
				</div>
			 </div>			 
	
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($branch->header,'zipcode', array('class'=>'prefix')); ?>
					  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($branch->header,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($branch->header,'zipcode'); ?>
					</div>
				</div>
			 </div>			 

		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($branch->header,'coa_prefix'); ?>
					  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($branch->header,'coa_prefix'); ?>
						<?php echo $form->error($branch->header,'coa_prefix'); ?>
					</div>
				</div>
			 </div>			 

			 <div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php echo $form->labelEx($branch->header,'coa_interbranch_inventory'); ?></label>
	                </div>
	                <div class="small-8 columns">
	                	<?php echo $form->hiddenField($branch->header,'coa_interbranch_inventory'); ?>
					    <?php echo $form->textField($branch->header,'coa_interbranch_inventory_name',array('size'=>20,'maxlength'=>20,'readonly'=>true,'onclick'=>'jQuery("#coa-interbranch-dialog").dialog("open"); return false;','value'=>$branch->header->coa_interbranch_inventory != "" ? Coa::model()->findByPk($branch->header->coa_interbranch_inventory)->name : '')); ?>
					    <?php echo $form->textField($branch->header,'coa_interbranch_inventory_code',array('size'=>20,'maxlength'=>20,'readonly'=>true,'value'=>$branch->header->coa_interbranch_inventory != "" ? Coa::model()->findByPk($branch->header->coa_interbranch_inventory)->code : '')); ?>
						<?php echo $form->error($branch->header,'coa_interbranch_inventory'); ?>
					</div>
	            </div>
	        </div>
		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($branch->header,'company_id'); ?>
					  </div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($branch->header, 'company_id', CHtml::listData(Company::model()->findAllByAttributes(array('is_deleted'=>'0')), 'id', 'name'),array(
		                  'prompt' => '[--Select Company--]',));?>
						<?php echo $form->error($branch->header,'company_id'); ?>
					</div>
				</div>
			 </div>			 

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo 'Phones' ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::button('+', array(
							'id' => 'detail-button',
							'name' => 'Detail',
							'onclick' => '
								jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddPhoneDetail', array('id' => $branch->header->id)) . '",
									data: jQuery("form").serialize(),
									success: function(html) {
										jQuery("#phone").html(html);
									},
								});',

							)
						); ?>
					</div>
				</div>
			</div>
			<div class="field" id="phone">
				<div class="row collapse">
					<?php $this->renderPartial('_detailPhone', array(
						'branch'=>$branch
					)); ?>
				</div>
			</div>
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo 'Fax' ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::button('+', array(
							'id' => 'detail-fax-button',
							'name' => 'DetailFax',
							'onclick' => '
								jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddFaxDetail', array('id' => $branch->header->id)) . '",
									data: jQuery("form").serialize(),
									success: function(html) {
										jQuery("#fax").html(html);
									},
								});',

							)
						); ?>
					</div>
				</div>
			</div>
			<div class="field" id="fax">
				<div class="row collapse">
				<!-- 	<div class="row collapse">
					<div class="small-4 columns"></div>
					<div class="small-8 columns"> -->
							<?php $this->renderPartial('_detailFax', array(
					'branch'=>$branch
					
				)); ?>
				</div>
			</div>
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($branch->header,'email', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($branch->header,'email',array('size'=>60,'maxlength'=>60)); ?>
						<?php echo $form->error($branch->header,'email'); ?>
					</div>
				</div>
			 </div>			 
		
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($branch->header,'status', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($branch->header, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($branch->header,'status'); ?>
					</div>
				</div>
			</div>
		
		</div>
		
			<!-- begin RIGHT -->
		<div class="small-12 medium-6 columns">
			
			<div class="row">
				<div class="small-12 columns">
					<?php echo CHtml::button('Add Division', array(
									'id' => 'detail-division-button',
									'name' => 'Detail',
									'class'=>'button extra right',
									'onclick' => '
										jQuery("#division-dialog").dialog("open"); return false;',

									)
								); ?>
								<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
									'id' => 'division-dialog',
									// additional javascript options for the dialog plugin
									'options' => array(
										'title' => 'Division',
										'autoOpen' => false,
										'width' => 'auto',
										'modal' => true,
									),));
								?>

								<?php $this->widget('zii.widgets.grid.CGridView', array(
									'id'=>'division-grid',
									'dataProvider'=>$divisionDataProvider,
									'filter'=>$division,
									// 'summaryText'=>'',
									'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
									'pager'=>array(
									   'cssFile'=>false,
									   'header'=>'',
									),
									'selectionChanged'=>'js:function(id){
										$("#division-dialog").dialog("close");
										$.ajax({
											type: "POST",
											//dataType: "JSON",
											url: "' . CController::createUrl('ajaxHtmlAddDivisionDetail', array('id'=>$branch->header->id,'divisionId'=>'')) . '"+$.fn.yiiGridView.getSelection(id),
											data: $("form").serialize(),
											success: function(html) {
												$("#division").html(html);
												
											},
										});
										$("#division-grid").find("tr.selected").each(function(){
						                   $(this).removeClass( "selected" );
						                });
									}',
									'columns'=>array(
										 array(
												'name' => 'check',
												'id' => 'selectedIds',
												'value' => '$data->id',
												'class' => 'CCheckBoxColumn',
												'checked' => function($data) use($divisionArray) {
	                                return in_array($data->id, $divisionArray); 
	                        }, 
										'selectableRows' => '100',	
										'checkBoxHtmlOptions' => array(
										 'onclick' => 'js: if($(this).is(":checked")==true){
													var checked_val= $(this).val();
													
													var selected_warehouse = $(this).parent("td").siblings("td").html();
													var myArray = [];

													jQuery("#division tr").each(function(){													
														var savedWar = $(this).find("input[type=hidden]").val();																						
														myArray.push(savedWar); 
													});
													if(jQuery.inArray(selected_warehouse, myArray)!= -1) {
														alert("Please select other Division, this is already added");
														return false;
													} else {
														
															$.ajax({
															type: "POST",
															//dataType: "JSON",
															url: "' . CController::createUrl('ajaxHtmlAddDivisionDetail', array()) . '/id/'.$branch->header->id.'/divisionId/"+$(this).val(),
															data: $("form").serialize(),
															success: function(html) {
																$("#division").html(html);	
																//$.fn.yiiGridView.update("#division-grid");
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
													jQuery("#division tr").each(function(){													
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
															url: "' . CController::createUrl('ajaxHtmlRemoveDivisionDetail', array()) . '/id/'.$branch->header->id.'/divisionId/"+unselected_warehouse+"/index/"+index_id,
															data: $("form").serialize(),
															success: function(html) {
																$("#division").html(html);																							
															},
															update:"#division",
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
						<h2>Division</h2>
						<div class="grid-view" id="division" >
								<?php $this->renderPartial('_detailDivision', array('branch'=>$branch
										)); ?>
								<div class="clearfix"></div><div style="display:none" class="keys"></div>
						</div>
				</div>
			</div>
		</div>	
			<!-- end RIGHT -->		
			 
	</div>
	<hr />
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($branch->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>
<?php $this->endWidget(); ?>

</div>
</div>
<!--COA Interbranch-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'coa-interbranch-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'COA Interbranch',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
		),));
	?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-interbranch-grid',
		'dataProvider'=>$coaInterbranchDataProvider,
		'filter'=>$coaInterbranch,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#coa-interbranch-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#Branch_coa_interbranch_inventory").val(data.id);
					$("#Branch_coa_interbranch_inventory_code").val(data.code);
					$("#Branch_coa_interbranch_inventory_name").val(data.name);
					
				},
			});
			$("#coa-interbranch-grid").find("tr.selected").each(function(){
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