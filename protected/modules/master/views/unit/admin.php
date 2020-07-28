<?php
/* @var $this UnitController */
/* @var $model Unit */

$this->breadcrumbs=array(
	'Company',
	'Units'=>array('admin'),
	'Manage Units',
);

$this->menu=array(
	array('label'=>'List Unit', 'url'=>array('index')),
	array('label'=>'Create Unit', 'url'=>array('create')),
);

// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').toggle();
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#unit-grid').yiiGridView('update', {
// 		data: $(this).serialize()
// 	});
// 	return false;
// });
// ");

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
	$('#unit-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

//Create dialog
$('#create-button').click(function(){
	$.ajax({
		type: 'POST',
		url: '" . CController::createUrl('ajaxHtmlCreate') . "',
		data: $('form').serialize(),
		success: function(html) {
			$('#unit_div').html(html);
			$('#unit-dialog').dialog('open');
		},
	});
});
");
?>

			<div id="maincontent">
					<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.unit.create")) { ?>
						<!-- <a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/unit/create';?>"><span class="fa fa-plus"></span>New Unit</a>-->

					<!--<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/unit/create';?>" data-reveal-id="unit"><span class="fa fa-plus"></span>New Unit</a>-->
					<?php echo CHtml::button('New Unit', array('id' => 'create-button', 'class'=>'button success right')); ?>
			<?php }?>

					<h1>Manage Units</h1>


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

			<div class="grid-view">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'unit-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				// 'summaryText' => '',
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
				'columns'=>array(
					array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
					array(
							'header'=>'Status',
							'name'=>'status', 
							'value'=>'$data->status',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('Unit[status]', $model->status, 
								array(
									''=>'All',
									'Active' => 'Active',
									'Inactive' => 'Inactive',
								)
							),
						),
						
					array(
						'class'=>'CButtonColumn',
						'template'=>'{edit}',
						'buttons'=>array
						(
							'edit' => array
							(
									'visible'=>'(Yii::app()->user->checkAccess("master.unit.update"))',
								'label'=>'edit',
								'url' => 'Yii::app()->createUrl("/master/unit/ajaxHtmlUpdate", array("id" => $data->id))',
									'options' => array(  
										'ajax' => array(
											'type' => 'POST',
											// ajax post will use 'url' specified above 
											'url' => 'js: $(this).attr("href")',
											'success' => 'function(html) {
												$("#unit_div").html(html);
												$("#unit-dialog").dialog("open");
											}',
										),
									),
							),
						),
					),
				),
			)); ?>
			</div>
			</div>
			<!-- end maincontent -->
		</div>

<!-- begin pop up -->
<div id="unit" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	<div class="small-12 columns">
		<div id="maincontent">
			<div class="clearfix page-action">
				<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/index.php?r=master/unit/admin';?>"><span class="fa fa-th-list"></span>Manage Units</a>
				<h1>New Unit</h1>


			<?php $this->renderPartial('_ajaxform', array('model'=>$model)); ?>
			
					
			</div>
		</div>
	</div>
</div>

<!-- end pop up -->
<!--Level Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'unit-dialog',
        'options'=>array(
            'title'=>'Unit',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'480',
        ),
 )); ?>
 
<div id="unit_div"></div>

<?php $this->endWidget(); ?>