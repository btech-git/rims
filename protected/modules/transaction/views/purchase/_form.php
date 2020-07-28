<script type="text/javascript">

    $(document).ready(function () {
        $('.dateClass').live("keyup", function (e) {
            var Length=$(this).attr("maxlength");

            if ($(this).val().length >= parseInt(Length)){
                $(this).next('.dateClass').focus();
            }
        });
    }

</script>


<div class="form">

    <?php echo CHtml::beginForm(); ?>
                <?php echo CHtml::errorSummary($purchase->header); ?>
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php echo $form->textField($purchase->header, 'purchase_order_date', array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $purchase->header,
                    'attribute' => 'purchase_order_date',
                    // additional javascript options for the date picker plugin

                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                ));*/ ?>
                <?php echo CHtml::error($purchase->header, 'purchase_order_date'); ?>
       
            </div>
            <div class="row">
                <?php echo CHtml::label('Estimate Date Arrival', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $purchase->header,
                    'attribute' => 'estimate_date_arrival',
                    // additional javascript options for the date picker plugin

                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                )); ?>
                <?php echo CHtml::error($purchase->header, 'estimate_date_arrival'); ?>
       
            </div>
            <div class="row">
                <?php echo CHtml::label('Estimate Payment Date', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $purchase->header,
                    'attribute' => 'estimate_payment_date',
                    // additional javascript options for the date picker plugin

                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                )); ?>
                <?php echo CHtml::error($purchase->header, 'estimate_payment_date'); ?>
       
            </div>

            <div class="row">
                <?php echo CHtml::label('Supplier', ''); ?>
                <?php echo CHtml::activeTextField($purchase->header, 'supplier_id', array(
                    'readonly' => true,
                    'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::error($purchase->header, 'supplier_id'); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'supplier-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Supplier',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                ));	?>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'supplier-grid',
                    'dataProvider' => $supplierDataProvider,
                    'filter' => $supplier,
                    'selectionChanged' => 'js:function(id) {
                        $("#' . CHtml::activeId($purchase->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#supplier-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "")
                        {
                            $("#supplier_name").html("");
                            $("#supplier_company").html("");

                        }
                        else
                        {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $purchase->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#supplier_name").html(data.supplier_name);
                                    $("#supplier_company").html(data.supplier_company);
                                },
                            });
                        }
                    }',
                    'columns' => array(
                        'company',
                        'name',
                    ),
                ));	?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                <?php //endif; ?>
                <?php echo CHtml::error($purchase->header, 'supplier_id'); ?>
                <?php $purchaseSupplier = $purchase->header->supplier(array('scopes' => 'resetScope')); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseSupplier, 'company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
        </div>

        <div class="row">
            <?php echo CHtml::label('PPN / non-PPN', false); ?>
            <?php echo CHtml::activeDropDownList($purchase->header, 'ppn', array(
                '1' => 'Tax',
                '0' => 'Non-tax'), array('empty' => '-- PPN/Non-PPN --',
//                'onchange' => CHtml::ajax(array(
//                    'type' => 'POST',
//                    'dataType' => 'JSON',
//                    'url' => CController::createUrl('ajaxJsonTaxTotal', array('id' => $purchase->header->id)), //index is any number
//                    'success' => 'function(data) {
//                        $("#taxPercentage").html(data.taxPercentage);
//                        $("#taxValue").html(data.taxValue);
//                        $("#grand_total").html(data.grandTotal);
//                        $("#downPaymentValue").html(data.$downPaymentValue);
//                    }',
//                )) . 'hideShowTotalAndPpn();',
            )); ?>
            <?php echo CHtml::error($purchase->header, 'ppn'); ?>
        </div>


        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Status Dokumen', ''); ?>
                <?php echo CHtml::activeTextField($purchase->header, 'status_document'); ?>
                <?php echo CHtml::error($purchase->header, 'status_document'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Requester', ''); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'user.username')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Main Branch', ''); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'mainBranch.name')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Company Bank', false); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAll(), 'id', 'bank.name'), array('empty' => '-- Pilih Bank --')); ?>
                <?php echo CHtml::error($purchase->header, 'company_bank_id'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('COA', ''); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'supplier.coa.name')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Payment Type', ''); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'payment_type')); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('ProductId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('purchase' => $purchase)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Product',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
));	?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-grid',
    'dataProvider' => $productDataProvider,
    'filter' => $product,
    'selectionChanged' => 'js:function(id) {
        $("#ProductId").val($.fn.yiiGridView.getSelection(id));
        $("#product-dialog").dialog("close");
        if ($.fn.yiiGridView.getSelection(id) == "")
        {
            $("#product_name").html("");
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $purchase->header->id)) . '",
                data: $("form").serialize(),
                success: function(data) {
                    $("#detail_div").html(data);
                },
            });
        }
    }',
    'columns' => array(
        'name',
    ),
));	?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
