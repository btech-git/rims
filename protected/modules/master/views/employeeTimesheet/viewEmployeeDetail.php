<?php
/* @var $this EmployeeTimesheetController */
/* @var $employee EmployeeTimesheet */

$this->breadcrumbs=array(
	'Employee Timesheets'=>array('admin'),
	$employee->id,
);

?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View Employee Timesheet #<?php echo $employee->id; ?></h1>

        <fieldset>
            <h3>Data Karyawan</h3>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $employee,
                'attributes' => array(
                    'code',
                    array(
                        'name' => 'recruitment_date',
                        'value' => CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($employee, 'recruitment_date'))),
                    ),
                    'name',
                    'employment_type',
                    array(
                        'name' => 'branch_id', 
                        'value' => CHtml::encode(CHtml::value($employee, 'branch.name')),
                    ),
                    array(
                        'name' => 'division_id', 
                        'value' => CHtml::encode(CHtml::value($employee, 'division.name')),
                    ),
                    array(
                        'name' => 'position_id', 
                        'value' => CHtml::encode(CHtml::value($employee, 'position.name')),
                    ),
                    array(
                        'name' => 'level_id', 
                        'value' => CHtml::encode(CHtml::value($employee, 'level.name')),
                    ),
                    array(
                        'name' => 'employee_head_id', 
                        'value' => CHtml::encode(CHtml::value($employee, 'employeeHead.name')),
                    ),
                    array(
                        'label' => 'Kuota Cuti',
                        'name' => 'onleave_allocation', 
                        'value' => CHtml::encode(CHtml::value($employee, 'onleave_allocation')),
                    ),
                    'off_day',
                ),
            )); ?>
        </fieldset>
        
        <fieldset>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'employee-timesheet-grid',
                'dataProvider' => $dataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'name' => 'date',
                        'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($data, "date")))',
                    ),
                    'clock_in',
                    'clock_out',
                    array(
                        'header' => 'Telat',
                        'value' => '$data->lateTimeDiff',
                    ),
                    array(
                        'header' => 'Lama Kerja',
                        'value' => '$data->workTimeDiff',
                    ),
                ),
            )); ?>
        </fieldset>
    </div>
</div>