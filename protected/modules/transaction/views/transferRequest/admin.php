<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
    'Transaction Transfer Requests'=>array('admin'),
    'Manage',
);

$this->menu=array(
    array('label'=>'List TransactionTransferRequest', 'url'=>array('index')),
    array('label'=>'Create TransactionTransferRequest', 'url'=>array('create')),
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
        $('#transaction-transfer-request-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
"); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-list"></span>Approval Transfer Request', Yii::app()->baseUrl . '/transaction/transferRequest/adminDestination', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("transferRequestEdit")
                )); ?> &nbsp;&nbsp;&nbsp;
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Transfer Request', Yii::app()->baseUrl.'/transaction/transferRequest/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionTransferRequest.create"))) ?>
        <h1>Manage Transfer Request</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                )); ?>
                </div><!-- search-form -->				
            </div>
         </div>

        <h3>Request Branch Asal</h3>
         <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'transaction-transfer-request-grid',
                'dataProvider'=>$dataProvider,
                'filter'=> null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                    ),
                'columns'=>array(
                    array(
                        'name'=>'transfer_request_no', 
                        'value'=>'CHTml::link($data->transfer_request_no, array("view", "id"=>$data->id))', 
                        'type'=>'raw'
                    ),
                    'transfer_request_date',
                    'transfer_request_time',
                    'status_document',
                    array(
                        'name'=>'requester_branch_id',
                        'header' => 'Requester',
                        'filter' => CHtml::activeDropDownList($model, 'requester_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value'=>'$data->requesterBranch->name'
                    ),
                    array(
                        'name'=>'destination_branch_id',
                        'header' => 'Destination',
                        'filter' => CHtml::activeDropDownList($model, 'destination_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value'=>'$data->destinationBranch->name'
                    ),
                    array(
                        'header' => 'Delivery Status',
                        'value' => '$data->totalRemainingQuantityDelivered',
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
//                    array(
//                        'class'=>'CButtonColumn',
//                        'template'=>'{edit}',
//                        'buttons'=>array (
//                            'edit' => array (
//                                'label'=>'edit',
//                                'url'=>'Yii::app()->createUrl("transaction/transferRequest/update", array("id"=>$data->id))',
//                                'visible'=> 'Yii::app()->user->checkAccess("transferRequestEdit")', //$data->status_document == "Draft" && ',
//                            ),
//                        ),
//                    ),
                ),
            )); ?>
        </div>
    </div>
</div>