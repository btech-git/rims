<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'product-sub-master-category-grid',
    'dataProvider'=>$productSubMasterCategoryDataProvider,
    'filter'=>$productSubMasterCategory,
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
            'cssClassExpression' => '"product-sub-master-category-item-checkbox"',
        ),
        'id',
        'code',
        array(
            'name' => 'name',
            'value' => 'CHTml::link($data->name, array("/master/productSubMasterCategory/view", "id"=>$data->id))',
            'type' => 'raw'
        ),
        array(
            'name' => 'product_master_category_id',
            'value' => 'empty($data->product_master_category_id) ? " " : $data->productMasterCategory->name',
        ),
        'user.username',
        'date_posting',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productSubMasterCategoryApproval", array("productSubMasterCategoryId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to APPROVE this sub master category?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productSubMasterCategoryReject", array("productSubMasterCategoryId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to REJECT this sub master category?',
                    ),
                ),
            ),
        ),
    ),
)); ?>

<div>
    <?php echo CHtml::button('Approve All', array(
        'id' => 'product-sub-master-category-approve-button',
        'onclick' => '
            var ids = [];
            $(".product-sub-master-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxApproveAllProductSubMasterCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
    
    <?php echo CHtml::button('Reject All', array(
        'id' => 'product-sub-master-category-reject-button',
        'onclick' => '
            var ids = [];
            $(".product-sub-master-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxRejectAllProductSubMasterCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
</div>