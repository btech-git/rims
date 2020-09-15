<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $purchaseOrder ->header TransactionPurchaseOrder */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Purchase Order',
        Yii::app()->baseUrl . '/transaction/transactionPurchaseOrder/admin', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.admin")
        )) ?>
    <h1><?php if ($purchaseOrder->header->id == "") {
            echo "New Transaction Purchase Order";
        } else {
            echo "Update Transaction Purchase Order";
        } ?></h1>
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-purchase-order-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($purchaseOrder->header); ?>
        <?php echo $form->errorSummary($purchaseOrder->details); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,
                                    'purchase_order_no'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($purchaseOrder->header, 'purchase_order_no',
                                array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php echo $form->error($purchaseOrder->header, 'purchase_order_no'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder->header, 'purchase_order_date'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($purchaseOrder->header, 'purchase_order_date', array('value'=>date('Y-m-d H:i:s'), 'readonly'=>true)); ?>

                            <?php //echo $form->textField($purchaseOrder->header,'purchase_order_date'); ?>
                            <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $purchaseOrder->header,
                                    'attribute' => "purchase_order_date",
                                    // additional javascript options for the date picker plugin
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                        'yearRange' => '1900:2020'
                                    ),
                                    'htmlOptions' => array(
                                        'value' => $purchaseOrder->header->isNewRecord ? date('Y-m-d') : $purchaseOrder->header->purchase_order_date,
                                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                    ),
                                )
                            );*/ ?>
                            <?php echo $form->error($purchaseOrder->header, 'purchase_order_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,
                                    'status_document'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($purchaseOrder->header, 'status_document', array(
                                'value' => $purchaseOrder->header->isNewRecord ? 'Draft' : $purchaseOrder->header->status_document,
                                'readonly' => true
                            )); ?>
                            <?php //if($purchaseOrder->header->isNewRecord){
                            // 	echo $form->textField($purchaseOrder->header,'status_document',array('value'=>'Draft','readonly'=>true));
                            // }else{
                            // 	echo $form->dropDownList($purchaseOrder->header, 'status_document', array('Draft'=>'Draft','Revised' => 'Revised','Rejected'=>'Rejected','Approved'=>'Approved','Done'=>'Done'),array('prompt'=>'[--Select Status Document--]'));
                            // }
                            ?>
                            <?php echo $form->error($purchaseOrder->header, 'status_document'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,
                                    'requester_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($purchaseOrder->header, 'requester_id', array(
                                'value' => $purchaseOrder->header->isNewRecord ? Yii::app()->user->getId() : $purchaseOrder->header->requester_id,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->textField($purchaseOrder->header, 'requester_name', array(
                                'value' => $purchaseOrder->header->isNewRecord ? Yii::app()->user->getName() : $purchaseOrder->header->user->username,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->error($purchaseOrder->header, 'requester_id'); ?>
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
					*/ ?>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($purchaseOrder->header,
                                    'main_branch_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo $form->dropDownlist($purchaseOrder->header,'main_branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array(
                            // 		'prompt'=>'[--Select Branch--]',
                            // 			'onchange'=> 'jQuery.ajax({
                            //                 		type: "POST",
                            //                 		url: "' . CController::createUrl('ajaxGetCompanyBank') . '",
                            //                 		data: jQuery("form").serialize(),
                            //                 		success: function(data){
                            //                       	console.log(data);
                            //                       	jQuery("#TransactionPurchaseOrder_company_bank_id").html(data);
                            //                   	},
                            //               	});'
                            // ));
                            ?>
                            <?php echo $form->hiddenField($purchaseOrder->header, 'main_branch_id', array(
                                'value' => $purchaseOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $purchaseOrder->header->main_branch_id,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->textField($purchaseOrder->header, 'main_branch_name', array(
                                'value' => $purchaseOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $purchaseOrder->header->mainBranch->name,
                                'readonly' => true
                            )); ?>

                            <?php echo $form->error($purchaseOrder->header, 'main_branch_id'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($purchaseOrder->header, 'purchase_type'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($purchaseOrder->header, 'purchase_type', array('empty' => '-- Pilih --',
                                TransactionPurchaseOrder::SPAREPART => TransactionPurchaseOrder::SPAREPART_LITERAL,
                                TransactionPurchaseOrder::TIRE => TransactionPurchaseOrder::TIRE_LITERAL,
                                TransactionPurchaseOrder::GENERAL => TransactionPurchaseOrder::GENERAL_LITERAL,
                            )); ?>
                            <?php echo $form->error($purchaseOrder->header, 'purchase_type'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field" style="padding-bottom: 10px;">
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <?php echo CHtml::hiddenField('DetailIndex', ''); ?>
                            <?php echo CHtml::button('Add Details', array(
                                    'id' => 'detail-button',
                                    'name' => 'Detail',
                                    'disabled' => $purchaseOrder->header->supplier_id == "" ? true : false,
                                    'onclick' => '$("#product-dialog").dialog("open"); return false;
                                        jQuery.ajax({
                                                type: "POST",
                                                url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $purchaseOrder->header->id)) . '",
                                                data: jQuery("form").serialize(),
                                                success: function(html) {
                                                        jQuery("#detail").html(html);
                                                },
                                        });'
                                )
                            ); ?>

                            <?php Yii::app()->clientScript->registerScript('updateGridView', '
                                $.updateGridView = function(gridID, name, value) {
                                    $("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
                                    $.fn.yiiGridView.update(gridID, {data: $.param(
                                        $("#"+gridID+" .filters input, #"+gridID+" .filters select")
                                        )});
                                    }
                                ', CClientScript::POS_READY
                            ); ?>
                        </div>
                    </div>
                </div>

<!--                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php /*echo $form->labelEx($purchaseOrder->header,
                                    'company_bank_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php 
                                $branchId = $purchaseOrder->header->isNewRecord ? User::model()->findByPk(Yii::app()->user->getId())->branch_id : $purchaseOrder->header->main_branch_id;
                                $branch = Branch::model()->findByPk($branchId);
                                $company = Company::model()->findByPk($branch->company_id);
                             ?>
                            <?php echo $form->dropDownlist($purchaseOrder->header, 'company_bank_id', $company == NULL ? array() : CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id'=>$company->id), array('order' => 'account_name')),'id','bank.name'), array(
                                'prompt' => '[--Select Company Bank--]',
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
                            <?php echo $form->error($purchaseOrder->header, 'company_bank_id');*/ ?>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="small-12 medium-6 columns">

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder->header, 'supplier_id'); ?>
                            </label>
                        </div>
                        <?php if ($purchaseOrder->header->isNewRecord): ?>
                        <div class="small-2 columns">
                            <a class="button expand" href="<?php echo Yii::app()->baseUrl . '/master/supplier/create'; ?>">
                                <span class="fa fa-plus"></span>Add
                            </a>
                        </div>
                        <div class="small-6 columns">
                            <?php echo CHtml::activeHiddenField($purchaseOrder->header, 'supplier_id'); ?>
                            <?php echo CHtml::activeTextField($purchaseOrder->header, 'supplier_name', array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                                //'disabled'=>true,
                                'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                                'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }',
                                'value' => $purchaseOrder->header->supplier_id == "" ? '' : Supplier::model()->findByPk($purchaseOrder->header->supplier_id)->name
                            )); ?>

                            <?php echo $form->error($purchaseOrder->header, 'supplier_id'); ?>
                        </div>
                        <?php else: ?>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeHiddenField($purchaseOrder->header, 'supplier_id'); ?>
                            <?php echo CHtml::encode(CHtml::value($purchaseOrder->header, 'supplier.name')); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder->header, 'coa_id'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeHiddenField($purchaseOrder->header, 'coa_supplier', array(
                                'value' => $purchaseOrder->header->supplier_id != "" ? $purchaseOrder->header->supplier->coa_id : '',
                                'readonly' => true
                            )); ?>
                            <?php if ($purchaseOrder->header->supplier_id != ""): ?>
                                <?php echo CHtml::activeTextField($purchaseOrder->header, 'coa_name', array(
                                    'value' => $purchaseOrder->header->supplier->coa != "" ? $purchaseOrder->header->supplier->coa->name : '',
                                    'readonly' => true
                                )); ?>
                            <?php else: ?>
                                <?php echo CHtml::activeTextField($purchaseOrder->header, 'coa_name',
                                    array('readonly' => true)); ?>
                            <?php endif ?>


                            <?php //echo $form->error($purchaseOrder->header,'coa_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder->header, 'estimate_date_arrival'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $purchaseOrder->header,
                                'attribute' => "estimate_date_arrival",
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1900:2020',
                                    'onSelect' => 'js:function(dateText, inst) {
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('AjaxJsonDateChanged', array('id' => $purchaseOrder->header->id)) . '",
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#' . CHtml::activeId($purchaseOrder->header, 'estimate_payment_date') . '").val(data.estimate_payment_date_formatted);
                                                $("#estimate_payment_date").html(data.estimate_payment_date_label);
                                            },
                                        });
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'value' => $purchaseOrder->header->isNewRecord ? date('Y-m-d') : $purchaseOrder->header->estimate_date_arrival,
                                    //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                ),
                            )); ?>
                            <?php echo $form->error($purchaseOrder->header, 'estimate_date_arrival'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder->header, 'TOP'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::openTag('span', array('id' => 'term_of_payment')); ?>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($purchaseOrder->header, 'supplier.tenor'))); ?>
                            <?php echo CHtml::closeTag('span'); ?>
                            hari
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder->header, 'estimate_payment_date'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeHiddenField($purchaseOrder->header, 'estimate_payment_date'); ?>
                            <?php echo CHtml::openTag('span', array('id' => 'estimate_payment_date')); ?>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseOrder->header->estimate_payment_date)); ?>
                            <?php echo CHtml::closeTag('span'); ?>
                            <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $purchaseOrder->header,
                                    'attribute' => "estimate_payment_date",
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                        'yearRange' => '1900:2020'
                                    ),
                                    'htmlOptions' => array(
                                        //'value'=>date('Y-m-d'),
                                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                    ),
                                )
                            );*/ ?>
                            <?php echo $form->error($purchaseOrder->header, 'estimate_payment_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder->header, 'payment_type'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">

                            <div id="payment_text">
                                <?php echo $form->textField($purchaseOrder->header, 'payment_type',
                                    array('readonly' => true, 'value' => 'Cash')); ?>
                            </div>
                            <div id="payment_ddl">
                                <?php echo $form->dropDownList($purchaseOrder->header, 'payment_type',
                                    array('Cash' => 'Cash', 'Credit' => 'Credit'), array(
                                        'prompt' => '[--Select Payment type--]',
                                        'onchange' => 'jQuery.ajax({
						                  		type: "POST",
						                  		url: "' . CController::createUrl('ajaxGetDate', array('type' => '')) . '" + $(this).val(),
						                  		data: jQuery("form").serialize(),
						                  		dataType: "json",
						                  		success: function(data){
						                        	// console.log(data.tanggal);
						                        	// console.log(data.type);
						                        	jQuery("#TransactionPurchaseOrder_estimate_payment_date").val(data.tanggal);
						                    	},
						                	});'
                                    )); ?>
                            </div>

                            <?php echo $form->error($purchaseOrder->header, 'payment_type'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($purchaseOrder->header, 'ppn'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo $form->textArea($requestOrder->header,'status_document',array('rows'=>6, 'cols'=>50)); ?>
                            <?php echo $form->dropDownList($purchaseOrder->header, 'ppn', array('1' => 'PPN', '2' => 'Non PPN'), array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlUpdateAllTax', array('id' => $purchaseOrder->header->id)),
                                    'update' => '#detail',
                                )),
                            )); ?>
                            <?php echo $form->error($purchaseOrder->header, 'ppn'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-12 columns">
                <div id="detail">
                    <?php $this->renderPartial('_detailPurchaseOrder', array(
                        'purchaseOrder' => $purchaseOrder,
                    )); ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="small-12 medium-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <?php /*echo CHtml::button('Total', array(
                                    'id' => 'total-button',
                                    'name' => 'Detail',
                                    'onclick' => '
									$.ajax({
										type: "POST",
										url: "' . CController::createUrl('ajaxGetTotal',
                                            array('id' => $purchaseOrder->header->id,)) . '",
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
											
											$("#view_total_price").val(data.total.toLocaleString(\'id\'));
											$("#view_subtotal").val(data.subtotal.toLocaleString(\'id\'));
											$("#view_price_before_discount").val(data.priceBeforeDisc.toLocaleString(\'id\'));
											$("#view_ppn_price").val(data.ppn.toLocaleString(\'id\'));
										},
									});',
                                )
                            );*/
                            ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <table>
                            <thead>
                                <tr>
                                    <td style="text-align: center; font-weight: bold"><?php echo $form->labelEx($purchaseOrder->header, 'price_before_discount'); ?></td>
                                    <td style="text-align: center; font-weight: bold"><?php echo $form->labelEx($purchaseOrder->header, 'discount'); ?></td>
                                    <td style="text-align: center; font-weight: bold"><?php echo $form->labelEx($purchaseOrder->header, 'subtotal'); ?></td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?php echo CHtml::label('PPN', false); ?>
                                        <?php /*echo CHtml::activeCheckBox($purchaseOrder->header, 'ppn', array('value' => '1', 'uncheckValue'=>'2'), array(
                                            'onchange' => CHtml::ajax(array(
                                                'type' => 'POST',
                                                'url' => CController::createUrl('ajaxHtmlUpdateAllTax', array('id' => $purchaseOrder->header->id)),
                                                'update' => '#detail',
                                            )),
                                        )); ?>
                                        <?php echo CHtml::error($purchaseOrder->header, 'ppn');*/ ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold"><?php echo $form->labelEx($purchaseOrder->header, 'total_price'); ?></td>
                                    <td style="text-align: center; font-weight: bold"><?php echo $form->labelEx($purchaseOrder->header, 'total_quantity'); ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: right">
                                        <span id="sub_total_before_discount">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->subTotalBeforeDiscount)); ?>
                                        </span>
                                        <?php echo $form->error($purchaseOrder->header, 'price_before_discount'); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <span id="sub_total_discount">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->subTotalDiscount)); ?>
                                        </span>
                                        <?php echo $form->error($purchaseOrder->header, 'discount'); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <span id="sub_total">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->subTotal)); ?>
                                        </span>
                                        <?php echo $form->hiddenField($purchaseOrder->header, 'subtotal',
                                            array('size' => 18, 'maxlength' => 18, 'readonly' => 'true')); ?>
                                        <?php echo $form->error($purchaseOrder->header, 'subtotal'); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <span id="tax_value">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->taxAmount)); ?>
                                        </span>
                                        <?php echo $form->hiddenField($purchaseOrder->header, 'ppn_price', array('readonly' => 'true')); ?>
                                        <?php echo $form->error($purchaseOrder->header, 'ppn_price'); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <span id="grand_total">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->grandTotal)); ?>
                                        </span>
                                        <?php echo $form->hiddenField($purchaseOrder->header, 'total_price', array('size' => 18, 'maxlength' => 18, 'readonly' => 'true')); ?>
                                        <?php echo $form->error($purchaseOrder->header, 'total_price'); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <span id="total_quantity">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->totalQuantity)); ?>
                                        </span>
                                        <?php echo $form->error($purchaseOrder->header, 'total_quantity'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
            <?php echo CHtml::submitButton($purchaseOrder->header->isNewRecord ? 'Create' : 'Save',
                array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
<?php if ($purchaseOrder->header->isNewRecord): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'supplier-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Supplier',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'supplier-grid',
            'dataProvider' => $supplierDataProvider,
            'filter' => $supplier,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'selectionChanged' => 'js:function(id){
                $("#TransactionPurchaseOrder_supplier_id").val($.fn.yiiGridView.getSelection(id));
                $("#supplier-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxSupplier', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#TransactionPurchaseOrder_supplier_name").val(data.name);		                        	
                        $("#TransactionPurchaseOrder_coa_supplier").val(data.coa);		                        	
                        $("#TransactionPurchaseOrder_coa_name").val(data.coa_name);		                        	
                        $("#TransactionPurchaseOrder_estimate_date_arrival").val(data.deliveryEstimation);		
                        $("#TransactionPurchaseOrder_estimate_payment_date").val(data.paymentEstimation);
                        $("#estimate_payment_date").html(data.estimate_payment_date_label);
                        $("#term_of_payment").html(data.tenor);		
                        $("#detail-button").attr("disabled", false);
//                        $.fn.yiiGridView.update("product-grid", {data: {Product: {product_supplier: $.fn.yiiGridView.getSelection(id)} } });   
                        if(data.coa == ""){
                            $("#payment_text").show();
                            $("#payment_ddl").hide();
                            $("#payment_ddl select").attr("disabled","disabled");
                        }
                        else{
                            $("#payment_text").hide();
                            $("#payment_ddl").show();
                            $("#payment_ddl select").prop("disabled", false);
                        }
                    },
                });
                $.ajax({
                    type: "POST",
                    //dataType: "JSON",
                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailSupplier',
                            array('id' => $purchaseOrder->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) {
                        $("#detail").html(html);	
                    },
                });
            }',
            'columns' => array(
                'name',
                'email_company',
                array(
                    'header' => 'Phone',
                    'value' => 'empty($data->supplierMobiles) ? "" : $data->supplierMobiles[0]->mobile_no',
                ),
                array(
                    'header' => 'PIC',
                    'value' => 'empty($data->supplierPics) ? "" : $data->supplierPics[0]->name',
                ),
            )
        )
    ); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>
    
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'product-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Product',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <table>
                <thead>
                    <tr>
                        <td>Code</td>
                        <td>Name</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
                        <td>Master Kategori</td>
                        <td>Sub Master Kategori</td>
                        <td>Sub Kategori</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_stock_table',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $(this).val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'name', array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_stock_table',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $(this).val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                    'update' => '#product_sub_brand',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                    brand_id: $(this).val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_brand">
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                        'update' => '#product_sub_brand_series',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <div id="product_sub_brand_series">
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                    'update' => '#product_sub_master_category',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $(this).val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_master_category">
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                        'update' => '#product_sub_category',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <div id="product_sub_category">
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-grid',
                'dataProvider' => $productDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id){
                    $("#product-dialog").dialog("close");
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $purchaseOrder->header->id, 'productId' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#detail").html(data);
                            $.updateGridView("price-grid", "Price[product_name]", data.name); 
                        },
                    });

                    $("#product-grid").find("tr.selected").each(function(){
                        $(this).removeClass( "selected" );
                    });
                }',
                'columns' => array(
                    'name',
                    'manufacturer_code',
                    array(
                        'header' => 'Kategori', 
                        'value' => '$data->masterSubCategoryCode'
                    ),
                    array(
                        'name' => 'unit_id', 
                        'value' => '$data->unit->name'
                    ),
                    array(
                        'header' => 'Brand', 
                        'name' => 'product_brand_name', 
                        'value' => '$data->brand->name'
                    ),
                    array(
                        'header' => 'Sub Brand', 
                        'name' => 'product_sub_brand_name', 
                        'value' => '$data->subBrand->name'
                    ),
                    array(
                        'header' => 'Sub Brand Series', 
                        'name' => 'product_sub_brand_series_name', 
                        'value' => '$data->subBrandSeries->name'
                    ),
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget(); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'product-price-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Price',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    ));
    ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'product-price-grid',
        'dataProvider' => $priceDataProvider,
        'filter' => null,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
                $("#product-price-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxPrice', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                    data: $("form").serialize(),
                    success: function(data) {			
                        var index = $("#DetailIndex").val();
                        $("#TransactionPurchaseOrderDetail_"+index+"_last_buying_price").val(data.price);
                    },
                });

            }',
        'columns' =>
            array(
                array('header' => 'Code', 'value' => '$data->product->manufacturer_code'),
                array('name' => 'product_name', 'value' => '$data->product->name'),
                array('header' => 'Master Category', 'value' => '$data->product->productMasterCategory->name'),
                array('header' => 'Brand', 'value' => '$data->product->brand->name'),
                array('name' => 'supplier_name', 'value' => '$data->supplier->name'),
                array(
                    'name' => 'purchase_price',
                    'value' => 'number_format($data->purchase_price, 2)',
                    'htmlOptions' => array(
                        'style' => 'text-align: right',
                    ),
                ),
                array(
                    'header' => 'Tanggal',
                    'name' => 'purchase_date',
                    'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->purchase_date)'
                ),
            ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js',
        CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScript('myjavascript', '
		//$(".numbers").number(true,2, ".", ",");
		
    ', CClientScript::POS_END);
    ?>
    <script>
        var coa = $("#TransactionPurchaseOrder_coa_supplier").val();
        if (coa == "") {
            $("#payment_text").show();
            $("#payment_ddl").hide();
            $("#payment_ddl select").attr("disabled", "disabled");
        } else {
            $("#payment_text").hide();
            $("#payment_ddl").show();
            $("#payment_ddl select").prop("disabled", false);
        }
    </script>