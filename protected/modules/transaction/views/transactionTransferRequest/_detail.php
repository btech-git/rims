
<div class="row">
	<div class="small-12 medium-6 columns">

		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label >Product</label>
				</div>
				<div class="small-7 columns">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
                    <?php echo CHtml::activeTextField($detail,"[$i]product_name", array(
                        'size'=>15,
                        'maxlength'=>10,
                        'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
                        'value' => $detail->product_id == "" ? '': Product::model()->findByPk($detail->product_id)->name
                    )); ?>

                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'product'.$i.'-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Product',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    )); ?>
					<div class="row">
						<div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'product'.$i.'-grid',
                            'dataProvider'=>$productDataProvider,
                            'filter'=>$product,
                            // 'summaryText'=>'',
                                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'selectionChanged'=>'js:function(id){
                                $("#TransactionTransferRequestDetail_'.$i.'_product_id").val($.fn.yiiGridView.getSelection(id));
                                $("#product'.$i.'-dialog").dialog("close");
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxProduct', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#TransactionTransferRequestDetail_'.$i.'_product_name").val(data.name);
                                        $("#TransactionTransferRequestDetail_'.$i.'_unit_price").val(data.hpp);
                                        $("#TransactionTransferRequestDetail_'.$i.'_unit_id").val(data.unit);
                                    },
                                });
                                $("#product'.$i.'-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });
                            }',
                            'columns'=>array(
                                'id',
                                'name',
                                'manufacturer_code',
                                'masterSubCategoryCode',
                                array('name'=>'product_brand_name', 'value'=>'$data->brand->name'),
                                array('name'=>'product_sub_brand_name', 'value'=>'$data->subBrand->name'),
                                array('name'=>'product_sub_brand_series_name', 'value'=>'$data->subBrandSeries->name'),
                                array('name'=>'unit_id', 'value'=>'$data->unit->name'),

                            ),
                        ));?>
					</div>
				</div>
				<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
				</div>
				<div class="small-1 columns">
					<?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $transferRequest->header->id, 'index' => $i)),
                            'update' => '.detail',
                        )),
                    )); ?>
				</div>
			</div>
		</div>
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label >Quantity</label>
				</div>
				<div class="small-8 columns">
					<?php echo CHtml::activeTextField($detail,"[$i]quantity"); ?>
				</div>
			</div>
		</div>
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label >Unit Price(HPP)</label>
				</div>
				<div class="small-8 columns">
					<?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
					<?php echo CHtml::activeTextField($detail, "[$i]unit_price", array(
                        'name' => '',
                        'id' => "detail_{$i}_unit_price_view",
                        'class' => "detail_unit_price_view"
                    )); ?>
				</div>
			</div>
		</div>
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label >Unit</label>
				</div>
				<div class="small-8 columns">
					<?php echo CHtml::activeTextField($detail,"[$i]unit_id"); ?>
				</div>
			</div>
		</div>
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label >Unit Conversion</label>
				</div>
				<div class="small-8 columns">
					<?php echo CHtml::activeTextField($detail,"[$i]amount"); ?>
				</div>
			</div>
		</div>
	</div>
</div>
