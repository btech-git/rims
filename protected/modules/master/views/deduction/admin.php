<?php
/* @var $this DeductionController */
/* @var $model Deduction */

$this->breadcrumbs=array(	
	'Company',	
	'Deductions'=>array('admin'),
	'Manage Deductions',
);
/*
$this->menu=array(
	array('label'=>'List Deduction', 'url'=>array('index')),
	array('label'=>'Create Deduction', 'url'=>array('create')),
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
	$('#deduction-grid').yiiGridView('update', {
	data: $(this).serialize()
	});
	return false;
});
");
?>


	
	
			<div id="maincontent">
					<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.deduction.create")) { ?>
						<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/deduction/create';?>"><span class="fa fa-plus"></span>New Deduction</a>
<?php }?>
						<h1>Manage Deductions</h1>
						<!-- begin pop up -->
						<div id="employee" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
							<div class="small-12 columns">
								<div id="maincontent">
									<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.deduction.admin")) { ?>
										<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/deduction/admin';?>"><span class="fa fa-th-list"></span>Manage Deductions</a>
<?php }?>
										<h1>New Deduction</h1>
											
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
						'id'=>'deduction-grid',
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
						'description',
						//'amount',
						array(
							'class'=>'CButtonColumn',
							'template'=>'{edit} {hapus} {restore}',
							'buttons'=>array
							(
								'edit'=> array (
									'label'=>'edit',
				     				// 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
									'visible'=>'(Yii::app()->user->checkAccess("master.deduction.update"))',
									'url' =>'Yii::app()->createUrl("master/deduction/update",array("id"=>$data->id))',
								),
								'hapus' => array(
		     						'label' => 'delete',
				     				'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
		     						'url' => 'Yii::app()->createUrl("master/deduction/delete", array("id" => $data->id))',
		     						'options'=>array(
		     							// 'class'=>'btn red delete',
		     							'onclick' => 'return confirm("Are you sure want to delete this Deduction?");',
		     							)
		     						),
								'restore' => array(
									'label' => 'UNDELETE',
									'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
									'url' => 'Yii::app()->createUrl("master/deduction/restore", array("id" => $data->id))',
									'options'=>array(
						     					// 'class'=>'btn red delete',
										'onclick' => 'return confirm("Are you sure want to undelete this Deduction?");',
										)
									),
								),
						),

					),
				)); ?>
				</div>
			</div>