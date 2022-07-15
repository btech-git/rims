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
            'value'=>'CHTml::link($data->movement_out_no, array("/transaction/movementOutHeader/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date_posting',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->date_posting)'
        ),
        array('name'=>'branch_id','value'=>'$data->branch->name'),
        'status',
        array('name'=>'user_id','value'=> '$data->user->username'),
        array(
            'header' => 'Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
        ),
    ),
)); ?>