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
						<label class="prefix">Incentive Name </label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeHiddenField($model,'incentive_id'); ?>
						<?php echo CHtml::activeTextField($model,'incentive_name',array('size'=>60,'value'=> $model->incentive_id != "" ? $model->incentive->name : '','onclick' =>'jQuery("#incentive-dialog").dialog("open"); return false;')); ?>
						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'incentive-dialog',
							// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Incentive',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
							),));
						?>

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'incentive-grid',
							'dataProvider'=>$incentiveDataProvider,
							'filter'=>$incentive,
							// 'summaryText'=>'',
							'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
							'pager'=>array(
							   'cssFile'=>false,
							   'header'=>'',
							),
							'selectionChanged'=>'js:function(id){
								$("#incentive-dialog").dialog("close");
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxIncentive', array()) . '/id/"+$.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),
									success: function(data) {
										$("#EmployeeIncentives_incentive_id").val(data.id);
										$("#EmployeeIncentives_incentive_name").val(data.name);
										
									},
								});
								$("#incentive-grid").find("tr.selected").each(function(){
								   $(this).removeClass( "selected" );
								});
							}',
							'columns'=>array(
								//'id',
								'id',
								'name',
								'amount'
							),
						));?>
						<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
						<?php //echo $form->error($model,'customer_id'); ?>
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

			