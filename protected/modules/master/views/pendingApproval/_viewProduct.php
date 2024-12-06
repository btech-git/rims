<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'product-grid',
    'dataProvider'=>$productDataProvider,
    'filter'=>$product,
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
            'cssClassExpression' => '"product-item-checkbox"',
        ),
        'id',
        'manufacturer_code',
        array(
            'name' => 'name',
            'value' => 'CHTml::link($data->name, array("/master/product/view", "id"=>$data->id))',
            'type' => 'raw'
        ),
        array(
            'name' => 'brand_id',
            'value' => '$data->brand ? $data->brand->name : \'\'',
        ),
        array(
            'name' => 'sub_brand_id',
            'value' => '$data->subBrand ? $data->subBrand->name : \'\'',
            'filter' => false,
        ),
        array(
            'name' => 'sub_brand_series_id',
            'value' => '$data->subBrandSeries ? $data->subBrandSeries->name : \'\'',
            'filter' => false,
        ),
        array(
            'header' => 'Master Category',
            'value' => '$data->productMasterCategory->name',
            'filter' => false,
        ),
        array(
            'header' => 'Sub Master Category',
            'value' => '$data->productSubMasterCategory->name',
            'filter' => false,
        ),
        array(
            'header' => 'Sub Category',
            'value' => '$data->productSubCategory->name',
            'filter' => false,
        ),
        'user.username',
        'date_posting',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productApproval", array("productId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this product?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/productReject", array("productId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this product?',
                    ),
                ),
            ),
        ),
    ),
)); ?>

<div>
    <?php echo CHtml::button('Approve All', array(
        'id' => 'product-approve-button',
        'onclick' => '
            var ids = [];
            $(".product-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxApproveAllProduct', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
    
    <?php echo CHtml::button('Reject All', array(
        'id' => 'product-reject-button',
        'onclick' => '
            var ids = [];
            $(".product-item-checkbox > input:checked").each(function() {
                ids.push($(this).val());
            })
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxRejectAllProduct', array('ids' => '__ids__')) . '".replace("__ids__", ids.join(",")),
                success: function(data) {
                    location.reload();
                },
            });
        ',
    )); ?>
</div>