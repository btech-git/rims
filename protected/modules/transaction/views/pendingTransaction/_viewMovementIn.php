<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'movement-in-grid',
    'dataProvider'=>$movementInDataProvider,
    'filter'=>$movementIn,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    'columns'=>array(
        array(
            'name'=>'movement_in_number', 
            'value'=>'CHTml::link($data->movement_in_number, array("/transaction/movementInHeader/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date_posting',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->date_posting)'
        ),
        'branch.name: Branch',
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