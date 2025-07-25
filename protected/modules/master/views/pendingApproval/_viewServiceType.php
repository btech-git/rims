<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'service-type-grid',
    'dataProvider'=>$serviceTypeDataProvider,
    'filter'=>$serviceType,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '2',
            'value' => '$data->id',
            'cssClassExpression' => '"service-type-item-checkbox"',
        ),
        'code',
        array(
            'name' => 'name', 
            'value' => 'CHTml::link($data->name, array("/master/serviceType/view", "id"=>$data->id))', 
            'type' => 'raw'
        ),
        array(
            'name' => 'coa_id',
            'value' => '$data->coa->name'
        ),
//        'user.username',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/serviceTypeApproval", array("serviceTypeId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to APPROVE this service?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/serviceTypeReject", array("serviceTypeId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to REJECT this service?',
                    ),
                ),
            ),
        ),
    ),
)); ?>

<div>
    <?php echo CHtml::button('Approve All', array(
        'id' => 'service-type-approve-button',
        'onclick' => '
            var ids = [];
            $(".service-type-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxApproveAllServiceType', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
    
    <?php echo CHtml::button('Reject All', array(
        'id' => 'service-type-reject-button',
        'onclick' => '
            var ids = [];
            $(".service-type-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxRejectAllServiceType', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
</div>