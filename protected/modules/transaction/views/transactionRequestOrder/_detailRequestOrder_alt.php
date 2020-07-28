<?php foreach ($requestOrder->details as $i => $detail): ?>
    <table>
        <tr>
            <td>
                Product : <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::activeTextField($detail, "[$i]product_name", array(
                    'size' => 15,
                    'maxlength' => 10,
                    'rel' => $i,
                    'onclick' => '
                        currentProduct=$(this).attr("rel");
                        // currentProductValue["A"+currentProduct]=$(this).val();
                        // console.log(currentProduct); console.log(currentProductValue);
                        $("#product-dialog").dialog("open"); 
                        return false;
                    ',
                    'value' => $detail->product_id == "" ? '' : Product::model()->findByPk($detail->product_id)->name
                )); ?>
            </td>
            <td>
                <font color="red">Supplier* :</font>
                <div class="row">
                    <div class="medium-10 columns">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]supplier_id",
                            array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]supplier_name", array(
                                'size' => 15,
                                'rel' => $i,
                                'maxlength' => 10,
                                'onclick' => '
                                    currentSupplier=$(this).attr("rel");
                                    // currentSupplierValue["A"+currentSupplier]=$(this).val();
                                    // console.log(currentSupplier); console.log(currentSupplierValue);
                                    $("#supplier-dialog").dialog("open"); return false;
                                ',
                            'value' => $detail->supplier_id == 0 ? '' : Supplier::model()->findByPk($detail->supplier_id)->name
                        )); ?>
                    </div>
                    <div class="medium-2 columns">
                        <?php echo CHtml::link('Add Supplier', array('/master/supplier/create'), array('target' => '_blank', 'class' => 'button')); ?>
                    </div>
                </div>
            </td>
            <td>
                <br/>
                <?php echo CHtml::button('X', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlRemoveDetail',
                            array('id' => $requestOrder->header->id, 'index' => $i)),
                        'update' => '#price',
                    )),
                )); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Code: <span id="code_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, "product.manufacturer_code")); ?></span> ||
                Kategori: <span id="category_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, "product.masterSubCategoryCode")); ?></span> ||
                Brand: <span id="brand_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, "product.brand.name")); ?></span> ||
                Sub Brand: <span id="sub_brand_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, "product.subBrand.name")); ?></span> ||
                Sub Brand Series: <span id="sub_brand_series_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, "product.subBrandSeries.name")); ?></span> ||
                Satuan: <span id="unit_name_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, "product.unit.name")); ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Detail Item' => array(
                            'id' => 'test',
                            'content' => $this->renderPartial('_detail1', array(
                                'i' => $i,
                                'detail' => $detail,
                                'priceDataProvider' => $priceDataProvider,
                                'price' => $price,
                                'requestOrder' => $requestOrder
                            ), true)
                        ),
//                            'Detail Approval' => array(
//                                'id' => 'test1',
//                                'content' => $this->renderPartial('_detailApproval', array(
//                                    'i' => $i,
//                                    'requestOrder' => $requestOrder
//                                ), true)
//                            ),
//                            'Detail Ordered' => array(
//                                'id' => 'test2',
//                                'content' => $this->renderPartial('_detailOrder', array(
//                                    'i' => $i,
//                                    'detail' => $detail
//                                ), true)
//                            ),
//                            'Detail Receive' => '',
                    ),
                    'options' => array('collapsible' => true),
                    'id' => 'Request' . $i . 'tab',
                )); ?>
            </td>
        </tr>
    </table>
    <?php Yii::app()->clientScript->registerScript('myjquery' . $i, '
        var stepbtn' . $i . ' = 0;
        var adanilai' . $i . ' = $("#TransactionRequestOrderDetail_' . $i . '_discount_step option:selected").text();
        console.log(adanilai' . $i . ');
        if (adanilai' . $i . ' == 1) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").hide();
            $("#step3_' . $i . '").hide();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
        }else if (adanilai' . $i . ' == 2) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").hide();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
        }else if (adanilai' . $i . ' == 3) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").show();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
        }else if (adanilai' . $i . ' == 4) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").show();
            $("#step4_' . $i . '").show();
            $("#step5_' . $i . '").hide();
        }else if (adanilai' . $i . ' == 5) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").show();
            $("#step4_' . $i . '").show();
            $("#step5_' . $i . '").show();
        }else{
            $("#step1_' . $i . '").hide();
            $("#step2_' . $i . '").hide();
            $("#step3_' . $i . '").hide();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
        }
    '); ?>
<?php endforeach; ?>