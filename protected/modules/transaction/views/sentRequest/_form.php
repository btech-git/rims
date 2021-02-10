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
    <?php echo CHtml::errorSummary($sentRequest->header); ?>
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Transfer Request #', ''); ?>
                <?php echo CHtml::encode(CHtml::value($sentRequest->header, 'sent_request_no')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Tanggal Request', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $sentRequest->header,
                    'attribute' => 'sent_request_date',
                    // additional javascript options for the date picker plugin

                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                )); ?>
                <?php echo CHtml::error($sentRequest->header, 'sent_request_date'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Tanggal Terima', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $sentRequest->header,
                    'attribute' => 'estimate_arrival_date',
                    // additional javascript options for the date picker plugin

                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                )); ?>
                <?php echo CHtml::error($sentRequest->header, 'estimate_arrival_date'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Status Dokumen', ''); ?>
                <?php echo CHtml::encode(CHtml::value($sentRequest->header, 'status_document')); ?>
            </div>
        </div>
        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Requester', ''); ?>
                <?php echo CHtml::encode(CHtml::value($sentRequest->header, 'user.username')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Requester Branch', ''); ?>
                <?php echo CHtml::encode(CHtml::value($sentRequest->header, 'requesterBranch.name')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Cabang Tujuan', false); ?>
                <?php echo CHtml::activeDropDownList($sentRequest->header, 'destination_branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Cabang Tujuan --')); ?>
                <?php echo CHtml::error($sentRequest->header, 'destination_branch_id'); ?>
            </div>            
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('ProductId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('sentRequest' => $sentRequest)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
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
        $.ajax({
            type: "POST",
            url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $sentRequest->header->id)) . '",
            data: $("form").serialize(),
            success: function(html) { $("#detail_div").html(html); },
        });
    }',
    'columns' => array(
        'name',
        'manufacturer_code',
        'productMasterCategory.name: Kategori',
        'productSubMasterCategory.name: Sub Master Kategori',
        'productSubCategory.name: Sub Kategori',
        'production_year',
        'brand.name: Merk',
    ),
));	?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
