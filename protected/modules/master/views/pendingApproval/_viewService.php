<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'service-grid',
    'dataProvider'=>$serviceDataProvider,
    'filter'=>$service,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        //'id',
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '2',
            'header' => 'Selected',
            'value' => '$data->id',
        ),
        array('name' => 'service_type_code', 'value' => '$data->serviceType->code'),
        array(
            'name' => 'service_type_name',
            'filter' => CHtml::activeDropDownList($service, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->serviceType->name'
        ),
        array('name' => 'service_category_code', 'value' => '$data->serviceCategory->code'),
        array(
            'name' => 'service_category_name',
            'filter' => CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->serviceCategory->name'
        ),
        'code',
        array(
            'name' => 'name', 
            'value' => 'CHTml::link($data->name, array("/master/service/view", "id"=>$data->id))', 
            'type' => 'raw'
        ),
//        'description',
        array(
            'header' => 'Status',
            'name' => 'status',
            'value' => '$data->status',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('Service[status]', $service->status, array(
                '' => 'All',
                'Active' => 'Active',
                'Inactive' => 'Inactive',
            )),
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
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/serviceApproval", array("serviceId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this service?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/serviceReject", array("serviceId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this service?',
                    ),
                ),
            ),
        ),
    ),
)); ?>