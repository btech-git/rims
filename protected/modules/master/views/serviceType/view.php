<?php
/* @var $this ServiceTypeController */
/* @var $model ServiceType */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service Type'=>array('admin'),
	'View Service Type' . $model->name,
);

// $this->menu=array(
// 	array('label'=>'List ServiceType', 'url'=>array('index')),
// 	array('label'=>'Create ServiceType', 'url'=>array('create')),
// 	array('label'=>'Update ServiceType', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete ServiceType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage ServiceType', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
			<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/serviceType/admin';?>"><span class="fa fa-th-list"></span>Manage Service Types</a>
				<?php if (Yii::app()->user->checkAccess("master.serviceType.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>		
				<?php } ?>
		<h1>View Service Type <?php echo $model->name; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'id',
				'name',
				'code',
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