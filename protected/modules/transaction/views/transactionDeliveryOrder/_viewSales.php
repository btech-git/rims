<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sales-grid',
    'dataProvider'=>$salesDataProvider,
    'filter'=>$sales,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        //'id',
        //'code',
        array('name'=>'sale_order_no', 'value'=>'CHTml::link($data->sale_order_no, array("/transaction/transactionSalesOrder/view", "id"=>$data->id))', 'type'=>'raw'),
        // 'purchase_order_no',
        'sale_order_date',
        'status_document',
        array('header'=>'Deliveries','value'=> function($data){
            if(count($data->transactionDeliveryOrders) >0) {
                foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                    echo $delivery->delivery_order_no. "<br>";

                }
            }
        }
    )),
)); ?>