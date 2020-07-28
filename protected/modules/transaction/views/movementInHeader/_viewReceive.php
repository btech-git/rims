<h2>Receive Item</h2>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'receive-item-grid',
        'dataProvider'=>$receiveItem->search(),
        'filter'=>$receiveItem,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
        //'id',
        array('name'=>'receive_item_no', 'value'=>'CHTml::link($data->receive_item_no, array("/transaction/transactionReceiveItem/view", "id"=>$data->id))', 'type'=>'raw'),
        'receive_item_date',
        array('header'=>'Movements','value'=> function($data){
            foreach ($data->movementInHeaders as $key => $movementDetail) {
                echo $movementDetail->movement_in_number. "<br>";

            }

        }


        ),
        // 'user_id',
        /*
        'supervisor_id',
        'status',
        */

        ),
        )); ?>
</div>