<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'maintenance-request-grid',
    'dataProvider'=>$maintenanceRequestHeaderDataProvider,
    'filter'=>$maintenanceRequestHeader,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name'=>'transaction_number', 
            'value' => '$data->transaction_number', 
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'transaction_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)'
        ),
        'status',
        array('name'=>'branch_id','value'=>'$data->branch->name'),
        array('name'=>'priority_level','value'=>'$data->priorityLevelConstant'),
        array('name'=>'description','value'=> '$data->description'),
        'note',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'approval',
                    'url'=>'Yii::app()->createUrl("frontDesk/maintenanceRequest/updateApproval", array("headerId"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>