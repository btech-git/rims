<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'movement-in-grid',
    'dataProvider'=>$movementInDataProvider,
    'filter'=>$movementIn,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'movement_in_number', 
            'value'=>'$data->movement_in_number', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date_posting',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date_posting)'
        ),
        array('name'=>'movement_type','value'=>'$data->getMovementType($data->movement_type)'),
        'status',
        array(
            'header' => 'Cancelled by',
            'name' => 'user_id_cancelled',
            'filter' => false,
            'value' => 'empty($data->user_id_cancelled) ? "" : $data->userIdCancelled->username',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/movementIn/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>