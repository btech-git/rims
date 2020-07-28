<script type="text/javascript">
	

</script>

<table class="items" >
	<thead>
		<tr>
			<th>Product*</th>
			<th>Unit*</th>
			<th>Quantity*</th>
			<th>Notes</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($requestOrder->transferDetails as $i => $transferDetail): ?>

			<tr>
				<td><?php echo CHtml::activeHiddenField($transferDetail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
					
					<?php echo CHtml::activeTextField($transferDetail,"[$i]product_name",
						array(
							'size'=>15,
							'maxlength'=>10,
							'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
			            	'value' => $transferDetail->product_id == "" ? '': Product::model()->findByPk($transferDetail->product_id)->name
						)); ?>

					<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id' => 'product'.$i.'-dialog',
						// additional javascript options for the dialog plugin
						'options' => array(
							'title' => 'Product',
							'autoOpen' => false,
							'width' => 'auto',
							'modal' => true,
						),));
					?>
					
					<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'product'.$i.'-grid',
				'dataProvider'=>$productDataProvider,
				'filter'=>$product,
				// 'summaryText'=>'',
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
				'selectionChanged'=>'js:function(id){
					$("#TransactionRequestTransfer_'.$i.'_product_id").val($.fn.yiiGridView.getSelection(id));
					$("#product'.$i.'-dialog").dialog("close");
					$.ajax({
						type: "POST",
						dataType: "JSON",
						url: "' . CController::createUrl('ajaxProduct', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
						data: $("form").serialize(),
						success: function(data) {
							$("#TransactionRequestTransfer_'.$i.'_product_name").val(data.name);

						},
					});
					$("#product-grid").find("tr.selected").each(function(){
	                   $(this).removeClass( "selected" );
	                });
				}',
				'columns'=>array(
					'id',
					//'code',
					'name',
					'manufacturer_code',
					array('name'=>'product_master_category_name', 'value'=>'$data->productMasterCategory->name'),
					array('name'=>'product_sub_master_category_name', 'value'=>'$data->productSubMasterCategory->name'),
					array('name'=>'product_sub_category_name', 'value'=>'$data->productSubCategory->name'),
					'production_year',
					array('name'=>'product_brand_name', 'value'=>'$data->brand->name'),
					
				),
			));?>
			<?php $this->endWidget(); ?>
			<td><?php echo CHtml::activeDropDownList($transferDetail, "[$i]unit_id", array('1' => 'Pcs',
										'2' => 'Ltr','3'=>'Dozen')); ?></td>
			<td><?php echo CHtml::activeTextField($transferDetail,"[$i]quantity"); ?></td>
			<td><?php echo CHtml::activeTextArea($transferDetail,"[$i]notes"); ?></td>
			<td>
				<?php
			    echo CHtml::button('X', array(
			     	'onclick' => CHtml::ajax(array(
				       	'type' => 'POST',
				       	'url' => CController::createUrl('ajaxHtmlRemoveTransferDetail', array('id' => $requestOrder->header->id, 'index' => $i)),
				       	'update' => '#price',
		      		)),
		     	));
	     	?>
			</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>