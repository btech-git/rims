<?php
/* @var $this EmployeeMobileController */
/* @var $model EmployeeMobile */

$this->breadcrumbs=array(
	'Company',
	'Employee Mobiles'=>array('admin'),
	'Manage Employee Mobiles',
);

$this->menu=array(
	array('label'=>'List EmployeeMobile', 'url'=>array('index')),
	array('label'=>'Create EmployeeMobile', 'url'=>array('create')),
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
	$('#employee-mobile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


	
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.employeeMobile.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/employeeMobile/create';?>"><span class="fa fa-plus"></span>New Employee Mobile</a>
			<?php }?>
					<h1>Manage Employee Mobiles</h1>


					<div class="search-bar">
						<div class="clearfix button-bar">
							<!--<div class="left clearfix bulk-action">
							<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
							<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
							<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
							<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
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
						'id'=>'employee-mobile-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						// 'summaryText' => '',
						'columns'=>array(
							array (
								'class' 		 => 'CCheckBoxColumn',
								'selectableRows' => '2',	
								'header'		 => 'Selected',	
								'value' => '$data->id',				
								),
							array('name'=>'employee_id', 'value'=>'CHTml::link($data->employee_id, array("view", "id"=>$data->id))', 'type'=>'raw'),
							'mobile_no',
							array(
							'header'=>'Status', 
							'value'=>'$data->status',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('chasisCode[status]', 'chasis_code_status', 
								array(
									''=>'Select',
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
									'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.employeeMobile.update"))',
									'url'=>'Yii::app()->createUrl("master/employeeMobile/update", array("id"=>$data->id))',
								),
							),
						),
						),
					)); ?>
					</div>
			</div>
			<!-- end maincontent -->
		</div>