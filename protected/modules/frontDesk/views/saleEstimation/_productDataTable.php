<div style="text-align: right">
    <?php echo ReportHelper::summaryText($productDataProvider); ?>
</div>

<div class="table-responsive" id="product-data-grid">
    <table class="table table-sm table-bordered table-hover" id="product-data-table">
        <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Sub Brand</th>
                <th>Category</th>
                <?php foreach ($branches as $branch): ?>
                    <th><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
                <th>Total</th>
                <th>Sell Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productDataProvider->data as $product): ?>
                <?php $inventoryTotalQuantities = $product->getInventoryTotalQuantitiesByPeriodic($endDate); ?>
                <?php $totalStock = 0; ?>
                <tr data-product-id="<?php echo CHtml::value($product, 'id'); ?>">
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>

                    <?php foreach ($branches as $branch): ?>
                        <?php $stockValue = 0; ?>
                        <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                            <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                                <?php $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                                <?php break; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <td><?php echo CHtml::encode($stockValue); ?></td>
                        <?php $totalStock += $stockValue; ?>
                    <?php endforeach; ?>

                    <td><?php echo CHtml::encode($totalStock); ?></td>
                    <td class="text-end">
                        <?php $registrationProduct = RegistrationProduct::model()->findByAttributes(array('product_id' => $product->id), array('order' => 't.id DESC')); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationProduct, 'sale_price'))); ?>
                    </td>
                    <td>
                        <span><?php echo CHtml::button('+', array('class' => 'btn btn-sm btn-success')); ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-end" id="product-data-pager">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $productDataProvider->pagination,
    )); ?>
</div>

<script>
    var addProductAjaxUrl = "<?php echo CController::createUrl('ajaxHtmlAddProductDetail', array('id' => '__id__', 'productId' => '__productId__')); ?>"
    $(document).ready(function() {
        $('#product-data-table > tbody > tr').on('click', function() {
            $(this).addClass('table-active');
            $('td > span > input[type=button]', this).addClass('d-none');
            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: addProductAjaxUrl.replace('__id__', '').replace('__productId__', $(this).attr('data-product-id')),
                data: $("form").serialize(),
                success: function(data) {
                    $("#detail-product").html(data);
                }
            });
        });
        $('#product-data-pager ul.yiiPager > li > a').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                dataType: "HTML",
                url: "<?php echo CController::createUrl('ajaxHtmlUpdateProductStockTable'); ?>&product_page=" + $(this).attr('href').match(/[?&]product_page=([0-9]+)/)[1],
                data: $("form").serialize(),
                success: function(data) {
                    $("#product_data_container").html(data);
                }
            });
        });
    });
</script>
