<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'cash-transaction-grid',
    'dataProvider'=>$cashTransactionDataProvider,
    'filter'=>$cashTransaction,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'transaction_number', 
            'value'=>'$data->transaction_number', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'transaction_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)'
        ),
        'transaction_type',
        'debit_amount',
        'credit_amount',
        'status',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/cashTransaction/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>