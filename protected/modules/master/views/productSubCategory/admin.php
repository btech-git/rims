<?php
/* @var $this ProductSubCategoryController */
/* @var $model ProductSubCategory */

$this->breadcrumbs=array(
	'Product'=>array('admin'),
	'Product Sub Categories'=>array('admin'),
	'Manage Product Sub Categories',
	);

$this->menu=array(
	//array('label'=>'List ProductSubCategory', 'url'=>array('index')),
	//array('label'=>'Create ProductSubCategory', 'url'=>array('create')),
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
		$('#product-sub-category-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
	?>


	<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!-- <div class="clearfix"></div>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); ?>
</div> --><!-- search-form -->

<!-- BEGIN maincontent -->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.productSubCategory.create")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/productSubCategory/create';?>">
            <span class="fa fa-plus"></span>New Product Sub Category
        </a>
			<?php }?>
		<h1>Manage Product Sub Category</h1>


		<!-- BEGIN aSearch -->
		<div class="search-bar">
			<div class="clearfix button-bar">
				<!--<div class="left clearfix bulk-action">
					<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
					<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
					<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
				</div>-->
				<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
				<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>
			</div>
			<div class="clearfix"></div>
			<div class="search-form" style="display:none">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
					)); ?>
				</div><!-- search-form -->
			</div>
			<!-- END aSearch -->		


			<!-- BEGIN gridview -->
			<div class="grid-view">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'product-sub-category-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
						'cssFile'=>false,
						'header'=>'',
						),
					'columns'=>array(
					//'id',
						array (
							'class' 		 => 'CCheckBoxColumn',
							'selectableRows' => '2',	
							'header'		 => 'Selected',	
							'value' => '$data->id',				
							),
						array(
                            'name'=>'product_master_category_code', 
                            'header' => 'Master Category Code',
                            'filter' => false,
                            'value'=>'$data->productMasterCategory->code'
                        ),
						array(
                            'name'=>'product_master_category_name', 
                            'header' => 'Master Category Name',
                            'filter' => CHtml::activeDropDownList($model, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value'=>'$data->productMasterCategory->name'
                        ),
						array(
                            'name'=>'product_sub_master_category_code', 
                            'header' => 'Sub Master Category Code',
                            'filter' => false,
                            'value'=>'$data->productSubMasterCategory->code'
                        ),
						array(
                            'name'=>'product_sub_master_category_name', 
                            'header' => 'Sub Master Category Name',
                            'filter' => CHtml::activeDropDownList($model, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value'=>'$data->productSubMasterCategory->name'
                        ),
						'code',
						array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
						'description',
					/*
					'status',
					*/
					array(
						'class'=>'CButtonColumn',
						'template'=>'{edit}',
						'buttons'=>array
						(
							'edit' => array
							(
								'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.productSubCategory.update"))',
								'url'=>'Yii::app()->createUrl("master/productSubCategory/update", array("id"=>$data->id))',
								),
							),
						),
					),
					)); ?>

				</div>
				<!-- END gridview -->



			</div>
			<!-- END maincontent -->		
		</div>


