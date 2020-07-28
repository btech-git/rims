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

<!-- Breadcrumbs start-->
<div class="row">
	<div class="small-12 columns">
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?>
	</div>
</div>
<!-- Breadcrumbs end-->

<div class="row">
	<div class="small-2 columns">
		<?php include Yii::app()->basePath . '/../css/navsettings.php'; ?>
	</div>
	<div class="small-10 columns">
		<div id="maincontent">

			<div class="clearfix page-action">
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
	<hr>	
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
					if(count($equipment->equipmentDetails)>0){ 
							
							foreach($equipment->equipmentDetails as $key => $equipmentDetails){			
							$tableTotal .= '<h3> Equipment Name : '.$equipmentDetails->equipment->name.'<br>
											Equipment Type : '.$equipmentDetails->equipment->equipmentType->name.'<br>
											Equipment Sub-Type : '.$equipmentDetails->equipment->equipmentSubType->name.'
											</h3>';
							$tableTotal .= '<table>
												<tr>
													<th>Task</th>
													<th>Check Period</th>
													<th>Maintenance Date</th>
													<th>Next Maintenance Date</th>
													<th>Checked By</th>
													<th>Check Date</th>
													<th>Equipment Condition</th>
													<th>Checked</th>
												</tr>';	
							$equipmentMaintenances 	= EquipmentMaintenances::model()->findAllByAttributes(array('equipment_detail_id'=>$equipmentDetails->id, 'equipment_id'=>$equipmentDetails->equipment->id));					
							if(count($equipmentMaintenances)>0){ 
								foreach($equipmentMaintenances as $j => $equipmentMaintenanc){
								if((date("Y-m", strtotime($equipmentMaintenanc->maintenance_date))==$todays_month_year) || (date("Y-m", strtotime($equipmentMaintenanc->next_maintenance_date))==$todays_month_year)){	
	
									if($equipmentMaintenanc->checked=="checked")
										$image = Yii::app()->baseUrl."/images/icons/tick.png";
									else 
										$image = Yii::app()->baseUrl."/images/icons/cancel.png";
									
									$updateUrl = Yii::app()->createUrl("master/equipmentMaintenance/update?id=".$equipmentMaintenanc->id);
										
									$tableTotal .= '<tr style="border-bottom:1px solid black;">
									<td>'.$equipmentMaintenanc->equipment->name.'</td>
									<td>'.$equipmentMaintenanc->equipment->equipmentType->name.'</td>
									<td>'.$equipmentMaintenanc->equipment->equipmentSubType->name.'</td>
									<td>'.$equipmentMaintenanc->equipmentTask->task.'</td>
									<td>'.$equipmentMaintenanc->equipmentTask->check_period.'</td>	
									<td>'.$equipmentMaintenanc->maintenance_date.'</td>	
									<td>'.$equipmentMaintenanc->next_maintenance_date.'</td>
									<td>'.$equipmentMaintenanc->employee->name.'</td>
									<td>'.$equipmentMaintenanc->check_date.'</td>	
									<td>
										<img src="'.$image.'" alt="'.$equipmentMaintenanc->checked.'" style="width:16px;height:16px;">
									</td>				
									<td><a href="'.$updateUrl.'">edit</a></td></tr>';
									
									/*$tableTotal .='<tr style="border-bottom:1px solid black;">
									
									<td>'.CHtml::activeHiddenField($equipmentMaintenanc,"[$j]id").'
									'.CHtml::activeHiddenField($equipmentMaintenanc,"[$j]equipment_task_id").'
									'.CHtml::activeHiddenField($equipmentMaintenanc,"[$j]equipment_id").'
									'.CHtml::activeHiddenField($equipmentMaintenanc,"[$j]equipment_detail_id").'
									'.$equipmentMaintenanc->equipmentTask->task.'</td>
									<td>'.$equipmentMaintenanc->equipmentTask->check_period.'</td>
									<td>'. CHtml::ActiveTextField($equipmentMaintenanc, "[$j]maintenance_date").'</td>
									<td>'. CHtml::ActiveTextField($equipmentMaintenanc, "[$j]next_maintenance_date").'</td>
									<td>'.CHtml::activeDropDownList($equipmentMaintenanc, "[$j]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
									'prompt' => '[--Select Employee--]'),array('size'=>35,'value'=> $equipmentMaintenanc->employee_id != "" ? $equipmentMaintenanc->employee->name : '')).'</td>
									
									
									<td>'.$this->widget("zii.widgets.jui.CJuiDatePicker",array(
										"model" => $equipmentMaintenanc,
									 	"attribute" => "check_date",
									 	// additional javascript options for the date picker plugin
									 	"options"=>array(
											"dateFormat" => "yy-mm-dd",
											"changeMonth"=>true,
										 	"changeYear"=>true,
										 	"yearRange"=>"1900:2020",
										),)).'</td>
									<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, '[$j]equipment_condition', 
																	array('Good' => 'Good',
																		  'Bad' => 'Bad',
																		  'Need Further Check' => 'Need Further Check',
																		  'Need Replacement' => 'Need Replacement')).'</td>
									<td>'.CHtml::ActivedropDownList($equipmentMaintenanc, "[$j]checked", array('checked' => 'Checked',
														'not-checked' => 'Unchecked', )).'</td>
									</tr>';*/
									
								} // end of if loop "date matches"
								}
							}
							else{
								$tableTotal .= '<tr style="border-bottom:1px solid black;">
											<td colspan="11" style="text-align:center; color:red;">
												No Equipment maintenance details to display!
											</td>
											</table>';
							}
							$tableTotal .= '</table>';
							$tabarray[$equipmentDetails->equipment_code]=$tableTotal;
							$tableTotal = '';	
						}
					}
					else{
						$tableTotal .= '<tr style="border-bottom:1px solid black;">
										<td colspan="11">
											No Equipment details to display!
										</td>
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
					));
				?> 
			</div>
		</div>
	</div>
	</div>
	<hr>
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($equipment->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>
	<?php $this->endWidget(); ?>
	</div>