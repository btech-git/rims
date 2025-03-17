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

<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">

            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::errorSummary($itemRequest->header); ?>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Request Tanggal', ''); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $itemRequest->header,
                                            'attribute' => "transaction_date",
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
//                                                'value' => date('Y-m-d'),
                                            ),
                                        )); ?>
                                        <?php echo CHtml::error($itemRequest->header, 'transaction_date'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix">
                                            <?php echo CHtml::label('Supplier', ''); ?>
                                        </label>
                                    </div>
                                    <?php //if ($itemRequest->header->isNewRecord): ?>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeTextField($itemRequest->header, 'supplier_id', array(
                                                'readonly' => true,
                                                'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                                                'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }',
                                            )); ?>
                                            <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                                            <?php echo CHtml::encode(CHtml::value($itemRequest->header, 'supplier.name')); ?>
                                            <?php echo CHtml::closeTag('span'); ?>
                                            <?php echo CHtml::error($itemRequest->header, 'supplier_id'); ?>
                                        </div>
                                    <?php /*else: ?>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::encode(CHtml::value($itemRequest->header, 'supplier.name')); ?>
                                        </div>
                                    <?php endif;*/ ?>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Branch'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($itemRequest->header, 'branch.name')); ?>
                                        <?php echo CHtml::error($itemRequest->header,'branch_id'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Note', ''); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($itemRequest->header, 'note', array('rows' => 5, 'columns' => '10')); ?>
                                        <?php echo CHtml::error($itemRequest->header,'note'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <?php echo CHtml::button('Tambah Barang', array(
                        'id' => 'btn_product',
                        'onclick' => '$.ajax({
                            type: "POST",
                            data: $("form").serialize(),
                            url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $itemRequest->header->id)) . '",
                            success: function(html){
                                $("#detail_div").html(html);
                            }
                        })'
                    )); ?>
                </div>

                <br /><br />

                <div id="detail_div">
                    <?php $this->renderPartial('_detail', array(
                        'itemRequest' => $itemRequest,
                    )); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
                <?php echo IdempotentManager::generate(); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div><!-- form -->

<div class="clearfix page-action">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'supplier-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Supplier',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'supplier-grid',
        'dataProvider' => $supplierDataProvider,
        'filter' => $supplier,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
            $("#' . CHtml::activeId($itemRequest->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#supplier-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#supplier_name").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $itemRequest->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#supplier_name").html(data.supplier_name);
                    },
                });
            }
            $.ajax({
                type: "POST",
                //dataType: "JSON",
                url: "' . CController::createUrl('ajaxHtmlRemoveDetailSupplier',
                array('id' => $itemRequest->header->id)) . '",
                data: $("form").serialize(),
                success: function(html) {
                    $("#detail").html(html);	
                },
            });
        }',
        'columns' => array(
            'name',
            'email_company',
            array(
                'header' => 'Phone',
                'value' => 'empty($data->supplierMobiles) ? "" : $data->supplierMobiles[0]->mobile_no',
            ),
            array(
                'header' => 'PIC',
                'value' => 'empty($data->supplierPics) ? "" : $data->supplierPics[0]->name',
            ),
        )
    )); ?>
    <?php $this->endWidget(); ?>
</div>