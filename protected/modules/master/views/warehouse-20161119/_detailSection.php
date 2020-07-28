<table class="items">
	<thead>
		<tr>
			<th>Code</th>
			<th>Product</th>
			<th>Rack Number</th>
			<th></th>
		</tr>
	</thead>
	<tbody >
		<?php foreach ($warehouse->sectionDetails as $i => $sectionDetail): ?>
			<tr>
				<td>
					<?php echo CHtml::activeTextField($sectionDetail, "[$i]code"); ?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($sectionDetail, "[$i]product_id"); ?>
					<?php echo CHtml::activeTextField($sectionDetail,"[$i]product_name",
						array(
							'size'=>15,
							'maxlength'=>10,
							//'disabled'=>true,
							'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
			            	'onkeypress' => 'if (event.keyCode == 13) { $("#product'.$i.'-dialog").dialog("open"); return false; }',
			            	'value' =>$sectionDetail->product_id == "" ? '': Product::model()->findByPk($sectionDetail->product_id)->name
						));
					?>

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
						'selectionChanged'=>'js:function(id){
							$("#WarehouseSection_'.$i.'_product_id").val($.fn.yiiGridView.getSelection(id));
							$("#product'.$i.'-dialog").dialog("close");
							$.ajax({
								type: "POST",
								dataType: "JSON",
								url: "' . CController::createUrl('ajaxProduct', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
								data: $("form").serialize(),
								success: function(data) {
									$("#WarehouseSection_'.$i.'_product_name").val(data.name);
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
					)); ?>

					<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
				</td>
				<td>
					<?php echo CHtml::activeTextField($sectionDetail, "[$i]rack_number"); ?>
				</td>
				<td>
					<?php
				    	echo CHtml::button('X', array(
					     	'onclick' => CHtml::ajax(array(
						       	'type' => 'POST',
						       	'url' => CController::createUrl('ajaxHtmlRemoveSectionDetail', array('id' => $warehouse->header->id, 'index' => $i)),
						       	'update' => '#section',
				      		)),
				     	));
			     	?>
				</td>
			</tr>
		<?php endforeach ?>
		
	</tbody>
</table>
			