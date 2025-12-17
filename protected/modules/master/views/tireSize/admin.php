<?php
/* @var $this TireSizeController */
/* @var $model TireSize */

$this->breadcrumbs=array(
	'Tire Sizes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TireSize', 'url'=>array('index')),
	array('label'=>'Create TireSize', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tire-size-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php //if (Yii::app()->user->checkAccess("masterProductCategoryCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/tireSize/create'; ?>"><span class="fa fa-plus"></span>New</a>
        <?php //} ?>
        <h1>Manage Tire Specifications</h1>

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
                'id' => 'tire-size-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    'id',
                    'section_width',
                    'aspect_ratio',
                    'construction_type',
                    'rim_diameter',
                    'load_rating',
                    'speed_rating',
                    array(
			'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>