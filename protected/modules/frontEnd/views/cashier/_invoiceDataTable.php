<div style="text-align: right">
    <?php echo ReportHelper::summaryText($invoiceDataProvider); ?>
</div>

<div class="table-responsive" id="invoice-data-grid">
    <table class="table table-sm table-bordered table-hover" id="invoice-data-table">
        <thead>
            <tr class="table-primary">
                <th>Invoice #</th>
                <th>Tanggal</th>
                <th>Registration #</th>
                <th>Plat #</th>
                <th>Customer</th>
                <th>Asuransi</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Sisa</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceDataProvider->data as $invoice): ?>
                <tr data-product-id="<?php echo CHtml::value($invoice, 'id'); ?>">
                    <td><?php echo CHtml::encode(CHtml::value($invoice, 'invoice_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($invoice, 'invoice_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoice, 'registrationTransaction.transaction_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoice, 'vehicle.plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoice, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoice, 'insuranceCompany.name')); ?></td>
                    <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($invoice, 'total_price'))); ?></td>
                    <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($invoice, 'payment_amount'))); ?></td>
                    <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($invoice, 'payment_left'))); ?></td>
                    <td>
                        <?php echo CHtml::link('<i class="bi-currency-dollar"></i>', array("create", "invoiceId" => $invoice->id), array('class' => 'btn btn-primary btn-sm')); ?>
                        <?php echo CHtml::link('<i class="bi-printer"></i>', array("memo", "id" => $invoice->id), array('class' => 'btn btn-success btn-sm')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $invoiceDataProvider->pagination,
        )); ?>
    </div>
</div>

<script>
    var addProductAjaxUrl = "<?php echo CController::createUrl('ajaxHtmlAddProductDetail', array('id' => '__id__', 'productId' => '__productId__')); ?>"
    $(document).ready(function() {
        $('#product-data-table > tbody > tr').on('click', function() {
            $(this).addClass('table-active');
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
        $('#product-data-grid ul.yiiPager > li > a').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "<?php echo CController::createUrl('ajaxHtmlUpdateProductStockTable'); ?>?product_page=" + $(this).attr('href').match(/[?&]product_page=([0-9]+)/)[1],
                data: $("form").serialize(),
                success: function(data) {
                    $("#product_data_container").html(data);
                }
            });
        });
    });
</script>
