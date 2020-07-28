<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Products',
	'Equipments'=>array('admin'),
	//$product->header->name=>array('view','id'=>$product->header->id),
	'Add/Update Maintenance',
);
?>




		<div id="maincontent">

			<div class="clearfix page-action">
				<h1>Maintenance Detail for <?php echo $model->name; ?></h1>
				<?php 
					$tableTotal = '
						<table>
							<tr>
								<th>Equipment Name</th>
								<th>Equipment Type</th>
								<th>Equipment Sub Type</th>
								<th>Task</th>
								<th>Check Period</th>
								<th>Maintenance Date</th>
								<th>Next Maintenance Date</th>
								<th>Checked By</th>
								<th>Check Date</th>
								<th>Checked</th>
								<th>Update</th>
							</tr>
					';
					foreach ($equipmentDetails as $key => $equipmentDetail) {
						$equipmentMaintenances 	= EquipmentMaintenances::model()->findAllByAttributes(array('equipment_detail_id'=>$equipmentDetail->id, 'equipment_id'=>$model->id));
						if(count($equipmentMaintenances)>0){ 
							foreach($equipmentMaintenances as $key => $equipmentMaintenanc){
							
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
							}
						}
						$tableTotal .= '</table>';
						$tabarray[$equipmentDetail->equipment_code]=$tableTotal;
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
