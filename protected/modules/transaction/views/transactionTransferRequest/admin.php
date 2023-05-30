<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TransactionTransferRequest', 'url' => array('index')),
    array('label' => 'Create TransactionTransferRequest', 'url' => array('create')),
);

// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').toggle();
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#transaction-transfer-request-grid').yiiGridView('update', {
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
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Transfer Request', Yii::app()->baseUrl . '/transaction/transferRequest/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("transferRequestCreate"))) ?>
        <h1>Manage Transaction Transfer Request</h1>
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
                    <?php
                    $this->renderPartial('_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div><!-- search-form -->				
            </div>
        </div>

        <div class="grid-view">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'transaction-transfer-request-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'name' => 'transfer_request_no',
                        'value' => 'CHTml::link($data->transfer_request_no, array("view", "id"=>$data->id))',
                        'type' => 'raw'
                    ),
                    'transfer_request_date',
                    'status_document',
                    'estimate_arrival_date',
                    // 'requester_id',
                    array(
                        'name' => 'branch_name',
                        'value' => '$data->requesterBranch->name'
                    ),
                    /*
                      'requester_branch_id',
                      'approved_by',
                      'destination_id',
                      'destination_branch_id',
                      'total_quantity',
                      'total_price',
                     */
//                    array(
//                        'class' => 'CButtonColumn',
//                        'template' => '{edit}',
//                        'buttons' => array
//                            (
//                            'edit' => array
//                                (
//                                'label' => 'edit',
//                                'url' => 'Yii::app()->createUrl("transaction/transferRequest/update", array("id"=>$data->id))',
//                                'visible' => '$data->status_document != "Approved" && $data->status_document != "Rejected" && Yii::app()->user->checkAccess("transferRequestEdit")',
//                            ),
//                        ),
//                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>