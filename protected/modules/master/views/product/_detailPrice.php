<table class="items">
	<thead>
		<tr>
			<th>Supplier</th>
			<th>Purchase Price</th>
			<th>Purchase Date</th>
			<th></th>
		</tr>
	</thead>
	<tbody >
		<?php foreach ($product->priceDetails as $i => $priceDetail): ?>
			<tr>
				<td>
					<?php echo CHtml::activeHiddenField($priceDetail, "[$i]supplier_id"); ?>
					<?php echo CHtml::activeTextField($priceDetail,"[$i]supplier_name",
						array(
							'size'=>15,
							'maxlength'=>10,
							//'disabled'=>true,
							//'onclick' => '$("#supplier'.$i.'-dialog").dialog("open"); return false;',
			            	//'onkeypress' => 'if (event.keyCode == 13) { $("#supplier'.$i.'-dialog").dialog("open"); return false; }',
			            	'value' =>$priceDetail->supplier_id == "" ? '': Supplier::model()->findByPk($priceDetail->supplier_id)->name
						));
					?>

					<?php /*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id' => 'supplier'.$i.'-dialog',
						// additional javascript options for the dialog plugin
						'options' => array(
							'title' => 'Supplier',
							'autoOpen' => false,
							'width' => 'auto',
							'modal' => true,
						),));*/
					?>

					<?php /*$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'supplier'.$i.'-grid',
						'dataProvider'=>$supplierDataProvider,
						'filter'=>$supplier,
						'selectionChanged'=>'js:function(id){
							$("#ProductPrice_'.$i.'_supplier_id").val($.fn.yiiGridView.getSelection(id));
							$("#supplier'.$i.'-dialog").dialog("close");
							$.ajax({
								type: "POST",
								dataType: "JSON",
								url: "' . CController::createUrl('ajaxSupplier', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
								data: $("form").serialize(),
								success: function(data) {
									$("#ProductPrice_'.$i.'_supplier_name").val(data.name);		                        	
								},
							});
						}',
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'columns'=>array(
							//'kode',
							'name',
						),
					)); */?>

					<?php //$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

					<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
				</td>
				<td>
					<?php echo CHtml::activeTextField($priceDetail,"[$i]purchase_price"); ?>
				</td>
				<td>
					<?php
				    	echo CHtml::button('X', array(
					     	'onclick' => CHtml::ajax(array(
						       	'type' => 'POST',
						       	'url' => CController::createUrl('ajaxHtmlRemovePriceDetail', array('id' => $product->header->id, 'index' => $i)),
						       	'update' => '#price',
				      		)),
				     	));
			     	?>
				</td>
			</tr>

		<?php endforeach ?>
		
	</tbody>
</table>
			