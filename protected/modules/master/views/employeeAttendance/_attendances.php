<?php
Yii::app()->clientScript->registerCss('_resort', '
	.price {text-align: right;}
');
?>

		<div class="resortHeader">
		   
		   
		   
		    <span></span><br>
		    
		</div>
		<p></p>
		<table>
			<tr>
				<th>Nama</th>
				<th>Off Day</th>
				<th>Total hari masuk</th>
				<th>Izin</th>
				<th>Alpha</th>
				<th>Overtime</th>
				
			</tr>
		<?php 
		$criteria = new CDbCriteria;
		$criteria->with = array('employeeBranchDivisionPositionLevels'=>array('with'=>array('division','position','level')));
		if($type != "")
			$criteria->addCondition("salary_type = '".$type."'");	
		if($division != "")
			$criteria->addCondition('employeeBranchDivisionPositionLevels.division_id = '.$division);
		if($position != "")
			$criteria->addCondition('employeeBranchDivisionPositionLevels.position_id = '.$position);
		if($level != "")
			$criteria->addCondition('employeeBranchDivisionPositionLevels.level_id = '.$level);

		$employees = Employee::model()->findAll($criteria); ?>
		<?php foreach ($employees as $key => $employee): ?>
			<tr>
				
				
				<td><?php echo $employee->name; ?></td>
			
				<?php $masukCriteria = new CDbCriteria;
					  $masukCriteria->addCondition("YEAR(date) = ".$year);
					  $masukCriteria->addCondition("Month(date) = ".$month);
					  $masukCriteria->addCondition("employee_id = ".$employee->id);
					  $masukCriteria->addCondition("login_time != '00:00:00'");
					  $masukCriteria->addCondition("notes = ' ' OR notes = 'No Overtime'" );
					  $countMasuk = count(EmployeeAttendance::model()->findAll($masukCriteria));

				?>
				<td><?php echo $employee->off_day; ?></td>
				<td><?php echo $countMasuk; ?></td>
				<?php $izinCriteria = new CDbCriteria;
					  $izinCriteria->addCondition("YEAR(date) = ".$year);
					  $izinCriteria->addCondition("Month(date) = ".$month);
					  $izinCriteria->addCondition("employee_id = ".$employee->id);
					  $izinCriteria->addCondition("notes = 'Izin'" );
					  $countIzin = count(EmployeeAttendance::model()->findAll($izinCriteria));

				?>
				<td><?php echo $countIzin; ?></td>
				<?php $alphaCriteria = new CDbCriteria;
					  $alphaCriteria->addCondition("YEAR(date) = ".$year);
					  $alphaCriteria->addCondition("Month(date) = ".$month);
					  $alphaCriteria->addCondition("employee_id = ".$employee->id);
					  $alphaCriteria->addCondition("notes = 'Alpha'" );
					  $countAlpha = count(EmployeeAttendance::model()->findAll($alphaCriteria));

				?>
				<td><?php echo $countAlpha; ?></td>
				<?php $overtimeCriteria = new CDbCriteria;
					  $overtimeCriteria->addCondition("YEAR(date) = ".$year);
					  $overtimeCriteria->addCondition("Month(date) = ".$month);
					  $overtimeCriteria->addCondition("employee_id = ".$employee->id);
					  $overtimeCriteria->addCondition("notes = 'Overtime'" );
					  $countOvertime = count(EmployeeAttendance::model()->findAll($overtimeCriteria));

				?>
				<td><?php echo $countOvertime ?></td>
				
			</tr>
		<?php endforeach ?>
		</table>