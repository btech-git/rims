<?php
/* @var $this EmployeeAttendanceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Employee Attendances',
);

$this->menu = array(
    array('label' => 'Create EmployeeAttendance', 'url' => array('create')),
    array('label' => 'Manage EmployeeAttendance', 'url' => array('admin')),
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

<!-- <a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/master/EmployeeDayoff/create'; ?>">Request Dayoffs</a> -->
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

<br />

<div class="row">
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'attendance-grid',
            'dataProvider' => $dataProvider,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            // 'filter'=>$model,
            'columns' => array(
                'date',
                'login_time',
                'logout_time',
                'total_hour',
                'notes',
            ),
        )); ?>
    </div>
</div>

<br />

<div class="row">
    <div class="large-4 columns">
        <?php
        $attendanceCriteria = new CDbCriteria;
        $attendanceCriteria->addCondition("MONTH(date) =" . date('n'));
        $totalAttendance = EmployeeAttendance::model()->findAll($attendanceCriteria);
        ?>
        <div class="row">
            <div class="small-6 columns totalText">Total Days </div>
            <div class="small-6 columns totalText"><?php echo count($totalAttendance); ?></div>
        </div>
        
        <?php $totalOvertime = EmployeeAttendance::model()->findAllByAttributes(array('notes' => 'Overtime')); ?>
        <div class="row">
            <div class="small-6 columns totalText">Total Overtime Day </div>
            <div class="small-6 columns totalText"><?php echo count($totalOvertime); ?></div>
        </div>

        <div class="row">
            <div class="small-6 columns totalText">Basic Salary</div>
            <div class="small-6 columns totalText"><?php echo $employee->basic_salary; ?></div>
        </div>


        <?php
        $totalIncentives = EmployeeIncentives::model()->findAllByAttributes(array('employee_id' => $userData->employee_id));
        $totalIncentive = 0;
        foreach ($totalIncentives as $key => $incentive) {
            $totalIncentive += $incentive->amount;
        }
        ?>
        <div class="row">
            <div class="small-6 columns totalText">Total Incentive</div>
            <div class="small-6 columns totalText"><?php echo $totalIncentive; ?></div>
        </div>
        
        <div class="row">
            <div class="small-11 columns"><hr /></div>
            <div class="small-1 columns"> +</div>
        </div>

        <?php
        $totalDeductions = EmployeeDeductions::model()->findAllByAttributes(array('employee_id' => $userData->employee_id));
        $totalDeduction = 0;
        foreach ($totalDeductions as $key => $deduction) {
            $totalDeduction += $deduction->amount;
        }
        ?>
        <div class="row">
            <div class="small-6 columns totalText">Total Deduction</div>
            <div class="small-6 columns totalText"><?php echo $totalDeduction; ?></div>
        </div>

        <div class="row">
            <div class="small-11 columns"><hr></div>
            <div class="small-1 columns"> -</div>
        </div>
        
        <?php $total = $employee->basic_salary + $totalIncentive - $totalDeduction; ?>
        <div class="row">
            <div class="small-6 columns totalText">Total Take Home Pay</div>
            <div class="small-6 columns totalText"><?php echo $total; ?></div>
        </div>
    </div>
</div>