<?php
/* @var $this EquipmentsController */
/* @var $data Equipments */
?>


	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->
	<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id));?></td>
	<td><?php echo CHtml::encode($data->branch->name); ?></td>
	<td><?php echo CHtml::encode($data->equipmentType->name); ?></td>
	<td><?php echo CHtml::encode($data->equipmentSubType->name); ?></td>
	<td><?php if(count($data->equipmentDetails)>0){?>
			<table>
			<th>Equipment Code</th>
			<th>Brand</th>
			<th>Quantity</th>
			<?php foreach($data->equipmentDetails as $eqDetails){ ?>
			<tr>
				<td><?php echo CHtml::encode($eqDetails->equipment_code); ?></td>
				<td><?php echo CHtml::encode($eqDetails->brand); ?></td>
				<td><?php echo CHtml::encode($eqDetails->quantity); ?></td>
			</tr>				
			<?php }?>
			</table>
	<?php }else{
		echo "No Details";
	} ?></td>
	</tr>


