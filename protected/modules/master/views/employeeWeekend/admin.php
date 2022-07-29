<?php
/* @var $this EmployeeWeekendController */
/* @var $model EmployeeWeekend */

$this->breadcrumbs = array(
    'Employee Weekends' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List EmployeeWeekend', 'url' => array('index')),
    array('label' => 'Create EmployeeWeekend', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#employee-weekend-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div class="clearfix page-action">
    <?php if (Yii::app()->user->checkAccess("masterEmployeeCreate")) { ?>
        <a class="button success right" href="<?php echo Yii::app()->baseUrl . 'create'; ?>"><span class="fa fa-plus"></span>New</a>
    <?php } ?>
    <h2>Manage Employee Weekends</h2>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'employee-weekend-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        'employee.name',
        array(
            'header' => 'Off Day',
            'value' => 'CHtml::encode($data->getWeekendOffday($data->off_day))',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
