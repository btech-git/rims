<?php
/* @var $this EmployeeScheduleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Schedules',
);

$this->menu=array(
	array('label'=>'Create EmployeeSchedule', 'url'=>array('create')),
	array('label'=>'Manage EmployeeSchedule', 'url'=>array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/employeeSchedule/generate'; ?>">
            <span class="fa fa-plus"></span>Tambah Jadwal Karyawan
        </a>

        <h1>Jadwal Karyawan Mingguan</h1>

        <div class="clear"></div>

        <?php echo CHtml::beginForm(array(''), 'get'); ?>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
        </div>
        <?php echo CHtml::endForm(); ?>
        
        <br />
        
        <table>
            <thead>
                <tr>
                    <th></th>
                    <?php foreach ($branches as $branch): ?>
                        <th><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 7; $i++): ?>
                    <?php $date = date('Y-m-d', strtotime($currentDate . " + {$i} days")); ?>
                    <tr>
                        <td><?php echo CHtml::encode(date('D, d M Y', strtotime($date))); ?></td>
                        <?php foreach ($branches as $branch): ?>
                            <td>
                                <?php if (isset($employeeScheduleData[$date][$branch->id])): ?>
                                    <?php $employeeNames = implode("\r\n", $employeeScheduleData[$date][$branch->id]); ?>
                                    <?php echo nl2br($employeeNames); ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>