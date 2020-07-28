<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('admin')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('#menushow').click(function(){
/*	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;*/
});
$('.search-form form').submit(function(){
	$('#registration-transaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
	<div class="clearfix page-action">
		<?php echo CHtml::link('<span class="fa fa-plus"></span>New Registration', Yii::app()->baseUrl.'/frontDesk/registrationTransaction/index', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("frontDesk.transactionPurchaseOrder.admin"))); ?>
		<h1>Manage Registration Transactions</h1>

				<div class="search-bar">
					<div class="clearfix button-bar">
						<div class="left clearfix bulk-action">
			   			</div>
				<div class="row">
					<div class="medium-8 columns">

				<?php $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'get',
					'htmlOptions'=>array('id'=>'search_heading-range'),
				)); ?>
					<div class="row">
						<div class="medium-4 columns">
							<?php echo CHtml::dropDownList('RegistrationTransaction[status]', $model->status, 
                                array(
                                    ''=>'All',
                                    'Registration'=>'Registration',
                                    'Pending'=>'Pending',
                                    'Available'=>'Available',
                                    'On Progress'=>'On Progress',
                                    'Finished'=>'Finished'
                                ), 
                                array("style"=>"margin-bottom:0px;")
                            ); ?>
						</div>
						<div class="medium-4 columns">
							<?php 
								// Date range search inputs
								/*$attribute = 'transaction_date';
								for ($i = 0; $i <= 1; $i++)
								{
								    echo ($i == 0 ? Yii::t('main', 'From:') : Yii::t('main', 'To:'));
								    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
								        'id'=>CHtml::activeId($model, $attribute.'_'.$i),
								        'model'=>$model,
								        'attribute'=>$attribute."[$i]",
								    )); 
								}*/
							?>
							<?php $attribute = 'transaction_date'; ?>
								<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
								'id'=>CHtml::activeId($model, $attribute.'_0'),
								'model'=>$model,
								'attribute'=>$attribute."_from",
								'options'=>array('dateFormat'=>'yy-mm-dd'),
								'htmlOptions'=>array(
								    'style'=>'margin-bottom:0px;',
							    	'placeholder'=>'Transaction Date From'
								),
							)); ?>									
						</div>
						<div class="medium-4 columns">
				
							<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'id'=>CHtml::activeId($model, $attribute.'_1'),
							'model'=>$model,
							'attribute'=>$attribute."_to",
							'options'=>array('dateFormat'=>'yy-mm-dd'),
							'htmlOptions'=>array(
							    'style'=>'margin-bottom:0px;',
							    'placeholder'=>'Transaction Date To'
							),
							)); ?>									
						</div>
					</div>
     			<?php $this->endWidget(); ?>
     			</div>
					<div class="medium-2 columns">
     					<a onClick="$('.search-form').slideToggle(600);$('.bulk-action').toggle(); $(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
		$('#RegistrationTransaction_status').hide();
		$('#RegistrationTransaction_transaction_date_0').hide();
		$('#RegistrationTransaction_transaction_date_1').hide();
	}else {
		$(this).text('Advanced Search');
		$('#RegistrationTransaction_status').show();
		$('#RegistrationTransaction_transaction_date_0').show();
		$('#RegistrationTransaction_transaction_date_1').show();

	} return false;" href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
     				</div>
     		</div>
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
	'id'=>'registration-transaction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'rowCssClassExpression' => '(($data->status == "Finished")?"hijau":"merah")',
	// 'rowCssClassExpression' => '(($data->status == "Finished")?"hijau":(($data->status == "Pending")?"merah":""))',
	'columns'=>array(
		array(
		    'header'=>'#',
		    'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',       //  row is zero based
	    ),
		'transaction_number',
		// 'transaction_date',
		array(
            'name'=>'transaction_date',
            // 'value'=>'$data->transaction_date',
			'value'=>"Yii::app()->dateFormatter->formatDateTime(\$data->transaction_date, 'medium', 'short')",
            'filter'=>false, // Set the filter to false when date range searching
        ),
		array('name'=>'plate_number', 'value'=>'$data->vehicle->plate_number'),
		array(
            'header'=>'Car Make',
            'name'=>'car_make_code',
            'value'=>'empty($data->vehicle->carMake) ? "" : $data->vehicle->carMake->name'
        ),
		//array('header'=>'Car Model','name'=>'car_model_code','value'=>'$data->vehicle->carModel->name'),
		// array('header'=>'Color','name'=>'car_color','value'=>'$data->vehicle->getColor($data->vehicle,"color_id")',
		// 	'filter'=>CHtml::dropDownList('RegistrationTransaction[car_color]', 'car_color', CHtml::listData(Colors::model()->findAll(),'id','name'), array('class'=>'form-control','empty'=>'--Select Color--')),),
		'work_order_number',
		array(
			'header'=>'Repair Type',
			'name'=>'repair_type', 
			'value'=>'$data->repair_type',
			'type'=>'raw',
			'filter'=>CHtml::dropDownList('RegistrationTransaction[repair_type]', $model->repair_type, 
				array(
					'GR'=>'General Repair',
					'BR'=>'Body Repair',
				), array('class'=>'form-control','empty'=>'--Select Branch--')
			),
		),								
		'problem',
		// 'customer_id',
		array(
			'header'=>'Customer Name',
			'name'=>'customer_name',
			'value'=>'$data->customer->name',
		),
		'sales_order_number',
		array(
			'header'=>'Invoice #',
			'filter'=>false,
			'value'=> function($data) {
			    $invoiceCriteria = new CDbCriteria;
	        	$invoiceCriteria->addCondition("status !='CANCELLED'");
	        	$invoiceCriteria->addCondition("registration_transaction_id = ".$data->id);
	        	$invoice = InvoiceHeader::model()->find($invoiceCriteria);
	        	$invoiceNumber = "";
	        	if(count($invoice)!= 0)
	        		$invoiceNumber = $invoice->invoice_number;
	        	return $invoiceNumber;
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
					'Registration'=>'Registration',
					'Pending'=>'Pending',
					'Available'=>'Available',
					'On Progress'=>'On Progress',
					'Finished'=>'Finished'
				)
			),
		),


		/*
		'pic_id',
		'vehicle_id',
		'branch_id',
		'user_id',
		'total_quickservice',
		'total_quickservice_price',
		'total_service',
		'subtotal_service',
		'discount_service',
		'total_service_price',
		'total_product',
		'subtotal_product',
		'discount_product',
		'total_product_price',
		*/
		
		array(
			'class'=>'CButtonColumn',
			'template'=>'{views} {edit} {hapus}',
			'buttons'=>array
			(

				'views' => array
				(
					'label'=>'view',
					'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/view", array("id"=>$data->id))',
					'visible'=>'Yii::app()->user->checkAccess("transaction.registrationTrasaction.view")'
				),

				'edit' => array
				(
					'label'=>'edit',
					'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/update", array("id"=>$data->id))',
					'visible'=>'$data->status != "Finished" && Yii::app()->user->checkAccess("transaction.registrationTrasaction.update")',
				),
				'hapus' => array
				(
					'label'=>'delete',
					'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/delete", array("id"=>$data->id))',
					'visible'=>'$data->status != "Finished" && Yii::app()->user->checkAccess("transaction.registrationTrasaction.delete")'
				),
			),
		),
	),
)); ?>
		</div>
		
	</div>
</div>

<?php 
  Yii::app()->clientScript->registerScript('search',"

		// $('#ServicePricelist_findkeyword').keypress(function(e) {
		//     if(e.which == 13) {
		// 		$.fn.yiiGridView.update('service-pricelist-grid', {
		// 			data: $(this).serialize()
		// 		});
		//         return false;
		//     }
		// });

        $('#RegistrationTransaction_status,#RegistrationTransaction_transaction_date_1').change(function(){
        	// if ($('#RegistrationTransaction_transaction_date_0').val().lenght != 0) {
	            $.fn.yiiGridView.update('registration-transaction-grid', {
	                data: $('#search_heading-range').serialize()
	            });
        	// }
            return false;
        });

		
    ");
?>