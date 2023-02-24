<?php
/* @var $this EmployeeBranchDivisionPositionLevelController */
/* @var $model EmployeeBranchDivisionPositionLevel */

$this->breadcrumbs = array(
    'Employee Branch Division Position Levels' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List EmployeeBranchDivisionPositionLevel', 'url' => array('index')),
    array('label' => 'Create EmployeeBranchDivisionPositionLevel', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#employee-branch-division-position-level-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Employee Branch Division Position Levels</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'employee-branch-division-position-level-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
//		'id',
        array(
            'name' => 'employee_id',
            'filter' => CHtml::activeTextField($model, 'employee_name'),
            'value' => 'CHtml::link($data->employee->name, array("employee/view", "id"=>$data->employee_id))',
            'type' => 'raw'
        ),
        array(
            'name' => 'branch_id',
            'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'code')), 'id', 'code'), array('empty' => '-- All --')),
            'value' => '$data->branch->code',
        ),
        array(
            'name' => 'division_id',
            'filter' => CHtml::activeDropDownList($model, 'division_id', CHtml::listData(Division::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->division->name',
        ),
        array(
            'name' => 'position_id',
            'filter' => CHtml::activeDropDownList($model, 'position_id', CHtml::listData(Position::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->position->name',
        ),
        array(
            'name' => 'level_id',
            'filter' => CHtml::activeDropDownList($model, 'level_id', CHtml::listData(Level::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->level->name',
        ),
        /*
          'status',
         */
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
        ),
    ),
));
?>
