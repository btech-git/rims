<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'cusotmer-grid',
    'dataProvider'=>$customerDataProvider,
    'filter'=>$customer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        array('name'=>'name', 'value'=>'CHTml::link($data->name, array("/master/customer/view", "id"=>$data->id))', 'type'=>'raw'),
        array('header'=>'Province Name','name'=>'province_name', 'value'=>'$data->province->name'),
        array('header'=>'City Name','name'=>'city_name', 'value'=>'$data->city->name'),
        'email',
        array(
            'header'=>'Customer Type', 
            'name'=>'customer_type',
            'value'=>'$data->customer_type',
            'type'=>'raw',
            'filter'=>CHtml::dropDownList('Customer[customer_type]', $customer->customer_type, 
                array(
                    ''=>'All',
                    'Company' => 'Company',
                    'Individual' => 'Individual',
                )
            ),
        ),
        array(
            'header'=>'Status',
            'name'=>'status',
            'value'=>'$data->status',
            'type'=>'raw',
            'filter'=>CHtml::dropDownList('Customer[status]', $customer->status, 
                array(
                    ''=>'All',
                    'Active' => 'Active',
                    'Inactive' => 'Inactive',
                )
            ),
        ),
        'user.username',
        array('name'=>'coa_name','value'=>'$data->coa!="" ? $data->coa->name : ""'),
        array('name'=>'coa_code','value'=>'$data->coa!="" ? $data->coa->code : ""'),
        array(
            'header' => 'Input', 
            'value' => '$data->date_created', 
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/customerApproval", array("customerId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this customer?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/customerReject", array("customerId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this customer?',
                    ),
                ),
            ),
        ),
    ),
)); ?>