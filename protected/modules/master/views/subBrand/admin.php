<?php
/* @var $this SubBrandController */
/* @var $model SubBrand */

$this->breadcrumbs=array(
	'Product',
	'Sub-Brands'=>array('admin'),
	'Manage Sub-Brands',
 );

/*$this->menu=array(
	array('label'=>'List SubBrand', 'url'=>array('index')),
	array('label'=>'Create SubBrand', 'url'=>array('create')),
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
	$('#sub-brand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
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
	$('#sub-brand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.subBrand.create")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/subBrand/create';?>"><span class="fa fa-plus"></span>New Sub-Brand</a>
			<?php }?>
		<h2>Manage Sub-Brand</h2>
	</div>

	<div class="search-bar">
	<div class="clearfix button-bar">
			<!--<div class="left clearfix bulk-action">
     		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
     		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
     		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
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
            'id'=>'sub-brand-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager'=>array(
               'cssFile'=>false,
               'header'=>'',
            ),
            'columns'=>array(
                array (
                'class' 		 => 'CCheckBoxColumn',
                'selectableRows' => '2',	
                'header'		 => 'Selected',	
                'value' => '$data->id',				
                ),
                //'id',
                //'brand_id',
                array(
                    'name'=>'brand_id',
                    'filter' => CHtml::activeDropDownList($model, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value'=>'$data->brand->name'
                ),
                array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
                array(
                        'class'=>'CButtonColumn',
                        'template'=>'{edit}',
                        'buttons'=>array (
                            'edit' => array (
                                'label'=>'edit',
                                        'visible'=>'(Yii::app()->user->checkAccess("master.subBrand.update"))',
                                'url'=>'Yii::app()->createUrl("master/subBrand/update", array("id"=>$data->id))',
                            ),
                        ),
                    ),
                ),
        )); ?>
	</div>
</div>