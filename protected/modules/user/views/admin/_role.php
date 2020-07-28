<table>
	<tr>
		<td>
			<?php echo CHtml::checkBox("User[roles][director]", CHtml::resolveValue($model, "roles[director]"), array('id'=>'User_roles_' . $counter, 'value'=>'director')); ?>
			<?php echo CHtml::label('Director', 'User_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
		<td>
			<?php echo CHtml::checkBox("User[roles][generalManager]", CHtml::resolveValue($model, "roles[generalManager]"), array('id'=>'User_roles_' . $counter, 'value'=>'generalManager')); ?>
			<?php echo CHtml::label('General Manager', 'User_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
		<td>
			<?php echo CHtml::checkBox("User[roles][areaManager]", CHtml::resolveValue($model, "roles[areaManager]"), array('id'=>'User_roles_' . $counter, 'value'=>'areaManager')); ?>
			<?php echo CHtml::label('Area Manager', 'User_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Sales</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
	<tr>
		<td>Front Office</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][frontOfficeHead]", CHtml::resolveValue($model, "roles[frontOfficeHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'frontOfficeHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][frontOfficeStaff]", CHtml::resolveValue($model, "roles[frontOfficeStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'frontOfficeStaff')); ?></td>
	</tr>
	<tr>
		<td>Service Advisor</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][serviceAdvisorHead]", CHtml::resolveValue($model, "roles[serviceAdvisorHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'serviceAdvisorHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][serviceAdvisorStaff]", CHtml::resolveValue($model, "roles[serviceAdvisorStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'serviceAdvisorStaff')); ?></td>
	</tr>
    <tr>
		<td>Cashier</td>
		<td style="text-align: center">&nbsp;</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashier]", CHtml::resolveValue($model, "roles[cashier]"), array('id'=>'User_roles_' . $counter++, 'value'=>'cashier')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Repair & Maintenance</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
	<tr>
		<td>Mechanic Repair</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][maintenanceMechanicHead]", CHtml::resolveValue($model, "roles[maintenanceMechanicHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'maintenanceMechanicHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][maintenanceMechanicStaff]", CHtml::resolveValue($model, "roles[maintenanceMechanicStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'maintenanceMechanicStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Body Repair</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
    <tr>
		<td>Admin</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairAdminHead]", CHtml::resolveValue($model, "roles[bodyRepairAdminHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'bodyRepairAdminHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairAdminStaff]", CHtml::resolveValue($model, "roles[bodyRepairAdminStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'bodyRepairAdminStaff')); ?></td>
	</tr>
	<tr>
		<td>Quality Control</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairQualityControlHead]", CHtml::resolveValue($model, "roles[bodyRepairQualityControlHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'bodyRepairQualityControlHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairQualityControlStaff]", CHtml::resolveValue($model, "roles[bodyRepairQualityControlStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'bodyRepairQualityControlStaff')); ?></td>
	</tr>
	<tr>
		<td>Mechanic (Body)</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairMechanicHead]", CHtml::resolveValue($model, "roles[bodyRepairMechanicHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'bodyRepairMechanicHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairMechanicStaff]", CHtml::resolveValue($model, "roles[bodyRepairMechanicStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'bodyRepairMechanicStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Detailing</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
	<tr>
		<td>Car Salon</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][carSalonHead]", CHtml::resolveValue($model, "roles[carSalonHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'carSalonHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][carSalonStaff]", CHtml::resolveValue($model, "roles[carSalonStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'carSalonStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Inventories & Accessories</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
	<tr>
		<td>Parts</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inventoryHead]", CHtml::resolveValue($model, "roles[inventoryHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'inventoryHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inventoryStaff]", CHtml::resolveValue($model, "roles[inventoryStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'inventoryStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Logistic</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
	<tr>
		<td>Logistic</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][logisticHead]", CHtml::resolveValue($model, "roles[logisticHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'logisticHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][logisticStaff]", CHtml::resolveValue($model, "roles[logisticStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'logisticStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Equipment</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
    <tr>
		<td>EMS</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][equipmentHead]", CHtml::resolveValue($model, "roles[equipmentHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'equipmentHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][equipmentStaff]", CHtml::resolveValue($model, "roles[equipmentStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'equipmentStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">ADH</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
    <tr>
		<td>ADH</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][administrationHead]", CHtml::resolveValue($model, "roles[administrationHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'administrationHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][administrationStaff]", CHtml::resolveValue($model, "roles[administrationStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'administrationStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Accounting / Finance</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
    <tr>
		<td>Accounting / Finance</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][financeHead]", CHtml::resolveValue($model, "roles[financeHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'financeHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][financeStaff]", CHtml::resolveValue($model, "roles[financeStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'financeStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">HRD & GA</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
    <tr>
		<td>HRD</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][humanResourceHead]", CHtml::resolveValue($model, "roles[humanResourceHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'humanResourceHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][humanResourceStaff]", CHtml::resolveValue($model, "roles[humanResourceStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'humanResourceStaff')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">B. Dev</th>
		<th style="text-align: center">Head</th>
		<th style="text-align: center">IJS</th>
	</tr>
    <tr>
		<td>Business Development</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][businessDevelopmentHead]", CHtml::resolveValue($model, "roles[businessDevelopmentHead]"), array('id'=>'User_roles_' . $counter++, 'value'=>'businessDevelopmentHead')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("User[roles][businessDevelopmentStaff]", CHtml::resolveValue($model, "roles[businessDevelopmentStaff]"), array('id'=>'User_roles_' . $counter++, 'value'=>'businessDevelopmentStaff')); ?></td>
	</tr>
</table>