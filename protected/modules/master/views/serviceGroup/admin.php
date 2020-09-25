<?php
$this->breadcrumbs=array(
	'Service Groups'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ServiceGroup', 'url'=>array('index')),
	array('label'=>'Create ServiceGroup', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#service-group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
	
<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Service Group', Yii::app()->baseUrl.'/master/serviceGroup/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("master.serviceGroup.create"))) ?>
        
        <h1>Manage Service Groups</h1>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                    )); ?>
                </div><!-- search-form -->				
            </div>
         </div>

         <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'transaction-purchase-order-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'columns'=>array(
                    'id',
                    'name',
                    'standard_flat_rate',
                    'description',
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>