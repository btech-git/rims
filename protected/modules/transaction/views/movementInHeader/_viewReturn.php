<h2>Return Item</h2>
<hr />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'return-item-grid',
        'dataProvider'=>$returnItem->search(),
        'filter'=>$returnItem,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'return_item_no', 
                'value'=>'CHTml::link($data->return_item_no, array("/transaction/transactionReturnItem/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'return_item_date',
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementInHeaders as $key => $movementDetail) {
                        echo $movementDetail->movement_in_number. "<br>";
                    }
                }
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"2"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>