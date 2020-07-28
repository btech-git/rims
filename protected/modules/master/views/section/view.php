<?php
/* @var $this SectionController */
/* @var $model Section */

$this->breadcrumbs=array(
	'Warehouse'=>Yii::app()->baseUrl.'/master/warehouse/admin',	
	'Sections'=>array('admin'),
	'View Section '.$model->id,
);

$this->menu=array(
	array('label'=>'List Section', 'url'=>array('index')),
	array('label'=>'Create Section', 'url'=>array('create')),
	array('label'=>'Update Section', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Section', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Section', 'url'=>array('admin')),
);
?>
	
	
			<div id="maincontent">
			<div class="clearfix page-action">
			<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/section/admin';?>"><span class="fa fa-th-list"></span>Manage sections</a>
			
			<h1>View Section <?php echo $model->id; ?></h1>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					//'id',
					'code',
					'rack_number',
					'column',
					'row',
					'status',
				),
			)); ?>
			</div>
		</div>