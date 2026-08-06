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
        $('#partial-delivery-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
"); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', Yii::app()->baseUrl . '/transaction/transferRequest/admin', array(
            'class' => 'button cbutton right',
//            'visible' => Yii::app()->user->checkAccess("transferRequestEdit")
        )); ?>
        
        <h1>Transfer Request Partial Delivery</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_searchPartial',array(
                        'model' => $model,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div><!-- search-form -->				
            </div>
         </div>

        <hr />
        
        <div>
            <?php echo CHtml::beginForm(array(''), 'get'); ?>
            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
                  
        <br />
        
         <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'partial-delivery-grid',
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
                        'value'=>'CHtml::link($data->transfer_request_no, array("view", "id"=>$data->id))', 
                        'type'=>'raw'
                    ),
                    'transfer_request_date',
                    'transfer_request_time',
                    array(
                        'header' => 'Umur (hari)',
                        'value' => '$data->transactionDateInterval',
                    ),
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
                ),
            )); ?>
        </div>
    </div>
</div>