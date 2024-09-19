<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'consignment-in-grid',
    'dataProvider'=>$stockAdjustmentDataProvider,
    'filter'=>$stockAdjustmentHeader,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name'=>'stock_adjustment_number', 
            'value'=>'CHTml::link($data->stock_adjustment_number, array("/transaction/stockAdjustmentHeader/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date_posting',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->date_posting)'
        ),
        'status',
        array('name'=>'user_id','value'=> '$data->user->username'),
        array('name'=>'branch','value'=> '$data->branch->name'),
        array(
            'header' => 'Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
        ),
    ),
)); ?>