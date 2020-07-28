<table class="items">
	<thead>
		<tr>
			<th>Unit</th>
			<th>Unit Type</th>
			<th>Inventory Unit</th>
			<th></th>
		</tr>
	</thead>
	<tbody >
		<?php foreach ($product->unitDetails as $i => $unitDetail): ?>
			<tr>
				<td>
					<?php echo CHtml::activeHiddenField($unitDetail, "[$i]unit_id"); ?>
					<?php echo CHtml::activeTextField($unitDetail,"[$i]unit_name",
						array(
							'size'=>15,
							'maxlength'=>10,
							//'disabled'=>true,
							'onclick' => '$("#unit'.$i.'-dialog").dialog("open"); return false;',
			            	'onkeypress' => 'if (event.keyCode == 13) { $("#unit'.$i.'-dialog").dialog("open"); return false; }',
			            	'value' =>$unitDetail->unit_id == "" ? '': Unit::model()->findByPk($unitDetail->unit_id)->name
						));
					?>

					<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id' => 'unit'.$i.'-dialog',
						// additional javascript options for the dialog plugin
						'options' => array(
						'title' => 'Unit',
						'autoOpen' => false,
						'width' => 'auto',
						'modal' => true,
					),));
				?>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'unit'.$i.'-grid',
					'dataProvider'=>$unitDataProvider,
					'filter'=>$unit,
					'selectionChanged'=>'js:function(id){
						$("#ProductUnit_'.$i.'_unit_id").val($.fn.yiiGridView.getSelection(id));
						$("#unit'.$i.'-dialog").dialog("close");
						$.ajax({
							type: "POST",
							dataType: "JSON",
							url: "' . CController::createUrl('ajaxUnit', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
							data: $("form").serialize(),
							success: function(data) {
								$("#ProductUnit_'.$i.'_unit_name").val(data.name);
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

				<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($unitDetail, "[$i]unit_type"); ?>
					<?php echo CHtml::activeDropDownList($unitDetail,"[$i]unit_type",array('Main'=>'Main','Service'=>'Service')); ?>
					<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($unitDetail, "[$i]is_inventory"); ?>
					<?php //echo CHtml::activeTextField($unitDetail,"[$i]is_inventory"); ?>
					<?php echo CHtml::activeDropDownList($unitDetail,"[$i]is_inventory",array('No'=>'No','Yes'=>'Yes'), array()); ?>
					<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
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
			