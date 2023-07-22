<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $model EmployeeOnleaveCategory */

$this->breadcrumbs=array(
	'Employee Onleave Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List EmployeeOnleaveCategory', 'url'=>array('index')),
	array('label'=>'Create EmployeeOnleaveCategory', 'url'=>array('create')),
	array('label'=>'Update EmployeeOnleaveCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeOnleaveCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeOnleaveCategory', 'url'=>array('admin')),
);
?>

<h1>View Kategori Cuti Karyawan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'name',
        array(
            'label' => 'Jumlah Hari',
            'name' => 'number_of_days', 
            'value' => CHtml::encode(CHtml::value($model, 'number_of_days')),
        ),
        array(
            'label' => 'Potong Cuti',
            'name' => 'is_using_quota', 
            'value' => $model->is_using_quota == 1 ? "YES" : "NO",
        ),
        array(
            'label' => 'Status',
            'name' => 'is_inactive', 
            'value' => $model->is_inactive == 1 ? "YES" : "NO",
        ),
    ),
)); ?>
