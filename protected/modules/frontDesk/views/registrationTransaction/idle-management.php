<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Manage',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('admin')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('index')),
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
		$('#registration-transaction-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	
	$('#info').click(function(){
		href = $(this).attr('href')
		$.ajax({
			type: 'POST',
			url: href,
			data: $('form').serialize(),
			success: function(html) {
				$('#info-dialog').dialog('open');
				$('#info_div').html(html);
			},
		});
	});
	
	
");
?>

<div id="maincontent">
	<div class="clearfix page-action">
		<!--<a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/frontDesk/registrationTransaction/index';?>" data-reveal-id="color"><span class="fa fa-plus"></span>Registration Transactions</a>-->
		<h1>Manage Transaction Progress</h1>


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
			<?php
				$this->widget('ext.groupgridview.GroupGridView', array(
				   	'id'=>'registration-transaction-grid',
					'dataProvider'=>$model->search(), //$modelDataProvider,
					'filter'=>$model,
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
						'cssFile'=>false,
						'header'=>'',
					),
				    'mergeColumns' => 'plate_number',
				   	'columns'=>array(
						array('name'=>'plate_number', 'value'=>'$data->vehicle->plate_number'),
						array('name'=>'vehicle_id', 'header' => 'Info', 'value'=>'CHTml::link("Info", array("idleManagementAjaxInfo", "registrationId"=>$data->id, "vehicleId"=>$data->vehicle_id), array("id"=>"info", "onclick"=>"return false;"))', 'type'=>'raw', 'filter'=>''),
						'work_order_number',
						'work_order_date',
						array(
	        				'header'=>'Services',
	        				'name'=>'search_service',
	        				'type'=>'html',
	               			/*'value'=> function($data) {
	                    		$services = array();

	                    		if($data->repair_type == 'GR'){
	                    			foreach ($data->registrationServices as $registrationService) {
	                    			
	                        			$services[] = $registrationService->service->name . '<br>';
	                        		}
	                    		}
	                    		else{
	                    			foreach ($data->registrationServices as $registrationService) {
	                    				if($registrationService->is_body_repair == 1)
	                        				$services[] = $registrationService->service->name . '<br>';
	                        		}
	                    		}
	                    		
	                        	return implode('', $services);
	                        }*/
	                        'value'=>'$data->getServices()',
	                    ),
	                    array(
	        				'header'=>'Duration',
	        				'type'=>'html',
	               			'value'=> function($data) {
	                    		$duration = 0;
	                    		/*
	                    		foreach ($data->registrationServices as $registrationService) {
	                        		$duration += $registrationService->service->flat_rate_hour;
	                        	}
	                        	*/
	                        	$registrationServiceBodyRepairs = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$data->id,'is_body_repair'=>1));
				        		foreach ($registrationServiceBodyRepairs as $rs) {
				            		$duration += $rs->hour;
				            	}
	                        	return $duration . ' hr';
	                        }
	                    ),
	                    array(
							'header'=>'WO Status',
							'name'=>'status', 
							'value'=>'$data->status',
							'type'=>'raw',
							'filter'=>CHtml::dropDownList('RegistrationTransaction[status]', $model->status, 
								array(
									''=>'All',
									'Pending'=>'Pending',
									'Available'=>'Available',
									'On Progress'=>'On Progress',
									'Finished'=>'Finished'
								)
							),
						),
						array('name'=>'user_id', 'value'=>'!empty($data->user->username)?$data->user->username:""'),
						array(
							'class'=>'CButtonColumn',
							'template'=>'{vw} {edit}',
							'buttons'=>array
							(
								'vw' => array
								(
									'label'=>'view',
									'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementServices", array("registrationId"=>$data->id))',
									//'options'=>array('class'=>'registration-service-view','id'=>''),
									'click'=>"js:function(){
										var url = $(this).attr('href');
										/*
								        //  do your post request here
								        console.log(url);
								        $.post(url,function(html){
								            $('#registration-service-dialog').dialog('open');
											$('#registration_service_div').html(html);
								         });
								        return false;*/
								        newwindow=window.open(url,'name','height=600,width=1200,left=100');
										if (window.focus) {newwindow.focus()}
										newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
										newwindow.onunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
										return false;
									}"
								),
								'edit' => array
								(
									'label'=>'update',
									'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementUpdate", array("id"=>$data->id))',
									'click'=>"js:function(){
										var url = $(this).attr('href');
								        //  do your post request here
								        console.log(url);
								        $.post(url,function(html){
								            $('#update-status-dialog').dialog('open');
											$('#update_status_div').html(html);
								         });
								        return false;
									}"
								),
							),
						),
					),
				));
			?>
		</div>
	</div>
</div>

<!--Registration Service Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'registration-service-dialog',
	'options'=>array(
			'title'=>'Registration Service',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>'1200',
			'close'=>'js:function(){ $.fn.yiiGridView.update("registration-transaction-grid"); }',
		),
	));
?>

<div id="registration_service_div"></div>
<?php $this->endWidget(); ?>

<!--Update Status Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'update-status-dialog',
	'options'=>array(
			'title'=>'Update Status',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>'1200',
			'close'=>'js:function(){ $.fn.yiiGridView.update("registration-transaction-grid"); }',
		),
	));
?>

<div id="update_status_div"></div>
<?php $this->endWidget(); ?>

<!--Level Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'info-dialog',
	'options'=>array(
    	'title'=>'Info',
    	'autoOpen'=>false,
    	'modal'=>true,
    	'width'=>'800',
    ),
)); ?>

<div id="info_div"></div>
<?php $this->endWidget(); ?>