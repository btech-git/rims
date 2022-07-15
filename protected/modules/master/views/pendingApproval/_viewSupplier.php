<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$supplierDataProvider,
    'filter'=>$supplier,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name' => 'name', 
            'value' => 'CHTml::link($data->name, array("/master/supplier/view", "id"=>$data->id))', 
            'type' => 'raw'
        ),
//        'date',
        'code',
        'company',
        'person_in_charge',
        'phone',
        'position',
        array('name' => 'coa_name', 'value' => '$data->coa!=""?$data->coa->name : ""'),
        array('name' => 'coa_code', 'value' => '$data->coa!=""?$data->coa->code : ""'),
        array(
            'name' => 'coa_outstanding_name', 
            'value' => '$data->coaOutstandingOrder!=""?$data->coaOutstandingOrder->name : ""'
        ),
        array(
            'name' => 'coa_outstanding_code', 
            'value' => '$data->coaOutstandingOrder!=""?$data->coaOutstandingOrder->code : ""'
        ),
        'user.username',
        array(
            'header' => 'Input', 
            'value' => '$data->createdDatetime', 
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/supplierApproval", array("supplierId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this supplier?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/supplierReject", array("supplierId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this supplier?',
                    ),
                ),
            ),
        ),
    ),
)); ?>