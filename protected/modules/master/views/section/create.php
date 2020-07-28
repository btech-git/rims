<?php
/* @var $this SectionController */
/* @var $model Section */

$this->breadcrumbs=array(
	'Warehouse'=>Yii::app()->baseUrl.'/master/warehouse/admin',	
	'Sections'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Section', 'url'=>array('index')),
	array('label'=>'Manage Section', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>