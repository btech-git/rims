<?php
$this->breadcrumbs=array(
    'Transaction Transfer Requests'=>array('admin'),
    'Manage',
); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Transfer Request Partial Delivery</h1>
         <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'partial-transfer-request-grid',
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