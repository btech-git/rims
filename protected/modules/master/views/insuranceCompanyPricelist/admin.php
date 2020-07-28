<?php
/* @var $this InsuranceCompanyPricelistController */
/* @var $model InsuranceCompanyPricelist */

$this->breadcrumbs=array(
	'Insurance Company Pricelists'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List InsuranceCompanyPricelist', 'url'=>array('index')),
	array('label'=>'Create InsuranceCompanyPricelist', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});

$('.search-form form').submit(function(){
	$('#insurance-company-pricelist-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Insurance Company Pricelists</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="clearfix"></div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'insurance-company-pricelist-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'columns'=>array(
		'id',
		'insurance_company_id',
		'service_id',
		'damage_type',
		'vehicle_type',
		'price',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
