<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$warehouseDataProvider,
    'filter'=>$warehouse,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        'code',
        array(
            'name'=>'name', 
            'value'=>'CHTml::link($data->name, array("/master/warehouse/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        'description',
        array(
            'header'=>'Status', 
            'name'=>'status',
            'value'=>'$data->status',
            'type'=>'raw',
            'filter'=>CHtml::dropDownList('Warehouse[status]', 'warehouse_status', array(
                ''=>'Select',
                'Active' => 'Active',
                'Inactive' => 'Inactive',
            )),
        ),
        'user.username',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/warehouseApproval", array("warehouseId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this warehouse?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/warehouseReject", array("warehouseId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this warehouse?',
                    ),
                ),
            ),
        ),
    ),
)); ?>