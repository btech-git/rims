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
        <?php echo CHtml::link('<span class="fa fa-plus"></span>Permintaan Harga', Yii::app()->baseUrl . '/frontDesk/productPricingRequest/create', array('class' => 'button success right')) ?>
        <h2>Manage Permintaan Harga</h2>
    </div>

<!--    <div class="search-bar">
        <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>  
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php /*$this->renderPartial('_search', array(
                    'model' => $model,
                ));*/ ?>
            </div> search-form 
        </div>
    </div>-->
    
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'product-pricing-grid',
            'dataProvider' => $dataProvider,
            'filter' => $model,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'name' => 'transaction_number', 
                    'value' => '$data->transaction_number',
                ),
                array(
                    'name' => 'vehicle_car_make_id', 
                    'value' => '$data->vehicleCarMake->name',
                ),
                array(
                    'name' => 'vehicle_car_model_id', 
                    'value' => '$data->vehicleCarModel->name',
                ),
                array(
                    'name' => 'vehicle_car_sub_model_id', 
                    'value' => '$data->vehicleCarSubModel->name',
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
                    'name' => 'request_note',
                    'value' => '$data->request_note',
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
                    'name' => 'reply_note',
                    'value' => '$data->reply_note',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'headerHtmlOptions'=>array('style'=>'width: 300px;'),
                    'htmlOptions'=>array('style'=>'width: 300px;'), 
                    'template' => '{update} {view}',
                ),
            ),
        )); ?>
    </div>
</div>