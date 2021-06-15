<h2>Receive Item</h2>
<div class="grid-view">
<!--    <table>
        <thead>
            <tr>
                <td>Tanggal</td>
                <td>Supplier</td>
                <td>Type</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'receive_item_date',
                        'attribute' => $receiveItem->receive_item_date,
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'Date'
                        ),
                    ));*/ ?>
                </td>
                <td>
                    <?php /*echo CHtml::activeDropDownList($receiveItem, 'supplier_id', CHtml::listData(Supplier::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                        'empty' => '-- All --',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'update' => '#receive-item-grid',
                        ))
                    ));*/ ?>
                </td>
                <td>
                    <?php /*echo CHtml::activeDropDownList($receiveItem, 'request_type', array(
                        'Purchase Order' => 'Purchase Order',
                        'Internal Delivery Order' => 'Internal Delivery Order', 
                        'Consignment In' => 'Consignment In'
                    ), array(
                        'empty' => '-- All --',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'update' => '#receive-item-grid',
                        ))
                    ));*/ ?>
                </td>
            </tr>
        </tbody>
    </table>-->
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'receive-item-grid',
        'dataProvider'=>$receiveItem->searchByMovementIn(),
        'filter'=>$receiveItem,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'receive_item_no', 
                'value'=>'CHTml::link($data->receive_item_no, array("/transaction/transactionReceiveItem/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'receive_item_date',
            array(
                'name'=>'supplier_id', 
                'filter' => CHtml::activeTextField($receiveItem, 'supplier_name'), 
                'value'=>'empty($data->supplier_id) ? "" : $data->supplier->name', 
                'type'=>'raw'
            ),
            array(
                'name' => 'request_type',
                'filter' => CHtml::activeDropDownList($receiveItem, 'request_type', array(
                    'Purchase Order' => 'Purchase Order',
                    'Internal Delivery Order' => 'Internal Delivery Order', 
                    'Consignment In' => 'Consignment In'
                ), array('empty' => '-- All --')),
                'value' => '$data->request_type'
            ),
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementInHeaders as $key => $movementDetail) {
                        echo $movementDetail->movement_in_number. "<br>";
                    }
                }
            ),
        ),
    )); ?>
</div>