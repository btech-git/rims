<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $purchaseOrder->header TransactionPurchaseOrder */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
	<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Purchase Order', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.admin"))) ?>
	<h1><?php if($purchaseOrder->header->id==""){ echo "New Transaction Purchase Order"; }else{ echo "Update Transaction Purchase Order";}?></h1>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'transaction-purchase-order-form',
			'enableAjaxValidation'=>false,
			)); ?>

			<p class="note">Fields with <span class="required">*</span> are required.</p>

			<?php echo $form->errorSummary($purchaseOrder->header); ?>
			<?php echo $form->errorSummary($purchaseOrder->details); ?>

			<div class="row">
				<div class="small-12 medium-6 columns">			 

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'purchase_order_no'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'purchase_order_no',array('size'=>30,'maxlength'=>30)); ?>
								<?php echo $form->error($purchaseOrder->header,'purchase_order_no'); ?>
							</div>
						</div>
					</div>

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'purchase_order_date'); ?></label>
							</div>
							<div class="small-8 columns">

								<?php //echo $form->textField($purchaseOrder->header,'purchase_order_date'); ?>
								<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
									'model' => $purchaseOrder->header,
									'attribute' => "purchase_order_date",
			                     // additional javascript options for the date picker plugin
									'options'=>array(
										'dateFormat' => 'yy-mm-dd',
										'changeMonth'=>true,
										'changeYear'=>true,
										'yearRange'=>'1900:2020'
										),
									'htmlOptions'=>array(
										'value'=>date('Y-m-d'),
                       					//'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
										),
									)
								);
								?>
								<?php echo $form->error($purchaseOrder->header,'purchase_order_date'); ?>
							</div>
						</div>
					</div>

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'status_document'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'status_document',array('value'=>$purchaseOrder->header->isNewRecord ? 'Draft' : $purchaseOrder->header->status_document,'readonly'=>true)); ?>
								 <?php //if($purchaseOrder->header->isNewRecord){
								// 	echo $form->textField($purchaseOrder->header,'status_document',array('value'=>'Draft','readonly'=>true));
								// }else{
								// 	echo $form->dropDownList($purchaseOrder->header, 'status_document', array('Draft'=>'Draft','Revised' => 'Revised','Rejected'=>'Rejected','Approved'=>'Approved','Done'=>'Done'),array('prompt'=>'[--Select Status Document--]'));
								// } 
								?>
								<?php echo $form->error($purchaseOrder->header,'status_document'); ?>
							</div>
						</div>
					</div>

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'requester_id'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'requester_id',array('value'=>$purchaseOrder->header->isNewRecord ?Yii::app()->user->getId() : $purchaseOrder->header->requester_id,'readonly'=>true)); ?>
								<?php echo $form->error($purchaseOrder->header,'requester_id'); ?>
							</div>
						</div>
					</div>
					<?php /*
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'main_branch_id'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'main_branch_id'); ?>
								<?php echo $form->error($purchaseOrder->header,'main_branch_id'); ?>
							</div>
						</div>
					</div>
					*/?>

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'main_branch_id'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->dropDownlist($purchaseOrder->header,'main_branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array(
										'prompt'=>'[--Select Branch--]',
											'onchange'=> 'jQuery.ajax({
						                  		type: "POST",
						                  		url: "' . CController::createUrl('ajaxGetCompanyBank') . '",
						                  		data: jQuery("form").serialize(),
						                  		success: function(data){
						                        	console.log(data);
						                        	jQuery("#TransactionPurchaseOrder_company_bank_id").html(data);
						                    	},
						                	});'
								)); ?>
								<?php echo $form->error($purchaseOrder->header,'main_branch_id'); ?>
							</div>
						</div>
					</div>		

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'company_bank_id'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->dropDownlist($purchaseOrder->header,'company_bank_id',array(),array('prompt'=>'[--Select Company Bank--]',
									// 'onchange'=> 'jQuery.ajax({
						   //                		type: "POST",
						   //                		url: "' . CController::createUrl('ajaxGetCoa') . '",
						   //                		data: jQuery("form").serialize(),
						   //                		dataType: "json",
									// 			success: function(data) {
						   //                      	console.log(data);
						   //                      	jQuery("#TransactionPurchaseOrder_coa_id").val(data.coa);
						   //                      	jQuery("#TransactionPurchaseOrder_coa_name").val(data.coa_name);
						   //                  	},
						   //              	});'
						                	)); ?>
								<?php echo $form->error($purchaseOrder->header,'company_bank_id'); ?>
							</div>
						</div>
					</div>		
					<!-- <div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php //echo $form->labelEx($purchaseOrder->header,'coa_id'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php //echo $form->hidden//Field($purchaseOrder->header,'coa_id'); ?>
								<?php //echo $form->textField($purchaseOrder->header,'coa_name',array('readonly'=>true,'value'=>$purchaseOrder->header->coa_id != ""? Coa::model()->findByPk($purchaseOrder->coa_id)->name : '')); ?>
								
								<?php //echo $form->error($purchaseOrder->header,'coa_id'); ?>
							</div>
						</div>
					</div> -->

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'supplier_id'); ?></label>
							</div>
							<div class="small-2 columns">
								<a class="button expand" href="<?php echo Yii::app()->baseUrl.'/master/supplier/create';?>"><span class="fa fa-plus"></span>Add</a>
							</div>
							<div class="small-6 columns">

								<?php echo CHtml::activeHiddenField($purchaseOrder->header,'supplier_id'); ?>
								<?php echo CHtml::activeTextField($purchaseOrder->header,'supplier_name',array(
									'size'=>15,
									'maxlength'=>10,
									'readonly'=>true,
										//'disabled'=>true,
									'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
									'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }',
									'value' =>$purchaseOrder->header->supplier_id == "" ? '': Supplier::model()->findByPk($purchaseOrder->header->supplier_id)->name
									)
								);
								?>

								<?php echo $form->error($purchaseOrder->header,'supplier_id'); ?>
							</div>
						</div>
					</div>

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'estimate_date_arrival'); ?></label>
							</div>
							<div class="small-8 columns">

								<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
									'model' => $purchaseOrder->header,
									'attribute' => "estimate_date_arrival",
									'options'=>array(
										'dateFormat' => 'yy-mm-dd',
										'changeMonth'=>true,
										'changeYear'=>true,
										'yearRange'=>'1900:2020'
										),
									'htmlOptions'=>array(
					                  	//'value'=>date('Y-m-d'),
					                    //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
										),
									)
								);
								?>
								<?php echo $form->error($purchaseOrder->header,'estimate_date_arrival'); ?>
							</div>
						</div>
					</div>

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'payment_type'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php //echo $form->textArea($requestOrder->header,'status_document',array('rows'=>6, 'cols'=>50)); ?>
								<?php echo $form->dropDownList($purchaseOrder->header, 'payment_type', array('Down Payment'=>'Down Payment','Cash'=>'Cash','Direct Bank Transfer'=>'Direct Bank Transfer','Credit' => 'Credit'),array('prompt'=>'[--Select Payment type--]')); ?>
								<?php echo $form->error($purchaseOrder->header,'payment_type'); ?>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'ppn'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php //echo $form->textArea($requestOrder->header,'status_document',array('rows'=>6, 'cols'=>50)); ?>
								<?php echo $form->dropDownList($purchaseOrder->header, 'ppn', array('1'=>'PPN','2' => 'Non PPN')); ?>
								<?php echo $form->error($purchaseOrder->header,'ppn'); ?>
							</div>
						</div>
					</div>

					<div class="field" style="padding-bottom: 10px;">
						<div class="row collapse">
							<div class="small-12 columns">
								<?php echo CHtml::button('Add Details', array(
									'id' => 'detail-button',
									'name' => 'Detail',

									'disabled'=>$purchaseOrder->header->supplier_id==""?true:false,
									'onclick' => '$("#product-dialog").dialog("open"); return false;
									jQuery.ajax({
										type: "POST",
										url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $purchaseOrder->header->id)) . '",
										data: jQuery("form").serialize(),
										success: function(html) {
											jQuery("#detail").html(html);
										},
									});')
								); ?>

								<?php
									Yii::app()->clientScript->registerScript('updateGridView', '
									$.updateGridView = function(gridID, name, value) {
										$("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
										$.fn.yiiGridView.update(gridID, {data: $.param(
											$("#"+gridID+" .filters input, #"+gridID+" .filters select")
											)});
										}
									', CClientScript::POS_READY);
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="small-12 medium-12 columns">	
					<div id="detail">
						<?php $this->renderPartial('_detailPurchaseOrder', array('purchaseOrder'=>$purchaseOrder,
						)); ?>
					</div>
				</div>
	         	
	         	<div class="clearfix"></div>

				<div class="small-12 medium-6 columns">			 
					<div class="field">
						<div class="row collapse">
							<div class="small-12 columns">
								<?php echo CHtml::button('Total', array(
									'id' => 'total-button',
									'name' => 'Detail',
									'onclick' => '
									$.ajax({
										type: "POST",
										url: "' . CController::createUrl('ajaxGetTotal', array('id' => $purchaseOrder->header->id,)) . '",
										data: $("form").serialize(),
										dataType: "json",
										success: function(data) {
											//console.log(data.total);
											console.log(data.requestType);
											$("#TransactionPurchaseOrder_total_price").val(data.total);
											$("#TransactionPurchaseOrder_total_quantity").val(data.totalItems);
											$("#TransactionPurchaseOrder_subtotal").val(data.subtotal);
											$("#TransactionPurchaseOrder_price_before_discount").val(data.priceBeforeDisc);
											$("#TransactionPurchaseOrder_discount").val(data.discount);
											$("#TransactionPurchaseOrder_ppn_price").val(data.ppn);
										},
									});',)
									); 
								?>
							</div>
						</div>
					</div>
					
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'price_before_discount'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'price_before_discount',array('size'=>18,'maxlength'=>18,'readonly'=>'true')); ?>
								<?php echo $form->error($purchaseOrder->header,'price_before_discount'); ?>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'discount'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'discount',array('size'=>18,'maxlength'=>18,'readonly'=>'true')); ?>
								<?php echo $form->error($purchaseOrder->header,'discount'); ?>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'subtotal'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'subtotal',array('size'=>18,'maxlength'=>18,'readonly'=>'true')); ?>
								<?php echo $form->error($purchaseOrder->header,'subtotal'); ?>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'ppn_price'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'ppn_price',array('size'=>18,'maxlength'=>18,'readonly'=>'true')); ?>
								<?php echo $form->error($purchaseOrder->header,'ppn_price'); ?>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'total_price'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php echo $form->textField($purchaseOrder->header,'total_price',array('size'=>18,'maxlength'=>18,'readonly'=>'true')); ?>
								<?php echo $form->error($purchaseOrder->header,'total_price'); ?>
							</div>
						</div>
					</div>		

					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,'total_quantity'); ?></label>
							</div>
							<div class="small-8 columns">

								<?php echo $form->textField($purchaseOrder->header,'total_quantity',array('readonly'=>'true')); ?>
								<?php echo $form->error($purchaseOrder->header,'total_quantity'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="field buttons text-center">
				<?php echo CHtml::submitButton($purchaseOrder->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
			</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'supplier-dialog',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Supplier',
		'autoOpen' => false,
		'width' => 'auto',
		'modal' => true,
		),)
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'supplier-grid',
	'dataProvider'=>$supplierDataProvider,
	'filter'=>$supplier,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
		'cssFile'=>false,
		'header'=>'',
		),
	'selectionChanged'=>'js:function(id){
		$("#TransactionPurchaseOrder_supplier_id").val($.fn.yiiGridView.getSelection(id));
		$("#supplier-dialog").dialog("close");
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "' . CController::createUrl('ajaxSupplier', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
			data: $("form").serialize(),
			success: function(data) {
				$("#TransactionPurchaseOrder_supplier_name").val(data.name);		                        	
				$("#TransactionPurchaseOrder_estimate_date_arrival").val(data.paymentEstimation);		
				$("#detail-button").attr("disabled", false);
				$.updateGridView("product-grid", "Product[product_supplier]", data.name);                        	
			},
		});
		$.ajax({
			type: "POST",
			//dataType: "JSON",
			url: "' . CController::createUrl('ajaxHtmlRemoveDetailSupplier', array('id'=> $purchaseOrder->header->id)).'",
			data: $("form").serialize(),
			success: function(html) {
				$("#detail").html(html);	
			},
		});
	}',
	'columns'=>array('name')
	)
); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'product-dialog',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Product',
		'autoOpen' => false,
		'width' => 'auto',
		'modal' => true,
		),));
