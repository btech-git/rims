<?php
/* @var $this PaymentTypeController */
/* @var $model PaymentType */

$this->breadcrumbs = array(
    'Payment Types' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List PaymentType', 'url' => array('index')),
    array('label' => 'Create PaymentType', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#payment-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="clearfix page-action">
    <?php //if (Yii::app()->user->checkAccess("master.bank.create")) { ?>
        <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/paymentType/create'; ?>"><span class="fa fa-plus"></span>New Payment Type</a>
    <?php //} ?>
    <h1>Manage Payment Types</h1>
</div>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'payment-type-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        'id',
        'name',
        'bank_fee_amount: Biaya Potongan Bank',
        'bankFeeTypeConstant: Jenis Potongan Bank',
        'coa.name: COA',
        'memo',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
