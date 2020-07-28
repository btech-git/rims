<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'consignment-grid',
    'dataProvider'=>$consignmentDataProvider,
    'filter'=>$consignment,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        //'id',
        //'code',
        array('name'=>'consignment_out_no', 'value'=>'CHTml::link($data->consignment_out_no, array("/transaction/consignmentOutHeader/view", "id"=>$data->id))', 'type'=>'raw'),
        // 'purchase_order_no',
        'date_posting',
        'status',
        array('header'=>'Receives','value'=> function($data){
            if(count($data->transactionDeliveryOrders) >0) {
                foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                    echo $delivery->delivery_order_no. "<br>";
                }
            }
        }
    )),
)); ?>