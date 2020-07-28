<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs=array(
	'Invoice Headers'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List InvoiceHeader', 'url'=>array('index')),
	array('label'=>'Create InvoiceHeader', 'url'=>array('create')),
);*/

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
$('#invoiceSearch').submit(function(){
	$('#invoice-header-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Invoice Headers</h1>-->


<div id="maincontent">
	<div class="row">
		<div class="small-12 columns">
			<div class="clearfix page-action">
			
				<?php //echo CHtml::link('<span class="fa fa-plus"></span>New Consignment In', Yii::app()->baseUrl.'/transaction/PaymentIn/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentInHeader.create"))) ?>
				<h2>Manage Invoice Headers</h2>
			</div>

				<div class="search-bar">
					<div class="clearfix button-bar">
								<div class="form">
								<?php $form=$this->beginWidget('CActiveForm', array(
									'action'=>Yii::app()->createUrl($this->route),
									'method'=>'get',
									'id' => 'invoiceSearch',
									)); ?>

									<div class="row">
									<div class="medium-6 columns">

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<?php echo $form->label($model,'customer_name', array('class'=>'prefix')); ?>
												</div>
												<div class="small-8 columns">
													<?php echo $form->textField($model,'customer_name'); ?>
												</div>
											</div>
										</div>	

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<label class="prefix"><?php echo $form->labelEx($model,'invoice_date'); ?></label>
												</div>
												<div class="small-8 columns">
													<div class="row">
														<div class="medium-5 columns">
															<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
													            'model' => $model,
													             'attribute' => "invoice_date",
													             // additional javascript options for the date picker plugin
													             'options'=>array(
													                'dateFormat' => 'yy-mm-dd',
													     			//'changeMonth'=>true,
																	// 'changeYear'=>true,
																	// 'yearRange'=>'1900:2020'
													             ),
													              'htmlOptions'=>array(),
													         ));
													        ?>
															<?php echo $form->error($model,'invoice_date'); ?>

														</div>
														<div class="medium-7 columns">
															<div class="field">
															<div class="row collapse">
																<div class="small-4 columns">
																	<label class="prefix">To</label>
																</div>
																<div class="small-8 columns">
																<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											                    'model' => $model,
											                     'attribute' => "invoice_date_to",
											                     // additional javascript options for the date picker plugin
											                     'options'=>array(
											                         'dateFormat' => 'yy-mm-dd',
											             //             'changeMonth'=>true,
							        								 // 'changeYear'=>true,
							        								 // 'yearRange'=>'1900:2020'
											                     ),
											                      'htmlOptions'=>array(),
											                 ));
											                ?>
																</div>
															</div>
														</div>

														</div>
													</div>
												</div>
											</div>
										</div>	

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<label class="prefix"><?php echo $form->labelEx($model,'due_date'); ?></label>
												</div>
												<div class="small-8 columns">

															<div class="row">
																<div class="medium-5 columns">
																	<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
													                    'model' => $model,
													                     'attribute' => "due_date",
													                     // additional javascript options for the date picker plugin
													                     'options'=>array(
													                         'dateFormat' => 'yy-mm-dd',
													             //             'changeMonth'=>true,
									        								 // 'changeYear'=>true,
									        								 // 'yearRange'=>'1900:2020'
													                     ),
													                      'htmlOptions'=>array(),
													                 ));
													                ?>
																	<?php echo $form->error($model,'due_date'); ?>
																</div>
																<div class="medium-7 columns">
																	<div class="field">
																		<div class="row collapse">
																			<div class="small-4 columns">
																				<label class="prefix">To</label>
																			</div>
																			<div class="small-8 columns">
																				<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
																		            'model' => $model,
																		             'attribute' => "due_date_to",
																		             // additional javascript options for the date picker plugin
																		             'options'=>array(
																		                 'dateFormat' => 'yy-mm-dd',
																		     //             'changeMonth'=>true,
																						 // 'changeYear'=>true,
																						 // 'yearRange'=>'1900:2020'
																		             ),
																		              'htmlOptions'=>array(),
																		         ));
																		        ?>
																				<?php echo $form->error($model,'due_date_to'); ?>
																			</div>
																		</div>
																	</div>															
																</div>
															</div>

													
												</div>
											</div>
										</div>	
										</div>	
										<div class="medium-6 columns">

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<?php echo $form->label($model,'invoice_number', array('class'=>'prefix')); ?>
												</div>
												<div class="small-8 columns">
													<?php echo $form->textField($model,'invoice_number'); ?>
												</div>
											</div>
										</div>	

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<?php echo $form->label($model,'status', array('class'=>'prefix')); ?>
												</div>
												<div class="small-8 columns">						
													<?php echo  $form->dropDownList($model, 'status', array('PAID' => 'PAID', 'NOT PAID' => 'NOT PAID', ), array('prompt' => 'Select',)); ?>
												</div>
											</div>
										</div>	

										<div class="buttons text-right">
											<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton')); ?>
										</div>

										</div>
							        </div>

								<?php $this->endWidget(); ?>
							    </div>
			        </div>
			    </div>
        	
        	<div class="grid-view">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'invoice-header-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					// 'summaryText'=>'',
					'template' => '{items}<!--<div class="clearfix">{summary}{pager}</div>-->',
					'pager'=>array(
					   'cssFile'=>false,
					   'header'=>'',
					),
					'columns'=>array(
						array(
							'class'=>'CCheckBoxColumn',  //CHECKBOX COLUMN ADDED.
							'selectableRows'=>2,         //MULTIPLE ROWS CAN BE SELECTED.
							'checked' =>function($data) use($prChecked) {
			           		    return in_array($data->id, $prChecked); 
			           		}, 
			        	),	
						//'id',
						array('name'=>'invoice_number', 'value'=>'CHTml::link($data->invoice_number, array("view", "id"=>$data->id))', 'type'=>'raw'),
						//'invoice_number',
						'invoice_date',
						'due_date',
						//'reference_type',
						array('name'=>'reference_type', 'value'=>'$data->reference_type == 1 ? "Sales Order" : "Retail Sales"'),
						array('name'=>'sales_order_id', 'value'=>'$data->sales_order_id != null ? $data->salesOrder->sale_order_no : $data->registrationTransaction->sales_order_number'),
						//array('name'=>'registration_transaction_id', 'value'=>'$data->registration_transaction_id != null ? $data->registrationTransaction->transaction_number : "-"'),
						//'sales_order_id',
						//'registration_transaction_id',
						/*
						'registration_transaction_id',
						'customer_id',
						'vehicle_id',
						'ppn',
						'pph',
						'branch_id',
						'user_id',
						'supervisor_id',
						'status',
						'service_price',
						'product_price',
						'pph_total',
						'ppn_total',
						'total_price',
						'in_words',
						'note',
						*/
						array(
								'class'=>'CButtonColumn',
								'template'=>'{edit}',
								'buttons'=>array
								(
									'edit' => array
									(
										'label'=>'edit',
										'url'=>'Yii::app()->createUrl("transaction/invoiceHeader/update", array("id"=>$data->id))',
										'visible'=>'Yii::app()->user->checkAccess("transaction.invoiceHeader.update")'
										),
									),
								),
						),
						)); ?>

				<div class="button-group">
					<?php if (Yii::app()->user->checkAccess("transaction.invoiceHeader.viewInvoices")): ?>
						<?php echo CHtml::button("View Invoice",array("id"=>"btnProses", 'class'=>'button cbutton')); ?>
					<?php endif ?>
					<?php if (Yii::app()->user->checkAccess("transaction.invoiceHeader.pdfAll")): ?>
						<?php echo CHtml::button("Export PDF",array("id"=>"btnProsesPdf", 'class'=>'button cbutton')); ?>
					<?php endif ?>
					
					<?php echo CHtml::button("Clear Selected",array("id"=>"btnClear", 'class'=>'button cbutton')); ?>
				</div>

			</div>
		</div>
	</div> <!-- end row -->
