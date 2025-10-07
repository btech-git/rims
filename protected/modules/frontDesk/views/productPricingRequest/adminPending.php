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
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', Yii::app()->baseUrl . '/frontDesk/productPricingRequest/admin', array('class' => 'button primary right', 'target' => '_blank')) ?>
        <h2>Pending Permintaan Harga</h2>
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
            'dataProvider' => $dataProvider,
            'filter' => $model,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
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
                    'name' => 'request_date',
                    'value' => '$data->request_date',
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
                    'class' => 'CButtonColumn',
                    'template' => '{reply} {show}',
                    'buttons' => array(
                        'reply' => array(
                            'label' => 'reply',
                            'url' => 'Yii::app()->createUrl("frontDesk/productPricingRequest/reply", array("id"=>$data->id))',
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