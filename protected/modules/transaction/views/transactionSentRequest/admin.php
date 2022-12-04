<?php
/* @var $this TransactionSentRequestController */
/* @var $model TransactionSentRequest */

$this->breadcrumbs=array(
    'Transaction Transfer Requests'=>array('admin'),
    'Manage',
);

$this->menu=array(
    array('label'=>'List TransactionSentRequest', 'url'=>array('index')),
    array('label'=>'Create TransactionSentRequest', 'url'=>array('create')),
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
        $('#transaction-sent-request-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
"); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Sent Request', Yii::app()->baseUrl . '/transaction/transactionSentRequest/adminDestination', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("sentRequestEdit")
        )); ?> &nbsp;&nbsp;&nbsp;
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Sent Request', Yii::app()->baseUrl.'/transaction/transactionSentRequest/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionSentRequest.create"))) ?>
        <h1>Manage Transaction Sent Request</h1>
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
                'id'=>'transaction-sent-request-grid',
                'dataProvider'=>$dataProvider,
                'filter'=> null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'columns'=>array(
                    array(
                        'name'=>'sent_request_no', 
                        'value'=>'CHTml::link($data->sent_request_no, array("view", "id"=>$data->id))', 
                        'type'=>'raw'
                    ),
                    'sent_request_date',
                    'estimate_arrival_date',
                    array(
                        'name'=>'requester_branch_id',
                        'value'=>'$data->requesterBranch->name'
                    ),
                    array(
                        'name'=>'destination_branch_id',
                        'value'=>'$data->destinationBranch->name'
                    ),
                    'status_document',
                    array(
                        'name'=>'approved_by',
                        'value'=>'$data->approval!= null?$data->approval->username:""',
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
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array (
                            'update' => array (
                                'label'=>'update',
                                'url'=>'Yii::app()->createUrl("transaction/transactionSentRequest/update", array("id"=>$data->id))',
                                'visible'=> '$data->status_document != "Approved" && $data->status_document != "Rejected" && Yii::app()->user->checkAccess("transaction.transactionSentRequest.update")',
                                ),
                            'delete' => array(
                                'label' => 'delete',
                                'url'=>'Yii::app()->createUrl("transaction/transactionSentRequest/delete", array("id"=>$data->id))',
                                'visible'=> '$data->status_document != "Approved" && $data->status_document != "Rejected" && Yii::app()->user->checkAccess("transaction.transactionSentRequest.update")',
                                'options' => array(
                                    'confirm' => 'Are you sure to delete this transaction?',
                                ),
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
