<?php
/* @var $this CoaSubCategoryController */
/* @var $model CoaSubCategory */

$this->breadcrumbs=array(
	'Coa Sub Categories'=>array('admin'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List CoaSubCategory', 'url'=>array('index')),
	array('label'=>'Create CoaSubCategory', 'url'=>array('create')),
);*/

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
	$('#coa-sub-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Coa Sub Categories</h1>-->


<div id="maincontent">
	<div class="row">
		<div class="small-12 columns">
			<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.coaSubCategory.create")) { ?>
				<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/coaSubCategory/create';?>">
                    <span class="fa fa-plus"></span>Create Coa Sub Categories
                </a>
			<?php } ?>
				<h2>Manage Coa Sub Categories</h2>
			</div>

			<div class="search-bar">
				<div class="clearfix button-bar">
		  			<!--<div class="left clearfix bulk-action">
		         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
		         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
		         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
		         	</div>-->
					<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>					
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
					'id'=>'coa-sub-category-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					// 'summaryText'=>'',
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
					   'cssFile'=>false,
					   'header'=>'',
					),
					'columns'=>array(
						'name',
						'code',
						//'coa_category_id',
						array(
                            'name'=>'coa_category_id', 
                            'filter' => CHtml::activeDropDownList($model, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value'=>'$data->coaCategory->name'
                        ),
						array(
							'class'=>'CButtonColumn',
						),
					),
				)); ?>
			</div>
		</div>
	</div> <!-- end row -->
</div> <!-- end maintenance -->