?>

<div class="row">
	<div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
	
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'product-grid',
		'dataProvider'=>$productDataProvider,
		'filter'=>$product,
		'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
			'cssFile'=>false,
			'header'=>'',
			),
		'selectionChanged'=>'js:function(id){

			$("#product-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=>$purchaseOrder->header->id,'productId'=>'')). '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					$("#detail").html(data);
				},
			});

			$("#product-grid").find("tr.selected").each(function(){
				$(this).removeClass( "selected" );
			});
		}',
		'columns'=>array(
			'id',
			'name',
			'manufacturer_code',
			array('name'=>'product_master_category_name', 'value'=>'$data->productMasterCategory->name'),
			array('name'=>'product_sub_master_category_name', 'value'=>'$data->productSubMasterCategory->name'),
			array('name'=>'product_sub_category_name', 'value'=>'$data->productSubCategory->name'),
			'production_year',
			array('name'=>'product_brand_name', 'value'=>'$data->brand->name'),
			array('name'=>'product_supplier','value'=>'$data->product_supplier'),
			),
			));?>
	</div>
</div>
<?php $this->endWidget(); ?>

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	// Yii::app()->clientScript->registerScript('myjavascript', '
	// 	$(".numbers").number( true,2, ".", ",");
 //    ', CClientScript::POS_END);
?>