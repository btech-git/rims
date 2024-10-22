<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Service</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleEstimation->serviceDetails as $i => $serviceDetail): ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($serviceDetail, "[$i]service_id"); ?>
                        <?php echo CHtml::activeHiddenField($serviceDetail, "[$i]service_type_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($serviceDetail, 'service.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($serviceDetail, "[$i]price", array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                        $("#total_amount_' . $i . '").html(data.totalAmount);
                                        $("#total_quantity_service").html(data.totalQuantityService);
                                        $("#sub_total_service").html(data.subTotalService);
                                        $("#total_discount_service").html(data.totalDiscountService);
                                        $("#grand_total_service").html(data.grandTotalService);
                                        $("#sub_total_transaction").html(data.subTotalTransaction);
                                        $("#tax_item_amount").html(data.taxItemAmount);
                                        $("#tax_service_amount").html(data.taxServiceAmount);
                                        $("#grand_total_transaction").html(data.grandTotalTransaction);
                                    }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td>
                        <?php if ($saleEstimation->header->isNewRecord): ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-outline-dark",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemoveProductDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                    'update' => '#detail-product',
                                )),
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-danger",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemoveProductDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                    'update' => '#detail-product',
                                )),
                            )); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-end fw-bold">Total Jasa</td>
                <td class="text-end fw-bold"></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
