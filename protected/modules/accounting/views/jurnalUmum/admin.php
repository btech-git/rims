<?php
/* @var $this JurnalUmumController */
/* @var $model JurnalUmum */

$this->breadcrumbs=array(
	'Jurnal Umums'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List JurnalUmum', 'url'=>array('index')),
	array('label'=>'Create JurnalUmum', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#jurnal-umum-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Jurnal Umums</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php if (Yii::app()->user->checkAccess("accounting.jurnalUmum.exportExcel")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/accounting/jurnalUmum/exportExcel';?>"><span class="fa fa-print"></span>Export Excel</a> &nbsp;
	<?php }?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'jurnal-umum-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'kode_transaksi',
		'tanggal_transaksi',
		'coa_id',
		'branch_id',
		'total',
		/*
		'debet_kredit',
		'tanggal_posting',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
