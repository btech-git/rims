<h2>Movement Out</h2>
					
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
        'columns'=>array(
            array(
                'name'=>'movement_out_no', 
                'value'=>'CHTml::link($data->movement_out_no, array("/transaction/MovementOutHeader/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'date_posting',
            'status',
            array(
                'header'=>'Receives',
                'value'=> function($data){
                    if (count($data->transactionReceiveItems) >0) {
                        foreach ($data->transactionReceiveItems as $key => $receive) {
                            echo $receive->receive_item_no. "<br>";
                        }
                    }
                }
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"4"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>