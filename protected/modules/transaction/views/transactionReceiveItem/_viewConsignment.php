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
        'columns'=>array(
            array(
                'name'=>'consignment_in_number', 
                'value'=>'CHTml::link($data->consignment_in_number, array("/transaction/ConsignmentInHeader/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'date_posting',
            'status_document',
            array(
                'header'=>'Receives',
                'value'=> function($data){
                    if(count($data->transactionReceiveItems) >0) {
                        foreach ($data->transactionReceiveItems as $key => $receive) {
                            echo $receive->receive_item_no. "<br>";
                        }
                    }
                }
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"3"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>