<?php
/* @var $this SectionDetailController */
/* @var $model SectionDetail */

$this->breadcrumbs=array(
	'Warehouse'=>Yii::app()->baseUrl.'/master/warehouse/admin',
	'Section Details'=>array('admin'),
	'View Section Detail '.$model->name,
);

$this->menu=array(
	array('label'=>'List SectionDetail', 'url'=>array('index')),
	array('label'=>'Create SectionDetail', 'url'=>array('create')),
	array('label'=>'Update SectionDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SectionDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SectionDetail', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/sectionDetail/admin';?>"><span class="fa fa-th-list"></span>Manage section Details</a>


	<h1>View Section Detail <?php echo $model->id; ?></h1>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			//'id',
			'name',
			'status',
		),
	)); ?>
	</div>
</div>