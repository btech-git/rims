<?php
/* @var $this JurnalUmumController */
/* @var $model JurnalUmum */

$this->breadcrumbs=array(
	'Jurnal Umums'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List JurnalUmum', 'url'=>array('index')),
	array('label'=>'Create JurnalUmum', 'url'=>array('create')),
	array('label'=>'Update JurnalUmum', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete JurnalUmum', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JurnalUmum', 'url'=>array('admin')),
);
?>

<h1>View JurnalUmum #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'kode_transaksi',
		'tanggal_transaksi',
		'coa_id',
		'branch_id',
		'total',
		'debet_kredit',
		'tanggal_posting',
	),
)); ?>
