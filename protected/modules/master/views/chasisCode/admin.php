<?php
/* @var $this ChasisCodeController */
/* @var $model ChasisCode */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Chassis Codes'=>array('admin'),
	'Manage Chassis Codes',
);
/*
$this->menu=array(
	array('label'=>'List ChasisCode', 'url'=>array('index')),
	array('label'=>'Create ChasisCode', 'url'=>array('create')),
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
	$('#chasis-code-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



	<!--<div class="row">
		<div class="small-12 columns">
			<div class="breadcrumbs">
				<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
				<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
				<a href="<?php echo Yii::app()->baseUrl.'/master/chasisCode/admin';?>">Chassis Code</a>
				<span>Manage Chassis Codes</span>
			</div>
		</div>
	</div>-->
		
			<div id="maincontent">
				<div class="clearfix page-action">
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/chasisCode/create';?>" data-reveal-id="chassis-code"><span class="fa fa-plus"></span>New Chassis Code</a>
					<h1>Manage Chassis Codes</h1>
					<!-- begin pop up -->
					<!--<div id="chassis-code" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<div class="small-12 columns">
							<div id="maincontent">
								<div class="clearfix page-action">
									<a class="button cbutton right" href="chassis-code.php"><span class="fa fa-th-list"></span>Manage Chassis Code</a>
									<h1>New Chassis Code</h1>
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
										                  <label class="prefix">Name</label>
										                </div>
										               <div class="small-8 columns">
										                  <input type="text" maxlength="100" size="60">                                 
										                </div>
										            </div>
										         </div>

													<div class="field">
														<div class="row collapse">
															<div class="small-4 columns">
																<label class="prefix">Status</label>
															</div>
															<div class="small-8 columns">
																<select>
																	<option selected="selected" value="1">Active</option>
																	<option value="-1">Inactive</option>
																</select>                                 
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
				'id'=>'chasis-code-grid',
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
					'year_start',
					'year_end',
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
									'url'=>'Yii::app()->createUrl("master/chasisCode/update", array("id"=>$data->id))',
								),
							),
						),
				),
			)); ?>
			</div>

					
      			</div>
      		</div>
			
			<!-- end maincontent -->
		</div>
	</div>