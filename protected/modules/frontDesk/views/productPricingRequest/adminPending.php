<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(
    'Product',
    'Brands' => array('admin'),
    'Manage Brands',
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
        
	if ($(this).hasClass('active')) {
            $(this).text('');
	} else {
            $(this).text('Advanced Search');
	}
        
	return false;
    });
    
    $('.search-form form').submit(function() {
	$('#brand-grid').yiiGridView('update', {
            data: $(this).serialize()
	});
        
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h2>Manage Permintaan Harga</h2>
    </div>

    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'product-pricing-grid',
            'dataProvider' => $dataProviderRequest,
            'filter' => $model,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'name' => 'transaction_number', 
                    'value' => 'CHtml::link($data->transaction_number, array("show", "id"=>$data->id))',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'vehicle_car_make_id', 
                    'value' => '$data->carMakeModelSubCombination',
                ),
                'production_year',
                array(
                    'name' => 'request_date',
                    'value' => '$data->request_date',
                ),
                array(
                    'header' => 'User Request',
                    'name' => 'user_id_request',
                    'value' => '$data->userIdRequest->username',
                ),
                array(
                    'header' => 'Branch Request',
                    'name' => 'branch_id_request',
                    'value' => '$data->branchIdRequest->code',
                ),
                array(
                    'name' => 'request_note',
                    'value' => 'substr($data->request_note, 0, 30)',
                ),
                array(
                    'name' => 'reply_date',
                    'value' => '$data->reply_date',
                ),
                array(
                    'header' => 'User Reply',
                    'name' => 'user_id_reply',
                    'value' => 'empty($data->user_id_reply) ? "" : $data->userIdReply->username',
                ),
                array(
                    'header' => 'Branch Reply',
                    'name' => 'branch_id_reply',
                    'value' => 'empty($data->branch_id_reply) ? "" : $data->branchIdReply->code',
                ),
                array(
                    'name' => 'reply_note',
                    'value' => 'substr($data->reply_note, 0, 30)',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit}',
                    'buttons' => array(
                        'edit' => array(
                            'label' => 'edit',
                            'url' => 'Yii::app()->createUrl("frontDesk/productPricingRequest/updateReply", array("id"=>$data->id))',
                            'visible' => '$data->user_id_reply !== null',
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>

    <hr />
    
    <div class="clearfix page-action">
        <h2>Pending Permintaan Harga</h2>
    </div>

    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'product-pricing-grid',
            'dataProvider' => $dataProviderReply,
            'filter' => $model,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'name' => 'transaction_number', 
                    'value' => 'CHtml::link($data->transaction_number, array("show", "id"=>$data->id))',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'vehicle_car_make_id', 
                    'value' => '$data->carMakeModelSubCombination',
                ),
                'production_year',
                array(
                    'name' => 'request_date',
                    'value' => '$data->request_date',
                ),
                array(
                    'header' => 'User Request',
                    'name' => 'user_id_request',
                    'value' => '$data->userIdRequest->username',
                ),
                array(
                    'header' => 'Branch Request',
                    'name' => 'branch_id_request',
                    'value' => '$data->branchIdRequest->code',
                ),
                array(
                    'name' => 'request_note',
                    'value' => '$data->request_note',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{reply}',
                    'buttons' => array(
                        'reply' => array(
                            'label' => 'reply',
                            'url' => 'Yii::app()->createUrl("frontDesk/productPricingRequest/reply", array("id"=>$data->id))',
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>