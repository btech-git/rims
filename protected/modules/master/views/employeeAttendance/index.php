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
<style>
	.totalText{font-weight: bold; font-size: 12px;}
</style>
<h1>My Attendances</h1>

<?php 
	// $this->widget('zii.widgets.CListView', array(
	// 	'dataProvider'=>$dataProvider,
	// 	'itemView'=>'_view',
	// )); 
?>

<!-- <a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/master/EmployeeDayoff/create';?>">Request Dayoffs</a> -->
<?php $userData = User::model()->notsafe()->findByPk(Yii::app()->user->id); ?>
<?php $employee = Employee::model()->findByPk($userData->employee_id); ?>
<div class="row">
	<div class="large-4 columns">
		<div class="row">
			<div class="small-6 columns totalText">Day off </div>
			<div class="small-6 columns totalText"><?php echo $employee->off_day; ?></div>
		</div>
		<div class="row">
			<div class="small-6 columns totalText">Salary Type</div>
			<div class="small-6 columns totalText"><?php echo $employee->salary_type; ?></div>
		</div>
		<div class="row">
			<div class="small-6 columns totalText">Payment Type</div>
			<div class="small-6 columns totalText"><?php echo $employee->payment_type; ?></div>
		</div>
		
	</div>
</div>

<!-- <table>
	<tr>
		<th>Date</th>
		<th>Login</th>
		<th>Logout</th>
		<th>Total Hour</th>
		<th>Notes</th>
	</tr>
	<?php //foreach ($attendances as $key => $attendance): ?>	
		<tr>
			<td><?php //echo $attendance->date; ?></td>
			<td><?php //echo $attendance->login_time; ?></td>
			<td><?php //echo $attendance->logout_time; ?></td>
			<td><?php //echo $attendance->total_hour; ?></td>
			<td><?php //echo $attendance->notes;?></td>
		</tr>
	<?php //endforeach ?>	
</table> -->
<div class="row">
	<div class="grid-view">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'attendance-grid',
	'dataProvider'=>$dataProvider,
	'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),

	// 'filter'=>$model,
	'columns'=>array(
		// 'id',
		'date',
		'login_time',
		'logout_time',
		'total_hour',

		// 'total_stock',
		'notes',
		
	
		// 'manufacturer_code',
		// 'warehouse_id',
		// 'minimal_stock',
		// 'status',
		/*array(
			'class'=>'CButtonColumn',
			'template'=>'{save}',
			'buttons'=>array
			(
				'save' => array
				(
					'label'=>'Save',
					// 'url'=>'Yii::app()->createUrl("master/forecastingProduct/calculate", array("id"=>$data->id))',
					'visible'=>'(Yii::app()->user->checkAccess("master.forecastingProduct.admin"))',
					'click'=>'js:function(){
					}',
					'options'=>[
						'rel'=>'".$data->id."',
					]
				),
			),
		),*/
	),
)); ?>
		</div>
</div>
<div class="row">
	<div class="large-4 columns">
	<?php 
			$attendanceCriteria = new CDbCriteria;
			$attendanceCriteria->addCondition("MONTH(date) =".date('n'));
			$totalAttendance = EmployeeAttendance::model()->findAll($attendanceCriteria);
		 ?>
		<div class="row">
			<div class="small-6 columns totalText">Total Days </div>
			<div class="small-6 columns totalText"><?php echo count($totalAttendance); ?></div>
		</div>
		<?php $totalOvertime = EmployeeAttendance::model()->findAllByAttributes(array('notes'=>'Overtime')); ?>
		<div class="row">
			<div class="small-6 columns totalText">Total Overtime Day </div>
			<div class="small-6 columns totalText"><?php echo count($totalOvertime); ?></div>
		</div>
	
		<div class="row">
			<div class="small-6 columns totalText">Basic Salary</div>
			<div class="small-6 columns totalText"><?php echo $employee->basic_salary; ?></div>
		</div>
		

		<?php $totalIncentives = EmployeeIncentives::model()->findAllByAttributes(array('employee_id'=>$userData->employee_id));
		$totalIncentive = 0;
		foreach ($totalIncentives as $key => $incentive) {
		 	$totalIncentive += $incentive->amount; 
		 } ?>
		<div class="row">
			<div class="small-6 columns totalText">Total Incentive</div>
			<div class="small-6 columns totalText"><?php echo $totalIncentive; ?></div>
		</div>
		<div class="row">
			<div class="small-11 columns"><hr></div>
			<div class="small-1 columns"> +</div>
		</div>
		
		<?php $totalDeductions = EmployeeDeductions::model()->findAllByAttributes(array('employee_id'=>$userData->employee_id));
		$totalDeduction = 0;
		foreach ($totalDeductions as $key => $deduction) {
		 	$totalDeduction += $deduction->amount; 
		 } ?>
		<div class="row">
			<div class="small-6 columns totalText">Total Deduction</div>
			<div class="small-6 columns totalText"><?php echo $totalDeduction; ?></div>
		</div>
		
		
		<div class="row">
			<div class="small-11 columns"><hr></div>
			<div class="small-1 columns"> -</div>
		</div>
		<?php $total = $employee->basic_salary  + $totalIncentive - $totalDeduction; ?>
		<div class="row">
			<div class="small-6 columns totalText">Total</div>
			<div class="small-6 columns totalText"><?php echo $total; ?></div>
		</div>
	</div>
</div>
<?php 
// Yii::app()->clientScript->registerScript('myforecastingProduct', '
// 		$("body").on("click","#btnsave",function(){
// 			var id = $(this).attr("rel");
// 			var data={};
			
// 			var sibs=$(this).parent().siblings();
// 			data.model_id=id;
// 			data.notes=$(sibs[4]).children().val();
			
// 			//alert(data.notes);
		
// 				$.ajax({
// 				    "url":"'.CHtml::normalizeUrl(array("employeeAttendance/saveData")).'",
// 				    "data":data,
// 				    "type":"POST",
// 				    "success":function(data){
// 				    	console.log(data);
// 				    	$("#attendance-grid").yiiGridView("update",{});
// 				    },
// 				})
			
// 			return false;
// 		});
//     ', CClientScript::POS_END);
?>
<?php
	



