<h2>Consignment In</h2>
					
<div class="grid-view">
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
            array('name'=>'consignment_in_number', 'value'=>'CHTml::link($data->consignment_in_number, array("/transaction/ConsignmentInHeader/view", "id"=>$data->id))', 'type'=>'raw'),
            //'consignment_in_number',
            'date_posting',
            'status_document',
            array('header'=>'Receives','value'=> function($data){
            if(count($data->transactionReceiveItems) >0) {
                foreach ($data->transactionReceiveItems as $key => $receive) {
                    echo $receive->receive_item_no. "<br>";

                }
            }


            }
        )),
    )); ?>
</div>