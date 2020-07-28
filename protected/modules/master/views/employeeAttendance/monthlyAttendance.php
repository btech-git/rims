<?php
/* @var $this EmployeeAttendanceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Attendances',
);

$this->menu=array(
	array('label'=>'Create EmployeeAttendance', 'url'=>array('create')),
	array('label'=>'Manage EmployeeAttendance', 'url'=>array('admin')),
);
?>

<h1>My Attendances</h1>

<?php 
	// $this->widget('zii.widgets.CListView', array(
	// 	'dataProvider'=>$dataProvider,
	// 	'itemView'=>'_view',
	// )); 
?>


<table>
	<tr>
		<th>Month</th>
		<th>Total Attendance</th>
		<th>Absence/Day Off</th>
		<th>Bonus</th>
		<th>Overtime</th>
	</tr>
	<?php for ($i=1; $i <=12; $i++) : ?>
		
		 <tr>
		 	<td><?php echo $i; ?></td>
		 	<?php 
				$attendanceCriteria = new CDbCriteria;
				$attendanceCriteria->addCondition("MONTH(date) =".$i);
				$totalAttendance = EmployeeAttendance::model()->findAll($attendanceCriteria);
			 ?>
		 	<td><?php echo count($totalAttendance); ?></td>
		 	<?php 
				$fromCriteria = new CDbCriteria;
				$fromCriteria->addCondition("MONTH(date_from) =".$i);
				$totalfrom = EmployeeDayoff::model()->findAll($fromCriteria);

				// $fromCriteria = new CDbCriteria;
				// $fromCriteria->addCondition("MONTH(date_from) =".$i);
				// $totalfrom = EmployeeDayoff::model()->findAll($fromCriteria);
			 ?>
		 	<td></td>
		 	<td></td>
		 	<td></td>
		 </tr>
		
	<?php endfor; ?>
	
</table>