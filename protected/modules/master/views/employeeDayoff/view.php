<?php
/* @var $this EmployeeDayoffController */
/* @var $model EmployeeDayoff */

$this->breadcrumbs=array(
	'Employee Dayoffs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeDayoff', 'url'=>array('index')),
	array('label'=>'Create EmployeeDayoff', 'url'=>array('create')),
	array('label'=>'Update EmployeeDayoff', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeDayoff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeDayoff', 'url'=>array('admin')),
);
?>

<h1>View Pengajuan Cuti Karyawan #<?php echo $model->id; ?></h1>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl.'/master/employeeDayoff/admin';?>"><span class="fa fa-th-list"></span>Manage EmployeeDayoff</a>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>Edit</a>
        <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/master/employeeDayoff/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("master.employeeDayoff.updateApproval"))) ?>
        <!--<h1>View Employee Day off Request #<?php //echo $model->id; ?></h1>-->

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                array(
                    'name'=>'employee_name',
                    'value'=>$model->employee->name
                ),
                array(
                    'label' => 'Jenis Cuti',
                    'name'=>'employee_onleave_category_id',
                    'value'=>$model->employeeOnleaveCategory->name
                ),
                array(
                    'label' => 'Paid/Unpaid',
                    'name'=>'off_type',
                    'value'=>$model->off_type
                ),
                array(
                    'label' => 'Jumlah Hari',
                    'name'=>'day',
                    'value'=>$model->day
                ),
                array(
                    'label' => 'Mulai Tanggal',
                    'name'=>'date_from',
                    'value'=>$model->date_from
                ),
                array(
                    'label' => 'Sampai Tanggal',
                    'name'=>'date_to',
                    'value'=>$model->date_to
                ),
                'notes',
                'status',
            ),
        )); ?>
    </div>
</div>