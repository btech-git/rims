<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */


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

	$('#registration-service-grid a.registration-service-start').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});

	$('#registration-service-grid a.registration-service-finish').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});

");
?>

<div id="maincontent">
	<div class="clearfix page-action">
		<!--<a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/frontDesk/registrationTransaction/index';?>" data-reveal-id="color"><span class="fa fa-plus"></span>Registration Transactions</a>-->
		<!-- <h1>Manage Service Progress</h1> -->

		<div>
			<?php
				$duration = 0;
				$registrationServiceBodyRepairs = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$registrationId,'is_body_repair'=>1));
        		foreach ($registrationServiceBodyRepairs as $rs) {
            		$duration += $rs->hour;
            	}
            	print_r($regsitrationServices)
			?>
 			<table>
 				<tr>
 					<td>Plate Number: <?php echo $registration->vehicle->plate_number; ?></td>
 					<td>Status      : <?php echo $registration->status; ?></td>
 				</tr>
 				<tr>
 					<td>Work Order #: <?php echo $registration->work_order_number; ?></td>
 					<td>Duration: <?php echo $duration . ' hr'; ?></td>
 				</tr>
 			</table>
 		</div>

		<div class="search-bar">
			<div class="clearfix button-bar">

     		<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
     		<div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php //$this->renderPartial('_search',array(
                        //'registrationService'=>$registrationService,
                    //)); ?>
                </div><!-- search-form -->				
     		</div>
     	</div>
		<div class="grid-view">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'registration-service-grid',
				'dataProvider'=>$registrationServiceDataProvider,
				'filter'=>$registrationService,
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
					'cssFile'=>false,
					'header'=>'',
				),
				'columns'=>array(
					array(
					  	'header'=>"No",
						'value'=>'$this->grid->dataProvider->pagination->offset + $row+1',
					),
					array('name'=>'service_id', 'value'=>'$data->service->name'),
					array('header'=>'Category', 'value'=>'$data->service->serviceCategory->name'),
					array(
        				'header'=>'Product',
        				'type'=>'html',
               			'value'=> function($data) {
                    		$products = array();
                    		foreach ($data->service->serviceMaterials as $serviceMaterial) {
                        		$products[] = $serviceMaterial->product->name . '<br>';
                        	}
                        	return implode('', $products);
                        }
                    ),
                    'start',
                    'end',
                    'status',
                    array(
						'class'=>'CButtonColumn',
						'template'=>'{start} {finish}',
						'buttons'=>array
						(
							'start' => array
							(
								'label'=>'Start',
								'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementStartService", array("serviceId"=>$data->service_id,"registrationId"=>'.$_GET["registrationId"].'))',
								'options'=>array('class'=>'registration-service-start'),
							),
							'finish' => array
							(
								'label'=>'Finish',
								'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementFinishService", array("serviceId"=>$data->service_id,"registrationId"=>'.$_GET["registrationId"].'))',
								'options'=>array('class'=>'registration-service-finish'),
							),
						),
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{view}{update}',
						'buttons'=>array
						(
							'view' => array
							(
								'label'=>'View',
								'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementServiceView", array("serviceId"=>$data->service_id,"registrationId"=>'.$_GET["registrationId"].'))',
							),
							'update' => array
							(
								'label'=>'Update',
								'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementServiceUpdate", array("serviceId"=>$data->service_id,"registrationId"=>'.$_GET["registrationId"].'))',
							),
						),
					),
				),
			)); ?>
		</div>
	</div>
</div>