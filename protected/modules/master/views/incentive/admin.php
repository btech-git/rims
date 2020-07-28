<?php
/* @var $this IncentiveController */
/* @var $model Incentive */

$this->breadcrumbs=array(
	'Company',
	'Incentives'=>array('admin'),
	'Manage Incentives',
);

$this->menu=array(
	array('label'=>'List Incentive', 'url'=>array('index')),
	array('label'=>'Create Incentive', 'url'=>array('create')),
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
	$('#incentive-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

			<div id="maincontent">
					<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.incentive.create")) { ?>
						<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/incentive/create';?>"><span class="fa fa-plus"></span>New Incentive</a>
			<?php }?>
						<h1>Manage Incentives</h1>
						<!-- begin pop up -->
						<div id="employee" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
							<div class="small-12 columns">
								<div id="maincontent">
									<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.incentive.admin")) { ?>
										<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/incentive/admin';?>"><span class="fa fa-th-list"></span>Manage Incentives</a>
			<?php }?>
										<h1>New Incentive</h1>
											
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
				<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>
      		</div>
      		</div>

			<div class="grid-view">
					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'incentive-grid',
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
									'visible'=>'(Yii::app()->user->checkAccess("master.incentive.update"))',
									'url' =>'Yii::app()->createUrl("master/incentive/update",array("id"=>$data->id))',
								),
								'hapus' => array(
		     						'label' => 'delete',
				     				'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
		     						'url' => 'Yii::app()->createUrl("master/incentive/delete", array("id" => $data->id))',
		     						'options'=>array(
		     							// 'class'=>'btn red delete',
		     							'onclick' => 'return confirm("Are you sure want to delete this Incentive?");',
		     							)
		     						),
								'restore' => array(
									'label' => 'UNDELETE',
									'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
									'url' => 'Yii::app()->createUrl("master/incentive/restore", array("id" => $data->id))',
									'options'=>array(
						     					// 'class'=>'btn red delete',
										'onclick' => 'return confirm("Are you sure want to undelete this Incentive?");',
										)
									),
								),
						),
					),
				)); ?>
				</div>
			</div>
