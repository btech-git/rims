<?php
/* @var $this ServiceCategoryController */
/* @var $model ServiceCategory */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service Category'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ServiceCategory', 'url'=>array('index')),
	array('label'=>'Create ServiceCategory', 'url'=>array('create')),
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
	$('#service-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
	
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.serviceCategory.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/serviceCategory/create';?>" data-reveal-id="color"><span class="fa fa-plus"></span>New Service Category</a>
			<?php }?>
					<h1>Manage Service Categories</h1>

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
						'id'=>'service-category-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',	
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
						'columns'=>array(
							array (
							'class' 		 => 'CCheckBoxColumn',
							'selectableRows' => '2',	
							'header'		 => 'Selected',	
							'value' => '$data->id',				
							),
							array(
                                'name'=>'service_type_code',
                                'filter' => false,
                                'value'=>'$data->serviceType->code'
                            ),
							array(
                                'name'=>'service_type_name',
                                'filter' => CHtml::activeDropDownList($model, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                                'value'=>'$data->serviceType->name'
                            ),
							'code',
							array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
							'service_number',
							//array('name'=>'service_type_name','value'=>'$data->serviceType->name'),
	         				array(
		         				'header'=>'Status', 
		         				'name'=>'status',
		         				'value'=>'$data->status',
		         				'type'=>'raw',
		         				'filter'=>CHtml::dropDownList('ServiceCategory[status]', $model->status, 
		         					array(
		         						''=>'All',
		         						'Active' => 'Active',
		         						'Inactive' => 'Inactive',
		         						)
		         					),
	         				),
	         				array('name'=>'coa_name','value'=>'$data->coa!="" ? $data->coa->name : ""'),
							array('name'=>'coa_code','value'=>'$data->coa!="" ? $data->coa->code : ""'),
							array('name'=>'coa_diskon_service_name','value'=>'$data->coaDiskonService!="" ? $data->coaDiskonService->name : ""'),
							array('name'=>'coa_diskon_service_code','value'=>'$data->coaDiskonService!="" ? $data->coaDiskonService->code : ""'),
							array(
							'class'=>'CButtonColumn',
							'template'=>'{edit} {hapus} {restore}',
							'buttons'=>array
							(
								'edit'=> array (
									'label'=>'edit',
				     				// 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
									'visible'=>'(Yii::app()->user->checkAccess("master.serviceCategory.update"))',
									'url' =>'Yii::app()->createUrl("master/serviceCategory/update",array("id"=>$data->id))',
								),
								'hapus' => array(
				     				'label' => 'delete',
				     				'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
				     				'url' => 'Yii::app()->createUrl("master/serviceCategory/delete", array("id" => $data->id))',
				     				'options'=>array(
				     					// 'class'=>'btn red delete',
				     					'onclick' => 'return confirm("Are you sure want to delete this Service Category?");',
				     				)
				     			),
								'restore' => array(
				     				'label' => 'UNDELETE',
				     				'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
				     				'url' => 'Yii::app()->createUrl("master/serviceCategory/restore", array("id" => $data->id))',
				     				'options'=>array(
				     					// 'class'=>'btn red delete',
				     					'onclick' => 'return confirm("Are you sure want to undelete this Service Category?");',
				     				)
				     			),
							),
						),
					),
				)); ?>
				</div>
		</div>
	</div>