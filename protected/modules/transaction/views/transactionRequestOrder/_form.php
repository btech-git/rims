<?php
/* @var $this TransactionRequestOrderController */
/* @var $requestOrder ->header TransactionRequestOrder */
/* @var $form CActiveForm */

/*<script>
		function numberWithCommas(x) {
		    return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
		}
		$( document ).ready(function() {
				$(".numbers").each(function(){
					//alert($(this).val());
					var v_pound = $(this).val();
				    v_pound = numberWithCommas(v_pound);
				    // $(this).val(Number(v_pound).toLocaleString('en'));
				    // console.log($(this).val().toLocaleString("en"));
				    $(this).val(v_pound);
				    //console.log($(this).val(v_pound));
				});

			   
			});
		function removeCommas(x){
			return x.toString().replace(",","");
		}
		function noCommas(){
			$(".numbers").each(function(){
					
					var v_pound = $(this).val();
				    v_pound = removeCommas(v_pound);
				    
				    $(this).val(v_pound);
				    //console.log($(this).val(v_pound));
				});
		}
	</script>
	*/ ?>
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Purchase Request',
            Yii::app()->baseUrl . '/transaction/transactionRequestOrder/admin', array(
                'class' => 'button cbutton right',
                'visible' => Yii::app()->user->checkAccess("transaction.transactionRequestOrder.admin")
            )) ?>
        <h1><?php if ($requestOrder->header->id == "") {
                echo "New Request Order";
            } else {
                echo "Update Request Order";
            } ?></h1>
        <!-- begin FORM -->
        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'transaction-request-order-form',
                'enableAjaxValidation' => false,
            )); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($requestOrder->header); ?>

            <div class="row">
                <div class="small-12 medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($requestOrder->header, 'request_order_no',
                                    array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($requestOrder->header, 'request_order_no')); ?>
                                <?php //echo $form->textField($requestOrder->header, 'request_order_no', array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                                <?php //echo $form->error($requestOrder->header, 'request_order_no'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($requestOrder->header, 'request_order_date',
                                    array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($requestOrder->header, 'request_order_date', array('value'=>date('Y-m-d'), 'readonly'=>true)); ?>
                                <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $requestOrder->header,
                                    'attribute' => "request_order_date",
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                        'yearRange' => '1900:2020'
                                    ),
                                    'htmlOptions' => array(
                                        'value' => $requestOrder->header->isNewRecord ? date('Y-m-d') : $requestOrder->header->request_order_date,
                                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                    ),
                                ));*/ ?>
                                <?php echo $form->error($requestOrder->header, 'request_order_date'); ?>
                            </div>
                        </div>
                    </div>

                    <?php /*<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label class="prefix"><?php //echo $form->labelEx($requestOrder->header,'request_type'); ?></label>
							</div>
							<div class="small-8 columns">
								<?php //echo $form->dropDownlist($requestOrder->header,'request_type',array('Request for Purchase'=>'Request for Purchase','Request for Transfer'=>'Request for Transfer','Request for Sales'=>'Request for Sales'),array('prompt'=>'[--Select Request Type--]')); ?>
								<?php //echo $form->error($requestOrder->header,'request_type'); ?>
							</div>
						</div>
					</div> */ ?>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($requestOrder->header, 'requester_id',
                                    array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($requestOrder->header, 'requester_id', array(
                                    'value' => $requestOrder->header->isNewRecord ? Yii::app()->user->getId() : $requestOrder->header->requester_id,
                                    'readonly' => true
                                )); ?>
                                <?php echo $form->textField($requestOrder->header, 'requester_name', array(
                                    'value' => $requestOrder->header->isNewRecord ? Yii::app()->user->getName() : $requestOrder->header->user->username,
                                    'readonly' => true
                                )); ?>
                                <?php //echo $form->textField($requestOrder->header,'requester_name',array('value'=>Yii::app()->user->name,'readonly'=>true)); ?>
                                <?php echo $form->error($requestOrder->header, 'requester_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">
                                    <?php echo $form->labelEx($requestOrder->header, 'requester_branch_id'); ?>
                                </label>
                            </div>
                            <div class="small-8 columns">
                                <?php /*echo $form->hiddenField($requestOrder->header, 'requester_branch_id', array(
//                                    'value' => $requestOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $requestOrder->header->requester_branch_id,
                                    'readonly' => true
                                ));*/ ?>
                                <?php echo $form->textField($requestOrder->header, 'requester_branch_name', array(
                                    'value' => $requestOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $requestOrder->header->requesterBranch->name,
                                    'readonly' => true
                                )); ?>
                                <?php //echo $form->dropDownlist($requestOrder->header,'requester_branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array('prompt'=>'[--Select Branch--]')); ?>
                                <?php echo $form->error($requestOrder->header, 'requester_branch_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">
                                    <?php echo $form->labelEx($requestOrder->header, 'main_branch_id'); ?>
                                </label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->dropDownlist($requestOrder->header, 'main_branch_id',
                                    CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'),
                                    array('prompt' => '[--Select Branch--]')); ?>
                                <?php echo $form->error($requestOrder->header, 'main_branch_id'); ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    /*<div class="field">
                       <div class="row collapse">
                           <div class="small-4 columns">
                               <label class="prefix"><?php //echo $form->labelEx($requestOrder->header,'main_branch_approved_by'); ?></label>
                           </div>
                           <div class="small-8 columns">
                               <?php //echo $form->textField($requestOrder->header,'main_branch_approved_by'); ?>
                               <?php //echo $form->error($requestOrder->header,'main_branch_approved_by'); ?>
                           </div>
                       </div>
                       </div>
                       <div class="field">
                           <div class="row collapse">
                               <div class="small-4 columns">
                                   <label class="prefix"><?php //echo $form->labelEx($requestOrder->header,'payment_estimation_date'); ?></label>
                               </div>
                               <div class="small-8 columns">
                                   <?php //echo $form->textField($requestOrder->header,'payment_estimation_date'); ?>
                                   <?php //echo $form->error($requestOrder->header,'payment_estimation_date'); ?>
                               </div>
                           </div>
                       </div>	 */
                    ?>

                    <div class="field" style="margin-bottom: 10px;">
                        <div class="row collapse">
                            <div class="small-12 columns">
                                <?php echo CHtml::button('Add Details', array(
                                    'id' => 'detail-button',
                                    'name' => 'Detail',
                                    'onclick' => 'jQuery.ajax({
										type: "POST",
										url: "' . CController::createUrl('ajaxHtmlAddDetail',
                                            array('id' => $requestOrder->header->id)) . '",
										data: jQuery("form").serialize(),
										success: function(html) {
											$.fn.yiiGridView.update("supplier-grid", {
											    data: {"Supplier[product_name]": ""}
											});

											$.fn.yiiGridView.update("product-grid", {
								                data: {"Product[product_supplier]": ""}
								            });

											jQuery("#price").html(html);
										},
									});',
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($requestOrder->header, 'status_document',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($requestOrder->header, 'status_document', array(
                                'value' => $requestOrder->header->isNewRecord ? 'Draft' : $requestOrder->header->status_document,
                                'readonly' => true
                            )); ?>
                            <?php
                            // if($requestOrder->header->isNewRecord) {
                            // 	echo $form->textField($requestOrder->header,'status_document',array('value'=>'Draft','readonly'=>true));
                            // }else{
                            // 	echo $form->dropDownList($requestOrder->header, 'status_document', array('Draft'=>'Draft','Revised' => 'Revised','Rejected'=>'Rejected','Approved'=>'Approved','Done'=>'Done'),array('prompt'=>'[--Select Status Document--]'));
                            // }
                            ?>
                            <?php echo $form->error($requestOrder->header, 'status_document'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($requestOrder->header, 'notes'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($requestOrder->header, 'notes', array('rows' => 6, 'cols' => 50)); ?>
                            <?php echo $form->error($requestOrder->header, 'notes'); ?>
                        </div>
                    </div>
                </div>

                
            </div>

                <div class="small-12 medium-12 columns">
                    <div id="price">
                        <?php //if($requestOrder->header->request_type == 'Request for Purchase'){ ?>
                        <?php //$this->renderPartial('_detailRequestOrder', array('requestOrder'=>$requestOrder,'supplier'=>$supplier,'supplierDataProvider'=>$supplierDataProvider,'product'=>$product,
                        // 	'productDataProvider'=>$productDataProvider,'price'=>$price,
                        // 'priceDataProvider'=>$priceDataProvider,
                        // 		)); ?>
                        <?php //}else if($requestOrder->header->request_type == 'Request for Transfer') { ?>
                        <?php //$this->renderPartial('_detailRequestTransfer', array('requestOrder'=>$requestOrder,'product'=>$product,
                        //'productDataProvider'=>$productDataProvider
                        //)); ?>
                        <?php //}else{
                        //echo "Please Select Request type.";
                        //} ?>
                        <?php $this->renderPartial('_detailRequestOrder_alt', array(
                            'requestOrder' => $requestOrder,
                            'supplier' => $supplier,
                            // 'supplierDataProvider'=>$supplierDataProvider,
                            'product' => $product,
                            // 'productDataProvider'=>$productDataProvider,
                            'price' => $price,
                            'priceDataProvider' => $priceDataProvider,
                        )); ?>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="small-12 medium-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <label class="prefix">
                                    <?php echo $form->labelEx($requestOrder->header, 'total_price'); ?>
                                </label>
                            </div>
                            <div class="small-4 columns">
                                <span id="sub_total">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $requestOrder->subTotal)); ?>
                                </span>
                                <?php echo $form->hiddenField($requestOrder->header, 'total_price', array('readonly' => true)); ?>
                                <?php echo $form->error($requestOrder->header, 'total_price'); ?>
                            </div>
                            <div class="small-2 columns">
                                <label class="prefix"><?php echo $form->labelEx($requestOrder->header, 'total_items',
                                        array('readonly' => true)); ?></label>
                            </div>
                            <div class="small-4 columns">
                                <span id="total_quantity">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $requestOrder->totalQuantity)); ?>
                                </span>
                                <?php echo $form->error($requestOrder->header, 'total_items'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr />
            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($requestOrder->header->isNewRecord ? 'Create' : 'Save',
                    array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div>
    </div>
    <script type="text/javascript">
        var myArray = new Array();

        var currentProduct = 0;
        var currentSupplier = 0;
        var currentPrice = 0;
    </script>


<?php
/*$productCriteria = new CDbCriteria;
$productCriteria->compare('t.name',$product->name,true);
$productCriteria->compare('t.manufacturer_code',$product->manufacturer_code,true);
// $productCriteria->together=true;
$productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
$productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
$productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
$productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
$productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
$productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
$productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
// $productCriteria->unsetAttributes();  // clear any default values
$productDataProvider = new CActiveDataProvider('Product', array(
    'criteria'=>$productCriteria,));


$supplierCriteria = new CDbCriteria;
$supplierCriteria->compare('name',$supplier->name,true);

$supplierCriteria->select = 't.*,rims_supplier_product.supplier_id, rims_product.name as product_name';
$supplierCriteria->join = 'LEFT OUTER JOIN `rims_supplier_product`ON t.id = rims_supplier_product.supplier_id LEFT OUTER JOIN `rims_product`ON rims_supplier_product.product_id = rims_product.id ';

$supplierCriteria->compare('rims_product.name ',$supplier->product_name,true);

//$supplierCriteria->compare('product',$supplier->product,true);
$supplierDataProvider = new CActiveDataProvider('Supplier', array(
    'criteria'=>$supplierCriteria,
    ));*/
?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'product-dialog',
        'options' => array(
            'title' => 'Product',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
            'open' => 'js:function(event, ui) { 
			var inih1 = myArray["P"+currentProduct];
			if (myArray["P"+currentProduct] == undefined || myArray["P"+currentProduct] == null)  {
				// console.log("empty");
				$.fn.yiiGridView.update("supplier-grid", {
				    data: {"Supplier[product_name]": ""}
				});
			}else{
				// console.log("dialog opened 1" + inih1);
				$.fn.yiiGridView.update("supplier-grid", {
				    data: {"Supplier[product_name]": inih1}
				});
			}
			/*
			var inih2 = myArray["S"+currentSupplier];
			if (myArray["S"+currentSupplier] == undefined || myArray["S"+currentSupplier] == null)  {
				// console.log("empty");
				$.fn.yiiGridView.update("product-grid", {
	                data: {"Product[product_supplier]": ""}
	            });
	        }else{
				// console.log("dialog opened 1" + inih2);
				$.fn.yiiGridView.update("product-grid", {
	                data: {"Product[product_supplier]": inih2}
	            });
			}*/			
		}'
        )
    )
);
?>

    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
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
                            <?php echo CHtml::activeTextField($product, 'id', array(
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
                                    id: $(this).val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
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
                                    id: $("#Product_id").val(),
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
                                    id: $("#Product_id").val(),
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
                                    id: $("#Product_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_brand">
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
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
                                    id: $("#Product_id").val(),
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
            <!-- for product selected popup ==>   javascript:window.open("' . CController::createUrl('showProduct', array()) . '/productId/"+data.id+"/branchId/"+ branch,"x","height=600,width=600,left=100"); return false;-->
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-grid',
                'dataProvider' => $productDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                // 'afterAjaxUpdate'=>'function(id, data){

                //    }',
                'selectionChanged' => 'js:function(id){
                    var nilai = $.fn.yiiGridView.getSelection(id);

                    $("#TransactionRequestOrderDetail_"+currentProduct+"_product_id").val(nilai);
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl("ajaxProduct") . '/id/"+nilai,
                        data: $("form").serialize(),
                        success: function(data) {
                            var branch = $("#TransactionRequestOrder_requester_branch_id").val();
                            if(branch != ""){
                                $("#TransactionRequestOrderDetail_"+currentProduct+"_product_name").val(data.name);
                                $("#TransactionRequestOrderDetail_"+currentProduct+"_retail_price").val(data.retail_price);
                                $("#TransactionRequestOrderDetail_"+currentProduct+"_unit_id").val(data.unit);
                                $("#unit_name_"+currentProduct+"").html(data.unit_name);
                                $("#code_"+currentProduct+"").html(data.code);
                                $("#category_"+currentProduct+"").html(data.category);
                                $("#brand_"+currentProduct+"").html(data.brand);
                                $("#sub_brand_"+currentProduct+"").html(data.sub_brand);
                                $("#sub_brand_series_"+currentProduct+"").html(data.sub_brand_series);

                                myArray["P"+currentProduct] = data.name;

                                $.fn.yiiGridView.update("supplier-grid", {
                                    data: {"Supplier[product_name]": myArray["P"+currentProduct]}
                                });

                            }
                            else{
                                alert("Please Select Branch First");
                            }
                        },
                    });
                    $("#product-dialog").dialog("close");

                    $("#product-grid").find("tr.selected").each(function(){
                        $(this).removeClass( "selected" );
                    });
                }',
                'columns' => array(
                    'id',
                    'name',
                    'manufacturer_code',
                    array(
                        'name'=>'product_brand_name', 
                        'value'=>'empty($data->brand_id) ? "" : $data->brand->name'
                    ),
                    array(
                        'header' => 'Sub Brand', 
                        'name' => 'product_sub_brand_name', 
                        'value' => 'empty($data->sub_brand_id) ? "" : $data->subBrand->name'
                    ),
                    array(
                        'header' => 'Sub Brand Series', 
                        'name' => 'product_sub_brand_series_name', 
                        'value' => 'empty($data->sub_brand_series_id) ? "" : $data->subBrandSeries->name'
                    ),
                    'masterSubCategoryCode: Kategori',
                    array(
                        'name'=>'unit_id', 
                        'value'=>'empty($data->unit_id) ? "" : $data->unit->name'
                    ),
                    array(
                        'name' => 'product_supplier', 
                        'value' => '$data->product_supplier'
                    ),
                ),
            )); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'supplier-dialog',
        'options' => array(
            'title' => 'Supplier',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
            'open' => 'js:function(event, ui) {
			/*var inih1 = myArray["P"+currentProduct];
			if (myArray["P"+currentProduct] == undefined || myArray["P"+currentProduct] == null)  {
				// console.log("empty");
				$.fn.yiiGridView.update("supplier-grid", {
				    data: {"Supplier[product_name]": ""}
				});
			}else{
				// console.log("dialog opened 1" + inih1);
				$.fn.yiiGridView.update("supplier-grid", {
				    data: {"Supplier[product_name]": inih1}
				});
			}*/

			var inih2 = myArray["S"+currentSupplier];
			if (myArray["S"+currentSupplier] == undefined || myArray["S"+currentSupplier] == null)  {
				// console.log("empty");
				$.fn.yiiGridView.update("product-grid", {
	                data: {"Product[product_supplier]": ""}
	            });
	        }else{
				// console.log("dialog opened 2" + inih2);
				$.fn.yiiGridView.update("product-grid", {
	                data: {"Product[product_supplier]": inih2}
	            });
			}
		}'

        ),
    )
); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'supplier-grid',
        'dataProvider' => $supplierDataProvider,
        'filter' => $supplier,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array('cssFile' => false, 'header' => ''),
        'selectionChanged' => 'js:function(id){
		var nilai = $.fn.yiiGridView.getSelection(id);
		$("#TransactionRequestOrderDetail_"+currentSupplier+"_supplier_id").val(nilai);
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "' . CController::createUrl("ajaxSupplier") . '/id/"+nilai,
			data: $("form").serialize(),
			success: function(data) {
				$("#TransactionRequestOrderDetail_"+currentSupplier+"_supplier_name").val(data.name);
				$("#TransactionRequestOrderDetail_"+currentSupplier+"_estimated_arrival_date").val(data.paymentEstimation);

				myArray["S"+currentSupplier] = data.name;

				$.fn.yiiGridView.update("product-grid", {
	                data: {"Product[product_supplier]": myArray["S"+currentSupplier]}
	            });

			},
		});
		$("#supplier-dialog").dialog("close");
	}',
        'columns' => array(
            'name',
            'company',
            array('name' => 'product_name', 'value' => '$data->product_name'),
            // array('name'=>'purchase','value'=>'$data->purchase'),
        ),
    )
); ?>
    <div class="text-right">
        <?php
        if ($supplierDataProvider->getItemCount()) {
            echo CHtml::link('Add Supplier', array('/master/supplier/create'),
                array('target' => '_blank', 'class' => 'button'));
        }
        ?>
    </div>
