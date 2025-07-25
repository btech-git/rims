<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'service-category-grid',
    'dataProvider'=>$serviceCategoryDataProvider,
    'filter'=>$serviceCategory,
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
            'cssClassExpression' => '"service-category-item-checkbox"',
        ),
        array(
            'name' => 'service_type_id',
            'value' => '$data->serviceType->name'
        ),
        'code',
        array(
            'name' => 'name', 
            'value' => 'CHTml::link($data->name, array("/master/service/view", "id"=>$data->id))', 
            'type' => 'raw'
        ),
        'coa.name',
//        'user.username',
//        array(
//            'header' => 'Input', 
//            'value' => '$data->created_datetime', 
//        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/serviceCategoryApproval", array("serviceCategoryId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to APPROVE this service?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/serviceCategoryReject", array("serviceCategoryId"=>$data->id))',
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
        'id' => 'service-category-approve-button',
        'onclick' => '
            var ids = [];
            $(".service-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxApproveAllServiceCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
    
    <?php echo CHtml::button('Reject All', array(
        'id' => 'service-category-reject-button',
        'onclick' => '
            var ids = [];
            $(".service-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxRejectAllServiceCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
</div>