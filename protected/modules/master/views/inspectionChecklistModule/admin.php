<?php
/* @var $this InspectionChecklistModuleController */
/* @var $model InspectionChecklistModule */

$this->breadcrumbs=array(
	'Service',
	'Inspection Checklist Modules'=>array('admin'),
	'Manage Inspection Checklist Modules',
 );

/*$this->menu=array(
	array('label'=>'List InspectionChecklistModule', 'url'=>array('index')),
	array('label'=>'Create InspectionChecklistModule', 'url'=>array('create')),
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
	$('#inspection-checklist-module-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
		<div id="maincontent">
					<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.inspectionChecklistModule.create")) { ?>
						<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/inspectionChecklistModule/create';?>"><span class="fa fa-plus"></span>New Inspection Checklist Module</a>
			<?php }?>
						<h2>Manage Inspection Checklist Modules</h2>
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
						'id'=>'inspection-checklist-module-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						// 'summaryText'=>'',
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'columns'=>array(
							'code',
							array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
							'type',
							array(
								'class'=>'CButtonColumn',
								'template'=>'{edit}',
								'buttons'=>array
								(
									'edit'=> array (
										'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.inspectionChecklistModule.update"))',
										'url' =>'Yii::app()->createUrl("master/inspectionChecklistModule/update",array("id"=>$data->id))',
									),
								),
							),
						),
					)); ?>
				</div>
		<!-- end maincontent -->
	</div>