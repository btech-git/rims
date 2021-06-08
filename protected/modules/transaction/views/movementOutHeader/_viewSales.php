<h2>Retail Sales</h2>
<hr>
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
                'value'=>'CHTml::link($data->transaction_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'transaction_date',
                'value'=>'$data->transaction_date'
            ),
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementOutHeaders as $key => $movementDetail) {
                        echo $movementDetail->movement_out_no. "<br>";
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