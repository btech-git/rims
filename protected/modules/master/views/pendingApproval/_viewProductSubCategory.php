<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'product-sub-category-grid',
    'dataProvider'=>$productSubCategoryDataProvider,
    'filter'=>$productSubCategory,
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
            'cssClassExpression' => '"product-sub-category-item-checkbox"',
        ),
        'id',
        'code',
        array(
            'name' => 'name',
            'value' => 'CHtml::link($data->name, array("/master/productSubCategory/view", "id"=>$data->id))',
            'type' => 'raw'
        ),
        array(
            'name' => 'product_master_category_id',
            'value' => 'empty($data->product_master_category_id) ? " " : $data->productMasterCategory->name',
        ),
        array(
            'name' => 'product_sub_master_category_id',
            'value' => 'empty($data->product_sub_master_category_id) ? " " : $data->productSubMasterCategory->name',
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
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productSubCategoryApproval", array("productSubCategoryId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to APPROVE this sub category?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productSubCategoryReject", array("productSubCategoryId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to REJECT this sub category?',
                    ),
                ),
            ),
        ),
    ),
)); ?>

<div>
    <?php echo CHtml::button('Approve All', array(
        'id' => 'product-sub-category-approve-button',
        'onclick' => '
            var ids = [];
            $(".product-sub-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxApproveAllProductSubCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
    
    <?php echo CHtml::button('Reject All', array(
        'id' => 'product-sub-category-reject-button',
        'onclick' => '
            var ids = [];
            $(".product-sub-category-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxRejectAllProductSubCategory', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
</div>