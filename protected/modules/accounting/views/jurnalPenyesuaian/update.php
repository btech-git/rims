<?php
/* @var $this JurnalPenyesuaianController */
/* @var $model JurnalPenyesuaian */

$this->breadcrumbs=array(
	'Jurnal Penyesuaians'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List JurnalPenyesuaian', 'url'=>array('index')),
	array('label'=>'Create JurnalPenyesuaian', 'url'=>array('create')),
	array('label'=>'View JurnalPenyesuaian', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage JurnalPenyesuaian', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update JurnalPenyesuaian <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'model'=>$model,
		'coaBiaya'=>$coaBiaya,
		'coaBiayaDataProvider'=>$coaBiayaDataProvider,
		'coaAkumulasi'=>$coaAkumulasi,
		'coaAkumulasiDataProvider'=>$coaAkumulasiDataProvider,
		)); ?></div>