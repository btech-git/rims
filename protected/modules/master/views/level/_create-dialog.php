<?php
/* @var $this LevelController */
/* @var $model Level */

/*$this->breadcrumbs=array(
	'Levels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Level', 'url'=>array('index')),
	array('label'=>'Manage Level', 'url'=>array('admin')),
);*/
?>
<div class="row">
	<div class="small-12 columns">
		<div id="maincontent">
			<?php $this->renderPartial('_form-dialog', array('model'=>$model)); ?>
		</div>
	</div>
</div>