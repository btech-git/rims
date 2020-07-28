			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Employee Name</label>
					</div>
					<div class="small-8 columns">
						<?php $employees = Employee::model()->findbyPk($model->employee_id); ?>
						<?php echo CHtml::activeHiddenField($model,'employee_id',array('size'=>30,'maxlength'=>30,'readonly'=>true)); ?>
						<?php echo CHtml::activeTextField($model,'employee_name',array('value'=>$employees->name,'readonly'=>true)); ?>
					</div>
				</div>
			</div>
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Deduction Name </label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeHiddenField($model,'deduction_id'); ?>
						<?php echo CHtml::activeTextField($model,'deduction_name',array('size'=>60,'value'=> $model->deduction_id != "" ? $model->deduction->name : '','onclick'=>'jQuery("#deduction-dialog").dialog("open"); return false;')); ?>
						
								<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
									'id' => 'deduction-dialog',
									// additional javascript options for the dialog plugin
									'options' => array(
										'title' => 'Deduction',
										'autoOpen' => false,
										'width' => 'auto',
										'modal' => true,
									),));
								?>

								<?php $this->widget('zii.widgets.grid.CGridView', array(
									'id'=>'deduction-grid',
									'dataProvider'=>$deductionDataProvider,
									'filter'=>$deduction,
									// 'summaryText'=>'',
									'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
									'pager'=>array(
									   'cssFile'=>false,
									   'header'=>'',
									),
									'selectionChanged'=>'js:function(id){
										$("#deduction-dialog").dialog("close");
										$.ajax({
											type: "POST",
											dataType: "JSON",
											url: "' . CController::createUrl('ajaxDeduction', array()) . '/id/"+$.fn.yiiGridView.getSelection(id),
											data: $("form").serialize(),
											success: function(data) {
												$("#EmployeeDeductions_deduction_id").val(data.id);
												$("#EmployeeDeductions_deduction_name").val(data.name);
												
											},
										});
										$("#deduction-grid").find("tr.selected").each(function(){
						                   $(this).removeClass( "selected" );
						                });
									}',
									'columns'=>array(
										//'id',
										//'code',
										'name'
										
									),
								));?>
								<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
					</div>
				</div>			
			</div>
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Amount </label>
					</div>
					<div class="small-8 columns">
							<?php echo CHtml::activeTextField($model,'amount',
						array(
							//'size'=>15,
							//'maxlength'=>10,
			        //'value' => $model->id == "" ? '': $model->account_no,
			        //'placeholder' => 'Account Number',
						)); 

					?>
						
					</div>
				</div>			
			</div>
			<div class="field buttons text-center">
				
			  <?php echo CHtml::submitButton('Save', array('class'=>'button cbutton',)); ?>
			 
			  <?php //echo "test"; ?>
			</div>

			