<?php
/* @var $this CustomerServiceRateController */
/* @var $model CustomerServiceRate */

$this->breadcrumbs=array(
	'Customer Service Rates'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CustomerServiceRate', 'url'=>array('index')),
	array('label'=>'Create CustomerServiceRate', 'url'=>array('create')),
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
	$('#customer-service-rate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
	
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.customerServiceRate.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/customerServiceRate/create';?>" data-reveal-id="color"><span class="fa fa-plus"></span>New Customer Service Rate</a>
			<?php }?>

					<h1>Manage Customer Service Rates</h1>
					<!-- begin pop up -->
					<!--<div id="color" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<div class="small-12 columns">
							<div id="maincontent">
								<div class="clearfix page-action">
									<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/customerServiceRate/admin';?>"><span class="fa fa-th-list"></span>Manage Customer Service Rates</a>
									<h1>New Color</h1>
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
'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
'pager'=>array(
   'cssFile'=>false,
   'header'=>'',
),
				'id'=>'customer-service-rate-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'summaryText'=>'',
				'columns'=>array(
					array (
												'class' 		 => 'CCheckBoxColumn',
												'selectableRows' => '2',	
												'header'		 => 'Selected',	
												'value' => '$data->id',				
												),
					'customer_id',
					'service_id',
					'rate',
					array(
						'class'=>'CButtonColumn',
						'template'=>'{edit}',
						'buttons'=>array
						(
							'edit' => array
							(
								'label'=>'edit',
								'url'=>'Yii::app()->createUrl("master/customerServiceRate/update", array("id"=>$data->id))',
								'visible'=>'(Yii::app()->user->checkAccess("master.customerServiceRate.update"))',
							),
						),
					),
				),
			)); ?>
			</div>
		</div>
	</div>