<?php
/* @var $this ServiceTypeController */
/* @var $model ServiceType */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service Type'=>array('admin'),
	'Create',
);
// $this->menu=array(
// 	array('label'=>'List ServiceType', 'url'=>array('index')),
// 	array('label'=>'Manage ServiceType', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model,
		'coa'=>$coa,
		'coaDataProvider'=>$coaDataProvider,
		'coaDiskon'=>$coaDiskon,
		'coaDiskonDataProvider'=>$coaDiskonDataProvider,
	)); ?>
</div>