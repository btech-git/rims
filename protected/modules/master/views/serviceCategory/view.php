<?php
/* @var $this ServiceCategoryController */
/* @var $model ServiceCategory */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/serviceCategory/admin',
	'Service Category'=>array('admin'),
	'View Service Category' . $model->name,
);

$this->menu=array(
	array('label'=>'List ServiceCategory', 'url'=>array('index')),
	array('label'=>'Create ServiceCategory', 'url'=>array('create')),
	array('label'=>'Update ServiceCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServiceCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServiceCategory', 'url'=>array('admin')),
);
?>
<div id="maincontent">
		<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
			<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/serviceCategory/admin';?>"><span class="fa fa-th-list"></span>Manage Service Categories</a>
				<?php if (Yii::app()->user->checkAccess("master.serviceCategory.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>		
				<?php } ?>
		<h1>View Service Category <?php echo $model->name; ?></h1>
		<div class="detail-view-long">
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'id',
				'code',
				'service_number',
				array('name'=>'service_type_name','value'=>$model->serviceType->name),
				'name',
				'status',
				array('name'=>'coa_name','value'=>$model->coa != "" ? $model->coa->name : ''),
				array('name'=>'coa_code','value'=>$model->coa != "" ? $model->coa->code : ''),
				array('name'=>'coa_diskon_service_name','value'=>$model->coaDiskonService != "" ? $model->coaDiskonService->name : ''),
				array('name'=>'coa_diskon_service_code','value'=>$model->coaDiskonService != "" ? $model->coaDiskonService->code : ''),
			),
		)); ?>
		</div>
	</div>
</div>


