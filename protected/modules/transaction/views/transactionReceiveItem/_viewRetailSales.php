<h2>Retail Sales</h2>
					
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'movement-grid',
        'dataProvider'=>$movementDataProvider,
        'filter'=>$movement,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
            'cssFile'=>false,
            'header'=>'',
            ),
        //'summaryText'=>'',
        'columns'=>array(
            //'id',
            //'code',
            array('name'=>'movement_out_no', 'value'=>'CHTml::link($data->movement_out_no, array("/transaction/MovementOutHeader/view", "id"=>$data->id))', 'type'=>'raw'),
            //'movement_out_no',
            'date_posting',
            'status',
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