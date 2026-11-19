<?php echo CHtml::beginForm(array(''), 'get'); ?>

<?php $monthList = array(
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Aug',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec',
); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Attendance <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
    <div><?php echo CHtml::encode($monthList[$month]) . ' ' . CHtml::encode($year); ?></div>
</div>

<div class="clear"></div>

<div class="row buttons">
    <?php echo CHtml::hiddenField('EmployeeId', $employeeId); ?>
    <?php echo CHtml::hiddenField('Month', $month); ?>
    <?php echo CHtml::hiddenField('Year', $year); ?>
    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel')); ?>
</div>

<?php echo CHtml::endForm(); ?>

<br />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'attendance-detail-grid',
        'dataProvider'=>$employeeTimesheetDataProvider,
        'filter'=>null,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'date', 
                'value'=>'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->date))', 
            ),
            array(
                'name'=>'login_time', 
                'value'=>'CHtml::encode($data->clock_in)', 
            ),
            array(
                'name'=>'logout_time', 
                'value'=>'CHtml::encode($data->clock_out)', 
            ),
            array(
                'header' => 'Telat',
                'value'=>'CHtml::encode($data->lateTimeDiff)', 
            ),
            array(
                'name'=>'total_hour', 
                'value'=>'CHtml::encode($data->workTimeDiff)', 
            ),
            array(
                'header' => 'Remarks',
                'name'=>'remarks', 
                'value'=>'CHtml::encode($data->remarks)', 
            ),
            array(
                'header' => 'Status',
                'name'=>'employee_onleave_category_id', 
                'value'=>'CHtml::encode(CHtml::value($data, "employeeOnleaveCategory.name"))', 
            ),
        ),
    )); ?>
</div>