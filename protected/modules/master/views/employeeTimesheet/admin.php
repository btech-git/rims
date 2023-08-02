<?php
/* @var $this EmployeeTimesheetController */
/* @var $model EmployeeTimesheet */

$this->breadcrumbs = array(
    'Employee Timesheets' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List EmployeeTimesheet', 'url' => array('index')),
    array('label' => 'Create EmployeeTimesheet', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#employee-timesheet-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/employeeTimesheet/create'; ?>">
            <span class="fa fa-plus"></span>New Absensi
        </a>
        <a class="button cbutton primary right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/employeeTimesheet/import'; ?>">
            <span class="fa fa-upload"></span>Import Absensi
        </a>
        <h1>Manage Employee Absensi</h1>

        <p>
            You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
            or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
        </p>

        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div><!-- search-form -->

        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'employee-timesheet-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'employee.name',
                'date',
                'clock_in',
                'clock_out',
                array(
                    'class' => 'CButtonColumn',
                ),
            ),
        )); ?>
    </div>
</div>
