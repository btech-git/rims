<?php
/* @var $this PositionController */
/* @var $model Position */

$this->breadcrumbs=array(
	'Company',
	'Positions'=>array('admin'),
	'Manage Positions',
	);
/*
$this->menu=array(
	array('label'=>'List Position', 'url'=>array('index')),
	array('label'=>'Create Position', 'url'=>array('create')),
);
*/

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
		$('#position-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});

//Create dialog
	// $('#create-button').click(function(){
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: '" . CController::createUrl('ajaxHtmlCreate') . "',
	// 		data: $('form').serialize(),
	// 		success: function(html) {
	// 			$('#position_div').html(html);
	// 			$('#position-dialog').dialog('open');
	// 		},
	// 	});
	// });

	");
	?>
	<div id="maincontent">
		<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.position.create")) { ?>
			<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/position/create';?>"><span class="fa fa-plus"></span>New Position</a>
			<?php }?>
			<?php //echo CHtml::button('New Position', array('id' => 'create-button', 'class'=>'button success right')); ?>
			<h1>Manage Positions</h1>
			<!-- begin pop up -->
			<div id="employee" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
				<div class="small-12 columns">
					<div id="maincontent">
						<div class="clearfix page-action">
							<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/position/admin';?>"><span class="fa fa-th-list"></span>Manage Positions</a>
							<h1>New Position</h1>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end pop up -->

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
 		'id'=>'position-grid',
 		'dataProvider'=>$model->search(),
 		'filter'=>$model,
		'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
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
 			array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
 			array(
 				'header'=>'Status',
 				'name'=>'status',
 				'value'=>'$data->status',
 				'type'=>'raw',
 				'filter'=>CHtml::dropDownList('Position[status]', $model->status, 
 					array(
 						''=>'All',
 						'Active' => 'Active',
 						'Inactive' => 'Inactive',
 						)
 					),
 				),
				array(
					'class'=>'CButtonColumn',
					'template'=>'{edit} {hapus} {restore}',
					'buttons'=>array
					(
						'edit'=> array (
							'label'=>'edit',
		     				'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
							'url' =>'Yii::app()->createUrl("master/position/update",array("id"=>$data->id))',
						),
						'hapus' => array(
	 						'label' => 'delete',
		     				'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
	 						'url' => 'Yii::app()->createUrl("master/position/delete", array("id" => $data->id))',
	 						'options'=>array(
	 							// 'class'=>'btn red delete',
	 							'onclick' => 'return confirm("Are you sure want to delete this Deduction?");',
	 							)
	 						),
						'restore' => array(
							'label' => 'UNDELETE',
							'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
							'url' => 'Yii::app()->createUrl("master/position/restore", array("id" => $data->id))',
							'options'=>array(
				     					// 'class'=>'btn red delete',
								'onclick' => 'return confirm("Are you sure want to undelete this Deduction?");',
								)
							),
						),
				),
 			),
 		)
 	); 
 	?>
 </div>
</div>
<!--Position Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'position-dialog',
	'options'=>array(
		'title'=>'Position',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>'480',
		),
		)); ?>

		<div id="position_div"></div>
		<?php $this->endWidget(); ?>