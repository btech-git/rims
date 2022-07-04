<?php
/* @var $this SubBrandSeriesController */
/* @var $model SubBrandSeries */

$this->breadcrumbs = array(
    'Product',
    'Sub-Brand Series' => array('admin'),
    'Manage Sub-Brand Series',
);

/* $this->menu=array(
  array('label'=>'List SubBrandSeries', 'url'=>array('index')),
  array('label'=>'Create SubBrandSeries', 'url'=>array('create')),
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
  $('#sub-brand-series-grid').yiiGridView('update', {
  data: $(this).serialize()
  });
  return false;
  });
  "); */

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function() {
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
        
       if ($(this).hasClass('active')){
		$(this).text('');
	} else {
		$(this).text('Advanced Search');
	}
	return false;
    });

    $('.search-form form').submit(function() {
	$('#sub-brand-series-grid').yiiGridView('update', {
            data: $(this).serialize()
	});
	return false;
    });
");
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterSubBrandSeriesCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/subBrandSeries/create'; ?>"><span class="fa fa-plus"></span>New Sub Brand Series</a>
        <?php } ?>
        <h2>Manage Sub Brand Series</h2>
    </div>

    <div class="search-bar">
        <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>  
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div><!-- search-form -->
        </div>
    </div>
    
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'sub-brand-series-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'header' => 'Brand',
                    'value' => '$data->subBrand->brand->name',
                ),
                array(
                    'name' => 'sub_brand_id',
                    'filter' => CHtml::activeDropDownList($model, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value' => '$data->subBrand->name',
                ),
                array(
                    'name' => 'name',
                    'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))',
                    'type' => 'raw'
                ),
                array(
                    'class' => 'CButtonColumn',
                ),
            ),
        )); ?>
    </div>
</div>