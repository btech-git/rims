<?php
/* @var $this BankController */
/* @var $model Bank */

$this->breadcrumbs=array(
 	'Accounting',
	'Banks'=>array('admin'),
 	'View Bank '.$model->name,
 );

// $this->menu=array(
// 	array('label'=>'List Bank', 'url'=>array('index')),
// 	array('label'=>'Create Bank', 'url'=>array('create')),
// 	array('label'=>'Update Bank', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Bank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Bank', 'url'=>array('admin')),
// );
?>
		<div id="maincontent">
			<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
					<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/bank/admin';?>"><span class="fa fa-th-list"></span>Manage Bank</a>
				<?php if (Yii::app()->user->checkAccess("master.bank.update")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
					<h1>View <?php echo $model->name ?></h1>

						<?php $this->widget('zii.widgets.CDetailView', array(
							'data'=>$model,
							'attributes'=>array(
								//'id',
								'name',
								'code',
                                'coa.name',
							),
						)); ?>
			</div>
	</div>
