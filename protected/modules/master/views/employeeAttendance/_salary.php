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
				<th>Salary Type</th>
				<th>Total hari masuk</th>
				<th>Total Overtime</th>
				<th>Salary</th>
				<th>Incentive</th>
				<th>Deduction</th>
				<th>Overtime fee</th>
				<th>Total Salary</th>
				
			</tr>
		<?php 
		$criteria = new CDbCriteria;
		$criteria->with = array('employeeBranchDivisionPositionLevels'=>array('with'=>array('division','position','level')));
		
		if($division != "")
			$criteria->addCondition('employeeBranchDivisionPositionLevels.division_id = '.$division);
		if($position != "")
			$criteria->addCondition('employeeBranchDivisionPositionLevels.position_id = '.$position);
		if($level != "")
			$criteria->addCondition('employeeBranchDivisionPositionLevels.level_id = '.$level);
		if($type != "")
			$criteria->addCondition("salary_type = '".$type."'");
		$employees = Employee::model()->findAll($criteria); ?>

		<?php foreach ($employees as $key => $employee): ?>
			<?php $totalIncentive = $totalDeduction = $totalSalary = $totalOvertime = 0; ?>
			<tr>
				
				
				<td><?php echo $employee->name; ?></td>
				<?php $masuk = $izin = $alpha = $total = 0; ?>
				<?php $masukCriteria = new CDbCriteria;
					  $masukCriteria->addCondition("YEAR(date) = ".$year);
					  $masukCriteria->addCondition("Month(date) = ".$month);
					  $masukCriteria->addCondition("employee_id = ".$employee->id);
					  $masukCriteria->addCondition("login_time != '00:00:00'");
					  $masukCriteria->addCondition("notes = ' ' OR notes = 'No Overtime'" );
					  $countMasuk = count(EmployeeAttendance::model()->findAll($masukCriteria));

				?>
				<td><?php echo $employee->salary_type; ?></td>
				<td><?php echo $countMasuk; ?></td>
				<?php $overtimeCriteria = new CDbCriteria;
					  $overtimeCriteria->addCondition("YEAR(date) = ".$year);
					  $overtimeCriteria->addCondition("Month(date) = ".$month);
					  $overtimeCriteria->addCondition("employee_id = ".$employee->id);
					  $overtimeCriteria->addCondition("notes = 'Overtime'" );
					  $countOvertime = count(EmployeeAttendance::model()->findAll($overtimeCriteria));

				?>
				<td><?php echo $countOvertime ?></td>
				<td><?php echo $employee->basic_salary ?></td>
				<?php $totalIncentives = EmployeeIncentives::model()->findAllByAttributes(array('employee_id'=>$employee->id));
					$totalIncentive = 0;
					foreach ($totalIncentives as $key => $incentive) {
					 	$totalIncentive += $incentive->amount; 
					 } 
				?>
				<td><?php echo $totalIncentive; ?></td>
				<?php $totalDeductions = EmployeeDeductions::model()->findAllByAttributes(array('employee_id'=>$employee->id));
					$totalDeduction = 0;
					foreach ($totalDeductions as $key => $deduction) {
					 	$totalDeduction += $deduction->amount; 
					 } 
				?>
				<td><?php echo $totalDeduction; ?></td>
				<?php 
					if($employee->salary_type == "Monthly"){
						$bs = $employee->basic_salary / 25;
					}
					elseif ($employee->salary_type == "Weekly") {
						$bs = $employee->basic_salary / 7;
					}
					elseif ($employee->salary_type == "Hourly") {
						$bs = $employee->basic_salary * 8;
					}
					else{
						$bs = $employee->basic_salary;
					}
					$ot = $countOvertime * $bs;
					$allOt = 1.5 * $ot;
					$totalSalary = $employee->basic_salary + $totalIncentive + $allOt - $totalDeduction;
				 ?>
				<td><?php echo $allOt; ?></td>
				 <td><?php echo $totalSalary; ?></td>	
			</tr>
		<?php endforeach ?>
		</table>