</div> <!-- end maintenance -->

<?php
Yii::app()->clientScript->registerScript('centang','
	$("#btnProses").click(function(){
        var checked=$("#invoice-header-grid").yiiGridView("getChecked","invoice-header-grid_c0");
        var count=checked.length;
        if(count>0){
            $.ajax({
                    data:{checked:checked},
                    url:"'.CHtml::normalizeUrl(array('invoiceHeader/prTemp')).'",
                    success:function(data){
                    	$("#invoice-header-grid").yiiGridView("update",{});
                    	window.location.href = "'.CHtml::normalizeUrl(array('invoiceHeader/viewInvoices')).'";
                    },              
            });
        }else{
        	console.log("No Invoice items selected");
        	alert("No Invoice items selected");
        }
    });

	$("#btnProsesPdf").click(function(){
        var checked=$("#invoice-header-grid").yiiGridView("getChecked","invoice-header-grid_c0");
        var count=checked.length;
        if(count>0){
            $.ajax({
                    data:{checked:checked},
                    url:"'.CHtml::normalizeUrl(array('invoiceHeader/prTemp')).'",
                    success:function(data){
                    	$("#invoice-header-grid").yiiGridView("update",{});
                    	window.location.href = "'.CHtml::normalizeUrl(array('invoiceHeader/pdfAll')).'";
                    },              
            });
        }else{
        	console.log("No Invoice items selected");
        	alert("No Invoice items selected");
        }
    });

	$("#btnClear").click(function(){
		var checked="clear";
		$.ajax({
            data:{checked:checked},
            url:"'.CHtml::normalizeUrl(array('invoiceHeader/prTemp')).'",
            success:function(data){
            	$("#invoice-header-grid").yiiGridView("update",{});
            },              
        });
    });

');
?>
<?php 
	/*
	$customer = new Customer('search');
	$customerCriteria = new CDbCriteria;
	$customerCriteria->compare('name',$customer->name,true);
	$customerDataProvider = new CActiveDataProvider('Customer', array(
	'criteria'=>$customerCriteria,
	));?>


	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'customer-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'Customer',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
			),)
	);
	?> 


	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'customer-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'Customer',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
			),)
	);
	?> 

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'customer-grid',
		'dataProvider'=>$customerDataProvider,
		'filter'=>$customer,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
			'cssFile'=>false,
			'header'=>'',
			),
		'selectionChanged'=>'js:function(id){
			jQuery("#customer-dialog").dialog("close");
			jQuery.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCustomer', array('id'=> '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					jQuery("#Invoice_customer_name").val(data.name);
				},
			});
		}',
		'columns'=>array(
			//'id',
			//'code',
			'customer_type',
			'name',
			'email',
			),
		)
	);
	?>

	<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); */?>