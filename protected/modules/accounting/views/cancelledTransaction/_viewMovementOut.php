<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'movement-out-grid',
    'dataProvider'=>$movementOutDataProvider,
    'filter'=>$movementOut,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'movement_out_no', 
            'value'=>'$data->movement_out_no', 
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
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/movementOutHeader/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>