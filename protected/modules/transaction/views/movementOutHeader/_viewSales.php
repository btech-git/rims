<h2>Retail Sales</h2>
<hr />
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'retail-sale-grid',
        'dataProvider'=>$registrationTransactionDataProvider,
        'filter'=>$registrationTransaction,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'transaction_number', 
                'value'=>'CHtml::link($data->transaction_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'transaction_date',
                'value'=>'$data->transaction_date'
            ),
            array(
                'name' => 'repair_type',
                'filter' => CHtml::activeDropDownList($registrationTransaction, 'repair_type', array(
                    'BR' => 'Body Repair',
                    'GR' => 'General Repair', 
                ), array('empty' => '-- All --')),
                'value' => '$data->repair_type',
            ),
            array(
                'name'=>'customer_id', 
                'filter' => CHtml::activeTextField($registrationTransaction, 'customer_name'), 
                'value'=>'empty($data->customer_id) ? "" : $data->customer->name', 
                'type'=>'raw'
            ),
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementOutHeaders as $key => $movementDetail) {
                        echo CHtml::link($movementDetail->movement_out_no, array("/transaction/movementOutHeader/view", "id"=>$movementDetail->id)). "<br />";
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