<?php /*Yii::app()->clientScript->registerScript(
	'updateGridView', '$.updateGridView = function(gridID, name, value) {
		$("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
		$.fn.yiiGridView.update(gridID, {data: $.param(
			$("#"+gridID+" .filters input, #"+gridID+" .filters select")
			)});
		}', CClientScript::POS_READY);
*/ ?>

<?php $this->endWidget(); ?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'price-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Price',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
));
?>

<?php
/*$coumns = array(
array('name'=>'product_name','value'=>'$data->product->name'),
// array('name'=>'supplier_name','value'=>'$data->supplier->name'),
// 'purchase_price'
);

$lsitSupplier = Supplier::model()->findAll();
foreach ($lsitSupplier as $key => $value) {
    array_push($coumns, array('header'=>$value->name, 'value'=>'$data->getLasProductPrice($data->product_id,"'.$value->id.'")'));
}*/

?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'price-grid',
    'dataProvider' => $price->search(),
    'filter' => $price,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
			$("#price-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxPrice', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {			
					$("#TransactionRequestOrderDetail_"+currentPrice+"_last_buying_price").val(data.price);
				},
			});
			
		}',
    'columns' =>
    //$coumns
        array(
            array('name' => 'product_name', 'value' => '$data->product->name'),
            array('name' => 'supplier_name', 'value' => '$data->supplier->name'),
            'purchase_price',
            array('header' => 'Purchase Date', 'value' => '$data->purchase_date'),
            //array('name'=>'purchase','value'=>'empty($data->productPrices->purchase_price)?"":$data->productPrices->purchase_price'),
            //array('name'=>'purchase','value'=>'$data->productPrices->purchase_price'),
            //array('name'=>'Product.product_id','value'=>'$data->product->id'),
            //array('name'=>'ProductPrice.supplier_id','value'=>'$data->productPrices->supplier_id'),
            //array('name'=>'ProductPrice.purchase_price','value'=>'empty($data->productPrices->purchase_price)?null:$data->productPrices->purchase_price'),
        ),
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js',
    CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
		//$(".numbers").number(true, 2, ",", ".");
    ', CClientScript::POS_END);
?>