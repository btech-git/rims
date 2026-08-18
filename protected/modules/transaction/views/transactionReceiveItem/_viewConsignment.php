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
                'header' => 'Transaction #',
                'value'=>'CHtml::link($data->consignment_in_number, array("/transaction/ConsignmentInHeader/view", "id"=>$data->id))', 
                'type'=>'raw',
            ),
            array(
                'name' => 'date_posting',
                'header' => 'Tanggal',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date_posting)',
            ),
            array(
                'name' => 'date_arrival',
                'header' => 'ETA',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date_arrival)',
            ),
            array(
                'header' => 'Umur (hari)', 
                'value' => '$data->outstandingDays',
                'htmlOptions' => array('style' => 'text-align: center'),
            ),
            array(
                'header' => 'Supplier',
                'name'=>'supplier_id',
                'value'=>'$data->supplier->name'
            ),
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