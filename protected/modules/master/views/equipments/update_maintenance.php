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
<div id="maincontent">
	<div class="clearfix page-action">
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipments/admin';?>"><span class="fa fa-th-list"></span>Manage Equipments</a>
		<!-- Task form-->
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
		<hr />	
		<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
		<?php echo $form->errorSummary($equipment->header); ?>
		<?php echo $form->errorSummary($equipment->equipmentMaintenances1); ?>		
		<div class="row">
			<div class="small-12 columns">
				<div id="maincontent">
					<div class="clearfix page-action">				
						<?php 
							$tableTotal = '';
							$todays_month_year = date('Y-m');
							$k=0;
							$flag=0;
							if(count($equipment->equipmentDetails)>0){ 
									
									foreach($equipment->equipmentDetails as $key => $equipmentDetails){
									$tableTotal = '';								
									$tableTotal .= '<h3> Equipment Name : '.$equipmentDetails->equipment->name.'<br>
													Equipment Type : '.$equipmentDetails->equipment->equipmentType->name.'<br>
													Equipment Sub-Type : '.$equipmentDetails->equipment->equipmentSubType->name.'
													</h3>';
									$equipmentDetailsId = $equipmentDetails->id;
									
									$equipmentTasks 	= EquipmentTask::model()->findAllByAttributes(array('equipment_id'=>$equipmentDetails->equipment->id));					
									if( count($equipmentTasks)>0){
										foreach($equipmentTasks as $i => $equipmentTask){
											$equipmentTaskId = $equipmentTask->id;
											
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
											//echo "count ->".count($equipmentMaintenances)."<br/>"; 
											if(count($equipmentMaintenances)>0){ 
												foreach($equipmentMaintenances as $j => $equipmentMaintenanc){
												//if((date("Y-m", strtotime($equipmentMaintenanc->maintenance_date))==$todays_month_year) || (date("Y-m", strtotime($equipmentMaintenanc->next_maintenance_date))==$todays_month_year)){	
												//if((date("Y-m", strtotime($equipmentMaintenanc->maintenance_date))==$todays_month_year)){	
					
														if($equipmentMaintenanc->checked=="Checked")
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
																			'not-checked' => 'Unchecked', 'Checked' => 'Checked',)).'</td>
														</tr>';
														$k++;
													/*} // end of if loop "date matches"										
													else{// end of if loop "date matches"
														$addUrl = Yii::app()->createUrl("master/equipments/createMaintenance?id=".$equipmentMaintenanc->equipment_id);
														$flag	= 2;
														}	*/									
												}
											}
											else{
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
												
												//$equipmentDetails = $this->instantiate($_GET['id']);										
												//$equipmentDetails->addMaintainanceDetail();	
												$equipmentMaintenanc   = new EquipmentMaintenances;
												for($j=0;$j<$maintenance_count;$j++){
													
												$tableTotal .='<tr style="border-bottom:1px solid black;">
												
													'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_task_id", array('value'=>$equipmentTaskId)).'
													'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_id", array('value'=>$equipment->header->id)).'
													'.CHtml::activeHiddenField($equipmentMaintenanc,"[$k]equipment_detail_id", array('value'=>$equipmentDetailsId)).'
													<td>'.CHtml::ActiveTextField($equipmentMaintenanc,"[$k]maintenance_date",array('class'=>'date_picker',)).'</td>
													<td>'. CHtml::ActiveTextField($equipmentMaintenanc, "[$k]next_maintenance_date").'</td>
													<td>'.CHtml::activeDropDownList($equipmentMaintenanc, "[$k]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
													'prompt' => '[--Select Employee--]')).'</td>
													
													
													<td>'.CHtml::ActiveTextField($equipmentMaintenanc, "[$k]check_date",array('class'=>'date_picker_check',)).'</td>
													<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$j]equipment_condition", 
																					array('Good' => 'Good',
																						  'Bad' => 'Bad',
																						  'Need Further Check' => 'Need Further Check',
																						  'Need Replacement' => 'Need Replacement')).'</td>
													<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$k]checked", array(
																		'Un-checked' => 'Unchecked','Checked' => 'Checked', )).'</td>
													</tr>';
													$k++;
												}
												// uncommented
												/*$tableTotal .= '<tr style="border-bottom:1px solid black;">
															<td colspan="6" style="text-align:center; color:red;">
																No Equipment maintenance details to display!
															</td>
															</table>';*/
											}
											if($flag==1){
												$tableTotal .= '<tr style="border-bottom:1px solid black;">
															<td colspan="6">
																No Equipment Maintenances to display! <a href="'.$addUrl.'" style="color:blue;">Click to Add Equipment Details</a>
															</td></tr>
															</table>';
															$tabarray[$equipmentDetails->equipment_code]=$tableTotal;
															$tableTotal = '';	
											}else if($flag==2){
												$tableTotal .= '<tr style="border-bottom:1px solid black;">
															<td colspan="6">
																No Equipment Maintenances for this month to display! <a href="'.$addUrl.'" style="color:blue;">Click to Add Equipment Details</a>
															</td></tr>
															</table>';
															$tabarray[$equipmentDetails->equipment_code]=$tableTotal;
															$tableTotal = '';	
											
											}
											else{
														$tableTotal .= '</table>';
														$tabarray[$equipmentDetails->equipment_code]=$tableTotal;
														//$tableTotal = '';	
											}
										}
									}
									else{
										$addTasksLink =  Yii::app()->createUrl("master/equipments/updateDetails?id=".$equipmentDetails->equipment_id);
										$tableTotal .= '<tr style="border-bottom:1px solid black;">
												<td colspan="6">
													No Equipment Tasks to display! <a href="'.$addTasksLink.'" style="color:blue;">Click to Add Equipment Tasks</a>
												</td>
												</table>';
									}						
									
								}

							}
							else{
								$addDetailsLink =  Yii::app()->createUrl("master/equipments/updateDetails?id=".$equipment->header->id);
								$flag=2;
								$tableTotal .= '<tr style="border-bottom:1px solid black;">
												<td colspan="6">
													No Equipment Details to display! <a href="'.$addDetailsLink.'" style="color:blue;">Click to Add Equipment Details</a>
												</td></tr>
												</table>';
								$tabarray['No Details']=$tableTotal;
								$tableTotal = '';	
							}
						
							
							$this->widget('zii.widgets.jui.CJuiTabs',array(
							    'tabs'=>$tabarray,
							    // additional javascript options for the accordion plugin
							    'options' => array(
							        'collapsible' => true,        
							    ),
							    'id'=>'MyTab-Menu1'
							));
						?> 
					</div>
				</div>
			</div>
		</div>
		<hr />
	
		<!--end of example-->
		<div class="field buttons text-center">
			<?php echo CHtml::submitButton($equipment->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>
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