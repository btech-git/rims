<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'car-sub-model-grid',
    'dataProvider'=>$carSubModelDataProvider,
    'filter'=>$carSubModel,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        'carMake.name',
        'carModel.name',
        array(
            'name'=>'name', 
            'value'=>'CHTml::link($data->name, array("/master/vehicleCarSubModel/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        'user.username',
        array(
            'header' => 'Input', 
            'value' => '$data->created_datetime', 
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/subModelApproval", array("subModelId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this car sub model?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/subModelReject", array("subModelId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this car sub model?',
                    ),
                ),
            ),
        ),
    ),
)); ?>