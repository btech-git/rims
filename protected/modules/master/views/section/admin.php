<?php
/* @var $this SectionController */
/* @var $model Section */

$this->breadcrumbs=array(
	'Warehouse'=>Yii::app()->baseUrl.'/master/warehouse/admin',	
	'Sections'=>array('admin'),
	'Manage Sections',
);

$this->menu=array(
	array('label'=>'List Section', 'url'=>array('index')),
	array('label'=>'Create Section', 'url'=>array('create')),
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
	$('#section-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
		<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.section.create")) { ?>
			<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/section/create';?>" data-reveal-id="section"><span class="fa fa-plus"></span>New Section</a>
			<?php }?>
			<h1>Manage Sections</h1>
			<!-- begin pop up -->
			<!--<div id="section" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
				<div class="small-12 columns">
					<div id="maincontent">
						<div class="clearfix page-action">
							<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/section/admin';?>"><span class="fa fa-th-list"></span>Manage Section</a>
							<h1>New Section</h1>
								<div class="form">

								   <form method="post" action="" id="popup-form">   <hr>
								   <p class="note">Fields with <span class="required">*</span> are required.</p>

								   
								   <div class="row">
								      <div class="small-12 medium-6 columns">

								         <div class="field">
								            <div class="row collapse">
								               <div class="small-4 columns">
								                  <label class="prefix">Code</label>
								                </div>
								               <div class="small-8 columns">
								                  <input type="text" maxlength="100" size="60" disabled="true">                                 
								                </div>
								            </div>
								         </div>

							         	<div class="field">
								            <div class="row collapse">
								               <div class="small-4 columns">
								                  <label class="prefix">Rack Number</label>
								                </div>
								               <div class="small-8 columns">
								                  <input type="text" maxlength="100" size="60">                                 
								                </div>
								            </div>
								         </div>
								         <div class="field">
								            <div class="row collapse">
								               <div class="small-4 columns">
								                  <label class="prefix">Column</label>
								                </div>
								               <div class="small-8 columns">
								                  <input type="text" maxlength="100" size="60">                                 
								                </div>
								            </div>
								         </div>
								         <div class="field">
								            <div class="row collapse">
								               <div class="small-4 columns">
								                  <label class="prefix">Row</label>
								                </div>
								               <div class="small-8 columns">
								                  <input type="text" maxlength="100" size="60">                                 
								                </div>
								            </div>
								         </div>

								      </div>
								   </div>

								   <hr>

								   <div class="field buttons text-center">
								      <input type="button" value="Create" name="yt0" class="button cbutton">  
								    </div>

								   </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>-->
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
			'id'=>'section-grid',
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
				array('name'=>'rack_number', 'value'=>'CHTml::link($data->rack_number, array("view", "id"=>$data->id))', 'type'=>'raw'),
				'column',
				'row',						
				array(
					'class'=>'CButtonColumn',
					'template'=>'{edit}',
					'buttons'=>array
					(
						'edit' => array
						(
							'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.section.update"))',
							'url'=>'Yii::app()->createUrl("master/section/update", array("id"=>$data->id))',
						),
					),
				),
			),
		)); ?>
		</div>
	</div>
	<!-- end maincontent -->
</div>