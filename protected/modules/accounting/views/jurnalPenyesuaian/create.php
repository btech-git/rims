<?php
/* @var $this JurnalPenyesuaianController */
/* @var $model JurnalPenyesuaian */

$this->breadcrumbs=array(
	'Jurnal Penyesuaians'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List JurnalPenyesuaian', 'url'=>array('index')),
	array('label'=>'Manage JurnalPenyesuaian', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create JurnalPenyesuaian</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'model'=>$model,
		'coaBiaya'=>$coaBiaya,
		'coaBiayaDataProvider'=>$coaBiayaDataProvider,
		'coaAkumulasi'=>$coaAkumulasi,
		'coaAkumulasiDataProvider'=>$coaAkumulasiDataProvider,
		)); ?></div>