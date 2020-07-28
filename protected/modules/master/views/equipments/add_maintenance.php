<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Products',
	'Equipments'=>array('admin'),
	//$product->header->name=>array('view','id'=>$product->header->id),
	'Update Maintenance',
);
?>
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipments/admin';?>"><span class="fa fa-th-list"></span>Manage Equipments</a>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipments-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
	Yii::app()->clientscript->registerCoreScript('jquery');
	Yii::app()->clientscript->registerCoreScript('jquery.ui');
 ?>	
	<h1>Maintenance Detail for <?php echo $equipment->header->name; ?></h1>
	<hr>	
	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
	<?php echo $form->errorSummary($equipment->header); ?>
	<?php echo $form->errorSummary($equipment->equipmentMaintenances1); ?>		
	<div class="row">
	<div class="small-12 columns">
		<div id="maincontent">
			<div class="clearfix page-action">				
				<?php 
					$tableTotal 		= '';
					$todays_month_year 	= date('Y-m');
					$check_period_tasks = 0;
					$j					= 0;
					$k					= 0;
					$l					= 0;
					$count 				= 1;
					$check_tasks_array  = array();
					$equipmentDetailsTasks  = array();
					$maintenance_count  = 0;
					$flag 				= 0;
					$tabarray 			= array();
					if(!empty($equipment->equipmentDetails)){
					if(count($equipment->equipmentDetails)>0){ 
							
							foreach($equipment->equipmentDetails as $key => $equipmentDetails){		
							
							$equipmentDetailsId = $equipmentDetails->id;
							$equipmentDetailsTasks = equipmentTask::model()->findAllByAttributes(array('equipment_id'=>$equipmentDetails->equipment->id)); 
							
							if( count($equipmentDetailsTasks)>0){
								foreach($equipmentDetailsTasks as $i => $equipmentTask){
									$equipmentTaskId = $equipmentTask->id;
									$equipmentCheckPeriod = $equipmentTask->check_period;
									$tableTotal .= '<table>
														<tr>
															<th colspan="6"> Equipment Task : '.$equipmentTask->task.' <br/>
																			 Check Period : '.$equipmentTask->check_period.'</th>
														</tr>
														<tr>
															<th>Maintenance Date</th>
															<th>Next Maintenance Date</th>
															<th>Checked By</th>
															<th>Check Date</th>
															<th>Equipment Condition</th>
															<th>Checked</th>
														</tr>';	
									$equipmentMaintenances 	= EquipmentMaintenances::model()->findAllByAttributes(array('equipment_detail_id'=>$equipmentDetailsId, 'equipment_id'=>$equipmentTask->equipment_id,'equipment_task_id'=>$equipmentTask->id));					
									$criteria = new CDbCriteria;
									$now = new CDbExpression("NOW()");
									$criteria->addCondition('exp_d > "'.$now.'" ');

									$maintenance_count = 1;
										switch($equipmentTask->check_period){
												case 'Daily':
															$maintenance_count = 30;
															break;
												case 'Weekly':
															$maintenance_count = 4;
															break;
												case 'Monthly':
															$maintenance_count = 12;
															break;
												case 'Quarterly':
															$maintenance_count = 4;
															break;
												case '6 Months':
															$maintenance_count = 2;
															break;
												case 'Yearly':
															$maintenance_count = 1;
															break;
											}
											
									if(count($equipmentMaintenances)<=0){
										
										$equipmentMaintenanc   = new EquipmentMaintenances;
										$maintenanceDate   = date('Y-m-01');
											
										for($j=0;$j<$maintenance_count;$j++){
											switch($equipmentCheckPeriod){
													
													case 'Daily':
																$add_days = 1;
																break;
													case 'Weekly':
																$add_days = 7;
																break;
													case 'Monthly':
																$add_days = 30;
																break;
													case 'Quarterly':
																$add_days = 91;
																break;
													case '6 Months':
																$add_days = 182;
																break;
													case 'Yearly':
																$add_days = 365;
																break;
												}
												$nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDate. ' + '.$add_days.'days'));
											$tableTotal .='<tr style="border-bottom:1px solid black;">
											
											'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_task_id", array('value'=>$equipmentTaskId)).'
											'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_id", array('value'=>$equipment->header->id)).'
											'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_detail_id", array('value'=>$equipmentDetailsId)).'
											<td>'.CHtml::ActiveTextField($equipmentMaintenanc,"[$k]maintenance_date",array('class'=>'date_picker','value'=>$maintenanceDate, 'readOnly'=>'readOnly')).'</td>
											<td>'. CHtml::ActiveTextField($equipmentMaintenanc, "[$k]next_maintenance_date",array('value'=>$nextMaintenanceDate, 'readOnly'=>'readOnly')).'</td>
											<td>'.CHtml::activeDropDownList($equipmentMaintenanc, "[$k]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
											'prompt' => '[--Select Employee--]')).'</td>
											
											
											<td>'.CHtml::ActiveTextField($equipmentMaintenanc, "[$k]check_date",array("class"=>"date_picker_check",)).'</td>
											<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$k]equipment_condition", 
																			array('Good' => 'Good',
																				  'Bad' => 'Bad',
																				  'Need Further Check' => 'Need Further Check',
																				  'Need Replacement' => 'Need Replacement')).'</td>
											<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$k]checked", array(
																'Un-Checked' => 'Unchecked','Checked' => 'Checked', )).'</td>
											</tr>';
											$maintenanceDate = $nextMaintenanceDate;
											$k++;
										}

									}
									else{										
										// initiallisation of todays date. 
										$maintenanceDate   		= date('Y-m-01');
										
										foreach($equipmentMaintenances as $j => $equipmentMaintenanc){
											
											if($equipmentMaintenanc->checked=="checked")
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";
										
											$updateUrl = Yii::app()->createUrl("master/equipmentMaintenance/update?id=".$equipmentMaintenanc->id);
											
											$tableTotal .='<tr style="border-bottom:1px solid black;">
											
											'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]id").'
											'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_task_id").'
											'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_id").'
											'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_detail_id").'
											<td>'.CHtml::ActiveTextField($equipmentMaintenanc,"[$k]maintenance_date",array('class'=>'date_picker',)).'</td>
											<td>'. CHtml::ActiveTextField($equipmentMaintenanc, "[$k]next_maintenance_date").'</td>
											<td>'.CHtml::activeDropDownList($equipmentMaintenanc, "[$k]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
											'prompt' => '[--Select Employee--]'),array('size'=>35,'value'=> $equipmentMaintenanc->employee_id != "" ? $equipmentMaintenanc->employee_id : '')).'</td>									
											<td>'.CHtml::ActiveTextField($equipmentMaintenanc, "[$k]check_date",array('class'=>'date_picker_check',)).'</td>
											<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$k]equipment_condition", 
																			array('Good' => 'Good',
																				  'Bad' => 'Bad',
																				  'Need Further Check' => 'Need Further Check',
																				  'Need Replacement' => 'Need Replacement')).'</td>
											<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$k]checked", array(
																'Un-checked' => 'Unchecked', 'Checked' => 'Checked',)).'</td>
											</tr>';
											$k++;
											$maintenanceDate = $equipmentMaintenanc['next_maintenance_date'];
																				
										}
										
										$new_maintenance_count = $maintenance_count - count($equipmentMaintenances);
										if(count($equipmentMaintenances)<$maintenance_count){										
											$equipmentMaintenanc   	= new EquipmentMaintenances;
										   // $maintenanceDate   		= date('Y-m-01');
										for($j=0;$j<$new_maintenance_count;$j++){
											$currentMaintenanceDate = $maintenanceDate;										
											switch($equipmentCheckPeriod){													
													case 'Daily':
																$add_days = 1;
																break;
													case 'Weekly':
																$add_days = 7;
																break;
													case 'Monthly':
																$add_days = 30;
																break;
													case 'Quarterly':
																$add_days = 91;
																break;
													case '6 Months':
																$add_days = 182;
																break;
													case 'Yearly':
																$add_days = 365;
																break;
												}
												$nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDate. ' + '.$add_days.'days'));
												$tableTotal .='<tr style="border-bottom:1px solid black;">											
												'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_task_id", array('value'=>$equipmentTaskId)).'
												'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_id", array('value'=>$equipment->header->id)).'
												'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_detail_id", array('value'=>$equipmentDetailsId)).'
												<td>'.CHtml::ActiveTextField($equipmentMaintenanc,"[$k]maintenance_date",array('class'=>'date_picker','value'=>$maintenanceDate, 'readOnly'=>'readOnly')).'</td>
												<td>'.CHtml::ActiveTextField($equipmentMaintenanc, "[$k]next_maintenance_date", array('value'=>$nextMaintenanceDate, 'readOnly'=>'readOnly')).'</td>
												<td>'.CHtml::activeDropDownList($equipmentMaintenanc, "[$k]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
												'prompt' => '[--Select Employee--]')).'</td>										
												<td>'.CHtml::ActiveTextField($equipmentMaintenanc, "[$k]check_date",array("class"=>"date_picker_check",)).'</td>
												<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$k]equipment_condition", 
																				array('Good' => 'Good',
																					  'Bad' => 'Bad',
																					  'Need Further Check' => 'Need Further Check',
																					  'Need Replacement' => 'Need Replacement')).'</td>
												<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$k]checked", array(
																	'Un-checked' => 'Unchecked','Checked' => 'Checked', )).'</td>
												</tr>';
												$maintenanceDate = $nextMaintenanceDate;
												$k++;
											}
										}
																			
										$tableTotal .= '</table>';
										$tabarray[$equipmentDetails->equipment_code]=$tableTotal;
										//$tableTotal = '';	
									}
								}
							}
							else{
								$addTasksLink =  Yii::app()->createUrl("master/equipments/update?id=".$equipmentDetails->equipment_id);
								$tableTotal .= '<tr style="border-bottom:1px solid black;">
										<td colspan="6">
											No Equipment Details to display! <a href="'.$addTasksLink.'" style="color:blue;">Click to Add Equipment Details</a>
										</td></tr>';
										//</table>';
								//$flag = 1;
							}
							
							
							
							$tableTotal .= '</table>';
							$tabarray[$equipmentDetails->equipment_code]=$tableTotal;
							$tableTotal = '';
					
							}
						}
						else{
							$addDetailsLink =  Yii::app()->createUrl("master/equipments/update?id=".$equipmentDetails->equipment_id);
							$flag = 1;
							
							
						}
					}
					else{
						$addDetailsLink =  Yii::app()->createUrl("master/equipments/update?id=".$equipment->header->id);
						$flag = 1;
						
					}
					
					if($flag == 1){
						$tableTotal .= '<tr style="border-bottom:1px solid black;">
										<td colspan="6">
											No Equipment Details to display! <a href="'.$addDetailsLink.'" style="color:blue;">Click to Add Equipment Details</a>
										</td></tr>
										</table>';
						$tabarray['No Details']=$tableTotal;
					}						
					$this->widget('zii.widgets.jui.CJuiTabs',array(
					    'tabs'=>$tabarray,
					    // additional javascript options for the accordion plugin
					    'options' => array(
					        'collapsible' => true,        
					    ),
					    'id'=>'MyTab-Menu1'
					));?>
					
	
			<div class="field buttons text-center">
				<?php echo CHtml::submitButton($equipment->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
			</div>
			
			</div>	
		</div>
	</div>
	</div>
	<?php $this->endWidget(); ?>
	
<script type="text/javascript">
	$(function() {
		$(".date_picker").each(function(){
			$(this).datepicker({"dateFormat": "yy-mm-dd"}); 
		});
		$(".date_picker_check").each(function(){
			$(this).datepicker({"dateFormat": "yy-mm-dd"}); 
		});
		$(".date_picker").change(function(){
			var maintenance_date_id = $(this).attr('id'); // get maintenance date field id
			var maintenance_date 	= $(this).val();		  // get maintenance date 
			var split_maintenance_date_id = maintenance_date_id.split("_");
			var field_array_id		= split_maintenance_date_id[1]; // get task id
			var task_id 			= $('#EquipmentMaintenances_'+field_array_id+'_equipment_task_id').val();
			alert(task_id);
			$.ajax({
					type: "POST",
					//dataType: "JSON",
					url: "AjaxGetNext/maintenance_date/"+maintenance_date+"/selected_task/"+task_id,
					data: $("form").serialize(),
					success: function(data){
						$("#EquipmentMaintenances_"+field_array_id+"_next_maintenance_date").val(data);
						},
				});
			
		}); 
	});
	</script>