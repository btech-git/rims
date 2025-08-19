<?php
/* @var $this EmployeeScheduleController */
/* @var $model EmployeeSchedule */

$this->breadcrumbs=array(
	'Employee Schedules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeSchedule', 'url'=>array('index')),
	array('label'=>'Manage EmployeeSchedule', 'url'=>array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        
        <h1>Data Karyawan Aktif</h1>
        
        <div style="float: right">
            <?php echo CHtml::beginForm(); ?>
                <?php echo CHtml::submitButton('Tambah Jadwal Karyawan', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>

        <br /><br />
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'employee-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
                'columns' => array(
                    'id',
                    'code',
                    array(
                        'name' => 'recruitment_date',
                        'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->recruitment_date)'
                    ),
                    array(
                        'name' => 'name', 
                        'value' => 'CHtml::link($data->name, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'branch_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "branch.code"))',
                    ),
                    array(
                        'name' => 'division_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "division.name"))',
                    ),
                    array(
                        'name' => 'position_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "position.name"))',
                    ),
                    array(
                        'name' => 'level_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "level.name"))',
                    ),
                    'status',
                    array('header'=>'username', 'value'=>'CHtml::encode(CHtml::value($data, "username"))'),
                ),
            )); ?>
        </div>
    </div>
</div>