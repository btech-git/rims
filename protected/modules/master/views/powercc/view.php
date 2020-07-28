<?php
/* @var $this PowerccController */
/* @var $model Powercc */

$this->breadcrumbs=array(
	'Powerccs'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Powercc', 'url'=>array('index')),
	array('label'=>'Create Powercc', 'url'=>array('create')),
	array('label'=>'Update Powercc', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Powercc', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Powercc', 'url'=>array('admin')),
);
?>
		<div id="maincontent">
			<div class="clearfix page-action">
			<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/powercc/admin';?>"><span class="fa fa-th-list"></span>Manage Powerccs</a>
			<h1>View Powercc <?php echo $model->id; ?></h1>

				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						//'id',
						'code',
						'name',
						'status',
					),
				)); ?>
			</div>
		</div>