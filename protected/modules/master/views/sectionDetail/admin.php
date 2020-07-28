<?php
/* @var $this SectionDetailController */
/* @var $model SectionDetail */

$this->breadcrumbs=array(
	'Warehouse'=>Yii::app()->baseUrl.'/master/warehouse/admin',
	'Section Details'=>array('admin'),
	'Manage Section Details',
);

$this->menu=array(
	array('label'=>'List Section Detail', 'url'=>array('index')),
	array('label'=>'Create Section Detail', 'url'=>array('create')),
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
	$('#section-detail-grid').yiiGridView('update', {
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
				$('#section_detail_div').html(html);
				$('#section-detail-dialog').dialog('open');
			},
		});
	});
");
?>





<?php
/* @var $this PositionController */
/* @var $dataProvider CActiveDataProvider */
?>
	<div id="maincontent">
		<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.sectionDetail.create")) { ?>
				<!--<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/sectionDetail/create';?>"><span class="fa fa-plus"></span>New Section Detail</a>-->
						<?php echo CHtml::button('New Section Detail', array('id' => 'create-button', 'class'=>'button success right')); ?>
			<?php }?>
						<h1>Manage Section Detail</h1>
						<!-- begin pop up -->
						<div id="employee" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
							<div class="small-12 columns">
								<div id="maincontent">
									<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.sectionDetail.admin")) { ?>
										<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/sectionDetail/admin';?>"><span class="fa fa-th-list"></span>Manage Section Detail</a>
			<?php }?>
										<h1>New Section Detail</h1>
											
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
					'id'=>'section-detail-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					// 'summaryText' => '',
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
							'value'=>'$data->status',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('SectionDetail[status]', 'sectionDetail_status', 
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
									'visible'=>'(Yii::app()->user->checkAccess("master.sectionDetail.update"))',
									'url' => 'Yii::app()->createUrl("/master/sectionDetail/ajaxHtmlUpdate", array("id" => $data->id))',
									'options' => array(  
										'ajax' => array(
											'type' => 'POST',
											// ajax post will use 'url' specified above 
											'url' => 'js: $(this).attr("href")',
											'success' => 'function(html) {
												$("#section_detail_div").html(html);
												$("#section-detail-dialog").dialog("open");
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
<!--Section detail Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'section-detail-dialog',
        'options'=>array(
            'title'=>'Section Detail',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'480',
        ),
 )); ?>
 
<div id="section_detail_div"></div>

<?php $this->endWidget(); ?>