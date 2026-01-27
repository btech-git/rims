<?php
/* @var $this OilSaeController */
/* @var $model OilSae */

$this->breadcrumbs=array(
	'Oil Saes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OilSae', 'url'=>array('index')),
	array('label'=>'Create OilSae', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#oil-sae-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php //if (Yii::app()->user->checkAccess("masterProductCategoryCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/oilSae/create'; ?>"><span class="fa fa-plus"></span>New</a>
        <?php //} ?>
        <h1>Manage Oil Specifications</h1>

        <div class="search-bar">
            <div class="clearfix button-bar">
            </div>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div><!-- search-form -->
        </div>

        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'oil-sae-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    'id',
                    'winter_grade',
                    'hot_grade',
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>