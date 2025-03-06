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

    <div class="search-bar">
        <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>  
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php /*$this->renderPartial('_search', array(
                    'model' => $model,
                ));*/ ?>
            </div><!-- search-form -->
        </div>
    </div>
    
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'product-pricing-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'name' => 'product_name', 
                    'value' => '$data->product_name',
                ),
                array(
                    'name' => 'request_date',
                    'value' => '$data->request_date',
                ),
                array(
                    'name' => 'quantity',
                    'value' => '$data->quantity',
                ),
                array(
                    'name' => 'user_id_request',
                    'value' => '$data->userIdRequest->username',
                ),
                array(
                    'name' => 'request_note',
                    'value' => '$data->request_note',
                ),
                array(
                    'name' => 'branch_id_request',
                    'value' => '$data->branchIdRequest->code',
                ),
                array(
                    'name' => 'reply_date',
                    'value' => '$data->reply_date',
                ),
                array(
                    'name' => 'recommended_price',
                    'value' => '$data->recommended_price',
                ),
                array(
                    'name' => 'user_id_reply',
                    'value' => 'empty($data->user_id_reply) ? "" : $data->userIdReply->username',
                ),
                array(
                    'name' => 'branch_id_reply',
                    'value' => 'empty($data->branch_id_reply) ? "" : $data->branchIdReply->code',
                ),
                array(
                    'name' => 'reply_note',
                    'value' => '$data->reply_note',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{reply} {show}',
                    'buttons' => array(
                        'reply' => array(
                            'label' => 'reply',
                            'url' => 'Yii::app()->createUrl("frontDesk/productPricingRequest/update", array("id"=>$data->id))',
                        ),
                        'show' => array(
                            'label' => 'show',
                            'url' => 'Yii::app()->createUrl("frontDesk/productPricingRequest/show", array("id"=>$data->id))',
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>