<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'product-master-category-grid',
    'dataProvider'=>$productMasterCategoryDataProvider,
    'filter'=>$productMasterCategory,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '2',
            'value' => '$data->id',
            'cssClassExpression' => '"product-master-category-item-checkbox"',
        ),
        'id',
        'code',
        array(
            'name' => 'name',
            'value' => 'CHTml::link($data->name, array("/master/productMasterCategory/view", "id"=>$data->id))',
            'type' => 'raw'
        ),
        'description',
        'user.username',
        'date_posting',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productMasterCategoryApproval", array("productMasterCategoryId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to APPROVE this master category?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productMasterCategoryReject", array("productMasterCategoryId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to REJECT this master category?',
                    ),
                ),
            ),
        ),
    ),
)); ?>

<div>
    <?php echo CHtml::button('Approve All', array(
        'id' => 'product-master-category-approve-button',
        'onclick' => '
            var ids = [];
            $(".product-master-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxApproveAllProductMasterCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
    
    <?php echo CHtml::button('Reject All', array(
        'id' => 'product-master-category-reject-button',
        'onclick' => '
            var ids = [];
            $(".product-master-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxRejectAllProductMasterCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
</div>