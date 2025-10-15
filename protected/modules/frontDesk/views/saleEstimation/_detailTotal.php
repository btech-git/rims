<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th style="text-align: right; font-weight: bold" colspan="2">Sub Total</th>
                <th style="text-align: right; font-weight: bold">
                    <span id="sub_total_transaction">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header, 'sub_total'))); ?>                                                
                    </span>
                </th>
            </tr> 
            <tr>
                <th style="text-align: right; font-weight: bold">
                    Ppn
                </th>
                <th style="text-align: right; font-weight: bold; width: 10%">
                    <?php echo CHtml::activeDropDownList($saleEstimation->header, 'tax_product_percentage', array(
                        0 => 'Non PPn',
                        11 => 11,
                    ), array(
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $saleEstimation->header->id)),
                            'success' => 'function(data) {
                                $("#tax_total_transaction").html(data.taxTotalTransaction);
                                $("#grand_total_transaction").html(data.grandTotalTransaction);
                            }',
                        )),
                    )); ?>
                </th>
                <th style="text-align: right; font-weight: bold; width: 20%">
                    <span id="tax_total_transaction">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header,'tax_product_amount'))); ?>                                                
                    </span>
                </th>
            </tr>
            <tr>
                <th style="text-align: right; font-weight: bold" colspan="2">Grand Total</th>
                <th style="text-align: right; font-weight: bold">
                    <span id="grand_total_transaction">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header,'grand_total'))); ?>                                                
                    </span>
                </th>
            </tr>
        </thead>
    </table>
</div>
