<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Company',
	'Companies'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Create Company', 'url'=>array('create')),
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
	$('#company-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.company.create")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/company/create';?>"><span class="fa fa-plus"></span>New Company</a>
		<?php }?>
		<h2>Manage Company</h2>
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
			'id'=>'company-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
				'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
			'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
			'columns'=>array(
				//'id',
				array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
				'address',
				array('name'=>'province_name', 'value'=>'$data->province->name'),
				array('name'=>'city_name', 'value'=>'$data->city->name'),
				'phone',
				'npwp',
				'tax_status',
				array(
					'class'=>'CButtonColumn',
					'template'=>'{edit} {hapus} {restore}',
					'buttons'=>array
					(
						'edit'=> array (
							'label'=>'edit',
		     				// 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
							'visible'=>'(Yii::app()->user->checkAccess("master.company.update"))',
							'url' =>'Yii::app()->createUrl("master/company/update",array("id"=>$data->id))',
						),
						'hapus' => array(
     						'label' => 'delete',
		     				'visible'=>'($data->is_deleted == 0)? TRUE:FALSE ',
     						'url' => 'Yii::app()->createUrl("master/company/delete", array("id" => $data->id))',
     						'options'=>array(
     							// 'class'=>'btn red delete',
     							'onclick' => 'return confirm("Are you sure want to delete this Company?");',
     							)
     						),
						'restore' => array(
							'label' => 'UNDELETE',
							'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
							'url' => 'Yii::app()->createUrl("master/company/restore", array("id" => $data->id))',
							'options'=>array(
				     					// 'class'=>'btn red delete',
								'onclick' => 'return confirm("Are you sure want to undelete this Company?");',
								)
							),
						),
				),
			),
		)); ?>
	</div>
</div>
