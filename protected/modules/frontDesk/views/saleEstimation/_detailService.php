<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Service</th>
                <th style="width: 15%">Price</th>
                <th style="width: 10%">Disc Type</th>
                <th style="width: 10%">Discount</th>
                <th style="width: 15%">Total Price</th>
                <th style="width: 5%">Action</th>
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
                                'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $saleEstimation->header->id, 'index'=>$i)),
                                'success' => 'function(data) {
                                    $("#total_amount_' . $i . '").html(data.totalPriceService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($serviceDetail,"[$i]discount_type", array(
                            'Nominal' => 'Nominal',
                            'Percent' => '%'
                        ), array('prompt'=>'[--Select Discount Type--]')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($serviceDetail,"[$i]discount_value", array(
                            'size' => 5,
                            'onchange'=>CHtml::ajax(array(
                                'type'=>'POST',
                                'dataType'=>'JSON',
                                'url'=>CController::createUrl('ajaxJsonTotalService', array('id'=>$saleEstimation->header->id, 'index'=>$i)),
                                'success'=>'function(data) {
                                    $("#total_amount_' . $i . '").html(data.totalPriceService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td class="text-end">
                        <?php echo CHtml::activeHiddenField($serviceDetail,"[$i]total_price",array('readonly'=>true)); ?>
                        <span id="total_amount_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($serviceDetail, 'totalAmount'))); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($saleEstimation->header->isNewRecord): ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-outline-dark",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemoveServiceDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                    'update' => '#detail-product',
                                )),
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-danger",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemoveServiceDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
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
                <td class="text-end fw-bold" colspan="4">Total Jasa</td>
                <td class="text-end fw-bold">
                    <span id="sub_total_service">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header, 'sub_total_service'))); ?>                                                
                    </span>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
