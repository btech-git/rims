<?php
/* @var $this MovementInHeaderController */
/* @var $model MovementInHeader */

$this->breadcrumbs=array(
	'Movement In Headers'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List MovementInHeader', 'url'=>array('index')),
	array('label'=>'Manage MovementInHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create MovementInHeader</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('movementIn'=>$movementIn,
			'receiveItemDetail'=>$receiveItemDetail,
			'receiveItemDetailDataProvider'=>$receiveItemDetailDataProvider,
			'receiveItem'=>$receiveItem,
			'receiveItemDataProvider'=>$receiveItemDataProvider,
			'returnItem'=>$returnItem,
			'returnItemDataProvider'=>$returnItemDataProvider,
			'returnItemDetail'=>$returnItemDetail,
			'returnItemDetailDataProvider'=>$returnItemDetailDataProvider,
			)); ?></div>