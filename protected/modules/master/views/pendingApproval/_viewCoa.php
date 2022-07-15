<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transfer-grid',
    'dataProvider'=>$coaDataProvider,
    'filter'=>$coa,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns' => array(
        'id',
        array(
            'name' => 'name', 
            'value' => 'CHTml::link($data->name, array("/accounting/coa/view", "id"=>$data->id))', 
            'type' => 'raw'
        ),
        'code',
        array(
            'name' => 'coa_category_id',
            'filter' => CHtml::activeDropDownList($coa, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->coaCategory!="" ?$data->coaCategory->name:""',
        ),
        array(
            'name' => 'coa_sub_category_id',
            'filter' => CHtml::activeDropDownList($coa, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->coaSubCategory!="" ?$data->coaSubCategory->name:""'
        ),
        'normal_balance',
        'opening_balance',
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
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/coaApproval", array("coaId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this COA?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/coaReject", array("coaId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this COA?',
                    ),
                ),
            ),
        ),
    ),
)); ?>