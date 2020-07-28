<?php
/* @var $this PositionController */
/* @var $model Position */

$this->breadcrumbs=array(
	'Company',
	'Positions'=>array('admin'),
	'View Position '.$model->name,
);

$this->menu=array(
	// array('label'=>'List Position', 'url'=>array('index')),
	// array('label'=>'Create Position', 'url'=>array('create')),
	// array('label'=>'Update Position', 'url'=>array('update', 'id'=>$model->id)),
	// array('label'=>'Delete Position', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage Position', 'url'=>array('admin')),
);
?>


	
			<div id="maincontent">
				<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
					<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/position/admin';?>"><span class="fa fa-th-list"></span>Manage Positions</a>
				<?php if (Yii::app()->user->checkAccess("master.position.update")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-th-list"></span>edit</a>
				<?php } ?>
					<h1>View Position <?php echo $model->name; ?></h1>

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'attributes'=>array(
						//	'id',
							'name',
							'status',
						),
					)); ?>
				</div>
			</div>
	<div class="row">
		<div class="small-12 columns">
		<h3>Levels</h3>
		<table >
			
			<!-- <tr>
				<td>Name</td>
				
			</tr> -->
			<?php foreach ($positionLevels as $key => $positionLevel): ?>
				<tr>
						<?php $level = Level::model()->findByPK($positionLevel->level_id); ?>
					<td><?php echo $level->name; ?></td>	
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>