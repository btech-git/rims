<div class="large-12 columns">
    <fieldset>
        <legend>Product Price</legend>
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'purchase-grid',
            'dataProvider' => $purchaseOrderDetailDataProvider,
            'filter' => null,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => 'empty($data->purchase_order_id) ? "" : $data->purchase_order_id',
                ),
                array(
                    'header' => 'Supplier',
                    'value' => 'empty($data->purchase_order_id) ? "" : $data->purchaseOrder->supplier->name',
                ),
                array(
                    'header' => 'PO #',
                    'value' => 'empty($data->purchase_order_id) ? "" : CHtml::link($data->purchaseOrder->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id" => $data->purchase_order_id), array("target" => "blank"))',
                    'type'=>'raw',
                ),
                array(
                    'header' => 'Tanggal',
                    'value' => 'empty($data->purchase_order_id) ? "" : $data->purchaseOrder->purchase_order_date',
                ),
                array(
                    'header' => 'Quantity',
                    'value' => 'number_format($data->quantity, 0)',
                    'htmlOptions' => array('style' => 'text-align: center'),
                ),
                array(
                    'header' => 'HPP',
                    'value' => 'number_format($data->unit_price, 2)',
                    'htmlOptions' => array('style' => 'text-align: right'),
                ),
                array(
                    'header' => 'HPP Average',
                    'value' => 'empty($data->product_id) ? "" : number_format($data->product->averageCogs, 2)',
                    'htmlOptions' => array('style' => 'text-align: right'),
                ),
            ),
        )); ?>
    </fieldset>
</div>