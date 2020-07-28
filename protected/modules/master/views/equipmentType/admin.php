<?php
/* @var $this EquipmentTypeController */
/* @var $model EquipmentType */

$this->breadcrumbs=array(
	'Product',
	'Equipment Types'=>array('admin'),
	'Manage Equipment Types',
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
		$('#equipment-type-grid').yiiGridView('update', {
			data: $(this).serialize()
			// console.log(data);
		});
		return false;
	});
	");
	?>
	<div id="maincontent">
		<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.equipmentType.create")) { ?>
			<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/EquipmentType/create';?>"><span class="fa fa-plus"></span>New Equipment Type</a>
			<?php }?>
			<h2>Manage Equipment Type</h2>
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
			         		'id'=>'equipment-type-grid',
			         		'dataProvider'=>$model->search(),
			         		'filter'=>$model,
			         		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
			         		'pager'=>array(
			         			'cssFile'=>false,
			         			'header'=>'',
			         			),
			         		'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',

			         		'columns'=>array(
							//'id',
			         			array (
			         				'class' 		 => 'CCheckBoxColumn',
			         				'selectableRows' => '2',	
			         				'header'		 => 'Selected',	
			         				'value' => '$data->id',				
			         				),
							//'name',
			         			array(
			         				'name'=>'name', 
			         				'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id), array("id"=>"popupLink"))', 
			         				'type'=>'raw'
			         			),
			         			'description',
			         			// 'is_deleted',
			         			array(
			         				'header'=>'Status', 
			         				'name'=>'status',
			         				'value'=>'$data->status',
			         				'type'=>'raw',
			         				'filter'=>CHtml::dropDownList('EquipmentType[status]', $model->status, 
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
			         					'edit' => array
			         					(
			         						'label'=>'edit',
			         						// 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
									'visible'=>'(Yii::app()->user->checkAccess("master.equipmentType.update"))',

			         						'url'=>'Yii::app()->createUrl("master/equipmentType/update", array("id"=>$data->id))',
			         						),
			         					'hapus' => array(
			         						'label' => 'delete',
			         						'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',

			         						'url' => 'Yii::app()->createUrl("master/equipmentType/delete", array("id" => $data->id))',
			         						'options'=>array(
			     							// 'class'=>'btn red delete',
			         							'onclick' => 'return confirm("Are you sure want to delete this equipments?");',
			         							)
			         						),

			         					'restore' => array(
			         						'label' => 'UNDELETE',
			         						'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
			         						'url' => 'Yii::app()->createUrl("master/equipmentType/restore", array("id" => $data->id))',
			         						'options'=>array(
				     					// 'class'=>'btn red delete',
			         							'onclick' => 'return confirm("Are you sure want to undelete this EquipmentType?");',
			         							)
			         						),
			         					),
			         				),
			         			),
			         			)); ?>
			         		</div>
			         	</div>
			         	<!-- end maincontent -->
<?php
Yii::app()->clientScript->registerScript('search', "

$('[id^=popupLink]').click(function(e) {
    var url=this.href;
	newwindow=window.open(url,'name','height=500,width=800,left=100,top=100');
	if (window.focus) {newwindow.focus()}
	// newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('equipment-type-grid')}
	// newwindow.onunload = function(){  $.fn.yiiGridView.update('equipment-type-grid')}
	e.preventDefault();
    return false;
});
");
?>

