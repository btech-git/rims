<?php
/* @var $this TransactionRequestOrderController */
/* @var $model TransactionRequestOrder */

$this->breadcrumbs = array(
    'Transaction Request Orders' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TransactionRequestOrder', 'url' => array('index')),
    array('label' => 'Create TransactionRequestOrder', 'url' => array('create')),
);

// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').toggle();
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#transaction-request-order-grid').yiiGridView('update', {
// 		data: $(this).serialize()
// 	});
// 	return false;
// });
// ");
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').slideToggle(600);
		$('.bulk-action').toggle();
		$(this).toggleClass('active');
		if($(this).hasClass('active')){
			$(this).text('');
		}else {
			$(this).text('Advanced Search');
		}
		return false;
	});
	$('.search-form form').submit(function(){
		$('#transaction-request-order-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Request Order', Yii::app()->baseUrl . '/transaction/transactionRequestOrder/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("requestOrderCreate"))) ?>
        <h1>Manage Transaction Request Orders</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
                <!--<div class="left clearfix bulk-action">
                        <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                        <input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
                        <input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
                </div>-->
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_search', array(
                        'model' => $model,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div><!-- search-form -->				
            </div>
        </div>

        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'transaction-request-order-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    'id',
                    array(
                        'name' => 'request_order_no', 
                        'value' => 'CHTml::link($data->request_order_no, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    'request_order_date',
                    'total_items',
                    array(
                        'name' => 'total_price', 
                        'value' => '$data->total_price', 
                        'type' => 'number'
                    ),
                    'status_document',
                    'notes',
                    array(
                        'name' => 'requester_id',
                        'value' => '$data->user->username'
                    ),
                    array(
                        'name' => 'request_branch_name',
                        'filter' => CHtml::activeDropDownList($model, 'requester_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->requesterBranch->name'
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
//                    array(
//                        'class' => 'CButtonColumn',
//                        'template' => '{edit}',
//                        'buttons' => array(
//                            'edit' => array(
//                                'label' => 'edit',
//                                'url' => 'Yii::app()->createUrl("transaction/transactionRequestOrder/update", array("id"=>$data->id))',
//                                'visible' => 'Yii::app()->user->checkAccess("requestOrderEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected"',
//                            ),
//                        ),
//                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
