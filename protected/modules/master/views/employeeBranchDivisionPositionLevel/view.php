<?php
/* @var $this EmployeeBranchDivisionPositionLevelController */
/* @var $model EmployeeBranchDivisionPositionLevel */

$this->breadcrumbs = array(
    'Employee Branch Division Position Levels' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List EmployeeBranchDivisionPositionLevel', 'url' => array('index')),
    array('label' => 'Create EmployeeBranchDivisionPositionLevel', 'url' => array('create')),
    array('label' => 'Update EmployeeBranchDivisionPositionLevel', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete EmployeeBranchDivisionPositionLevel', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage EmployeeBranchDivisionPositionLevel', 'url' => array('admin')),
);
?>

<h1>View Employee Branch Division Position Level #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array(
            'name' => 'employee_id',
            'value' => $model->employee->name,
        ),
        array(
            'name' => 'branch_id',
            'value' => $model->branch->code,
        ),
        array(
            'name' => 'division_id',
            'value' => $model->division->name,
        ),
        array(
            'name' => 'position_id',
            'value' => $model->position->name,
        ),
        array(
            'name' => 'level_id',
            'value' => $model->level->name,
        ),
        'status',
    ),
));
?>
