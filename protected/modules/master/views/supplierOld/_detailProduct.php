<table class="items" id="supplierProductList">
	<thead>
		<tr>
			<th>Manufacturer Code</th>
			<th>Product Name</th>
			<td>Master Category</td>
			<td>Master Sub Category</td>
			<td>Sub Category</td>
			<td>Brand</td>
			<td>Sub Brand</td>
			<td>Sub Brand Series</td>
			<th><a href="#supplierProductList" title="Delete All" class="button expand alert right" id="hapusSemuaProduct" onClick="$('#supplierProductList  > tbody').empty();">Delete All</a></th>
		</tr>
	</thead>
	<tbody >
		<?php foreach ($supplier->productDetails as $i => $productDetail): ?>
			<tr>
				<td><?php echo $productDetail->product->manufacturer_code; ?></td>
				<td>
					<?php echo CHtml::activeHiddenField($productDetail, "[$i]product_id"); ?>
					<?php echo CHtml::activeTextField($productDetail,"[$i]product_name", array(
                        'value' =>$productDetail->product_id == "" ? '': Product::model()->findByPk($productDetail->product_id)->name
                    )); ?>
					<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
				</td>
				<td><?php echo $productDetail->product->product_master_category_id == 0 ? '':$productDetail->product->productMasterCategory->name; ?></td>
				<td><?php echo $productDetail->product->product_sub_master_category_id == 0 ? '':$productDetail->product->productSubMasterCategory->name; ?></td>
				<td><?php echo $productDetail->product->product_sub_category_id == 0 ? '':$productDetail->product->productSubCategory->name; ?></td>
				<td><?php echo $productDetail->product->brand_id == 0 ? '':$productDetail->product->brand->name; ?></td>
				<td><?php echo $productDetail->product->sub_brand_id == 0 ? '':$productDetail->product->subBrand->name; ?></td>
				<td><?php echo $productDetail->product->sub_brand_series_id == 0 ? '':$productDetail->product->subBrandSeries->name; ?></td>
				<td>
					<a href="#supplierProductList" title="Delete <?php echo $productDetail->product_id == "" ? '': Product::model()->findByPk($productDetail->product_id)->name?>" rel="<?php echo $productDetail->product_id?>" class="button expand right" id="hapusProduct" onClick="$(this).closest('tr').remove();">Delete</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>