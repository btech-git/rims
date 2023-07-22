<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $model EmployeeOnleaveCategory */

$this->breadcrumbs=array(
	'Employee Onleave Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EmployeeOnleaveCategory', 'url'=>array('index')),
	array('label'=>'Create EmployeeOnleaveCategory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#employee-onleave-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Kategori Cuti Karyawan</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'employee-onleave-category-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'name',
        array(
            'header'=>'Jumlah Hari',
            'name'=>'number_of_days', 
            'value'=>'$data->number_of_days'
        ),
        array(
            'header'=>'Potong Cuti',
            'name'=>'is_using_quota', 
            'value'=>'$data->is_using_quota == 1 ? "YES" : "NO"'
        ),
        array(
            'header'=>'Status',
            'name'=>'is_inactive', 
            'value'=>'$data->is_inactive == 1 ? "YES" : "NO"'
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>
