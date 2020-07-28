<?php foreach ($requestOrder->details as $i => $detail): ?>
	<table>
		<tr>
			<td>
				Product : <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
				<?php echo CHtml::activeTextField($detail,"[$i]product_name", array(
					'size'=>15,
					'maxlength'=>10,
					'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
					'value' => $detail->product_id == "" ? '': Product::model()->findByPk($detail->product_id)->name
                )); ?>

				<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id' => 'product'.$i.'-dialog',
					'options' => array(
						'title' => 'Product',
						'autoOpen' => false,
						'width' => 'auto',
						'modal' => true,
                    ),
                )); ?>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'product'.$i.'-grid',
					'dataProvider'=>$productDataProvider,
					// 'filter'=>$product,
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
						'cssFile'=>false,
						'header'=>'',
						),
					'selectionChanged'=>'js:function(id){
						$("#TransactionRequestOrderDetail_'.$i.'_product_id").val($.fn.yiiGridView.getSelection(id));
						$("#product'.$i.'-dialog").dialog("close");
						$.ajax({
							type: "POST",
							dataType: "JSON",
							url: "' . CController::createUrl('ajaxProduct', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
							data: $("form").serialize(),
							success: function(data) {
								$("#TransactionRequestOrderDetail_'.$i.'_product_name").val(data.name);
								$("#TransactionRequestOrderDetail_'.$i.'_retail_price").val(data.retail_price);
								$.updateGridView("supplier'.$i.'-grid", "Supplier[product_name]", data.name);
								$.updateGridView("price'.$i.'-grid", "ProductPrice[product_name]", data.name);
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
						array('name'=>'product_sub_brand_name', 'value'=>'$data->subBrand->name'),
						array('name'=>'product_sub_brand_series_name', 'value'=>'$data->subBrandSeries->name'),
						array('name'=>'product_supplier','value'=>'$data->product_supplier'),
						),
					)
				);
				?>

				<?php $this->endWidget(); ?>
			</td>
			<td>
				Supplier:
				<?php echo CHtml::activeHiddenField($detail, "[$i]supplier_id", array('size'=>20,'maxlength'=>20)); ?>
				<?php echo CHtml::activeTextField($detail,"[$i]supplier_name",array(
					'class'=>'required',
					'size'=>15,
					'maxlength'=>10,
					'onclick' => '$("#supplier'.$i.'-dialog").dialog("open"); return false;',
					'value' => $detail->supplier_id == "" ? '': Supplier::model()->findByPk($detail->supplier_id)->name
					)
				); ?>

				<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id' => 'supplier'.$i.'-dialog',
						// additional javascript options for the dialog plugin
					'options' => array(
						'title' => 'Supplier',
						'autoOpen' => false,
						'width' => 'auto',
						'modal' => true,
						),)
				); ?>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'supplier'.$i.'-grid',
					'dataProvider'=>$supplierDataProvider,
					// 'filter'=>$supplier,
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array( 'cssFile'=>false,'header'=>''),
					'selectionChanged'=>'js:function(id){
						$("#TransactionRequestOrderDetail_'.$i.'_supplier_id").val($.fn.yiiGridView.getSelection(id));
						$("#supplier'.$i.'-dialog").dialog("close");
						$.ajax({
							type: "POST",
							dataType: "JSON",
							url: "' . CController::createUrl('ajaxSupplier', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
							data: $("form").serialize(),
							success: function(data) {

								$("#TransactionRequestOrderDetail_'.$i.'_supplier_name").val(data.name);
								$("#TransactionRequestOrderDetail_'.$i.'_estimated_arrival_date").val(data.paymentEstimation);
								$.updateGridView("product'.$i.'-grid", "Product[product_supplier]", data.name);
								$.updateGridView("price'.$i.'-grid", "ProductPrice[supplier_name]", data.name);

							},
						});

					}',
					'columns'=>array(
						'name',
						array('name'=>'product_name','value'=>'$data->product_name'),
						array('name'=>'purchase','value'=>'$data->purchase'),
							// array('name'=>'product_name','value'=>'$data->product->name'),
							// array('name'=>'supplier_name','value'=>'$data->supplier->name'),
							// 'purchase_price',
							//'product',
							//array('name'=>'id','value'=>'$data->id==null?"":$data->id'),
							// array('name'=>'product','value'=>'$data["product_id"]'),

							// array('name'=>'id','value'=>'$data["name"]'),
							// array('name'=>'supplier_id','value'=>'$data->supplier_id==null?"":$data->supplier_id'),
							// array('name'=>'supplier.id','value'=>'$data->supplier==null?"":$data->supplier->id'),
							//array('name'=>'name','value'=>'$data->name==null?"":$data->name'),

							//'name',
							//array('name'=>'purchase','value'=>'empty($data->productPrices->purchase_price)?"":$data->productPrices->purchase_price'),
							//array('name'=>'purchase','value'=>'$data->productPrices->purchase_price'),
							//array('name'=>'Product.product_id','value'=>'$data->product->id'),
							//array('name'=>'ProductPrice.supplier_id','value'=>'$data->productPrices->supplier_id'),
							//array('name'=>'ProductPrice.purchase_price','value'=>'empty($data->productPrices->purchase_price)?null:$data->productPrices->purchase_price'),

						),
					)
				); ?>

				<?php Yii::app()->clientScript->registerScript(
					'updateGridView', '$.updateGridView = function(gridID, name, value) {
						$("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
						$.fn.yiiGridView.update(gridID, {data: $.param(
							$("#"+gridID+" .filters input, #"+gridID+" .filters select")
							)});
						}', CClientScript::POS_READY);
				?>

				<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
			</td>
			<td>
				<?php
					echo CHtml::button('X', array(
						'onclick' => CHtml::ajax(array(
							'type' => 'POST',
							'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $requestOrder->header->id, 'index' => $i)),
							'update' => '#price',
						)),
					));
				?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<?php 
				$this->widget('zii.widgets.jui.CJuiTabs', array(
					'tabs' => array(
						'Detail Item'=>array(
							'id'=>'test',
							'content'=>$this->renderPartial('_detail1',array(
								'i'=>$i,
								'detail'=>$detail,
								'priceDataProvider'=>$priceDataProvider,
								'price'=>$price),TRUE)
						),
						'Detail Approval'=>array(
							'id'=>'test1',
							'content'=>$this->renderPartial('_detailApproval',array(
								'i'=>$i,
								'requestOrder'=>$requestOrder),TRUE)
						),
						'Detail Ordered'=>array(
							'id'=>'test2',
							'content'=>$this->renderPartial('_detailOrder',array(
								'i'=>$i,
								'detail'=>$detail),TRUE)
						),
						'Detail Receive'=>'',
					),
					'options' => array( 'collapsible' => TRUE),
					'id'=>'Request'.$i.'tab',
					)
				);
				?>
			</td>
		</tr>
	</table>
<?php endforeach; ?>