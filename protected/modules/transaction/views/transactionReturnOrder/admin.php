<?php
/* @var $this TransactionReturnOrderController */
/* @var $model TransactionReturnOrder */

$this->breadcrumbs = array(
    'Transaction Return Orders' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TransactionReturnOrder', 'url' => array('index')),
    array('label' => 'Create TransactionReturnOrder', 'url' => array('create')),
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

    $('.search-form form').submit(function(){
        $('#transaction-return-order-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        
        return false;
    });
");
?>


<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Return Order', Yii::app()->baseUrl . '/transaction/transactionReturnOrder/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("purchaseReturnCreate"))) ?>

        <h1>Manage Transaction Return Beli</h1>
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
                    )); ?>
                </div><!-- search-form -->				
            </div>
        </div>

        <div class="grid-view">

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'transaction-return-order-grid',
                'dataProvider' => $dataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    //'id',
                    array(
                        'name' => 'return_order_no', 
                        'value' => 'CHtml::link($data->return_order_no, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    'return_order_date',
                    // 'receive_item_id',
                    array(
                        'name' => 'receive_item_no',
                        'value' => '$data->receiveItem->receive_item_no'
                    ),
                    // 'recipient_id',
                    // 'recipient_branch_id',
                    array(
                        'name' => 'recipient_id',
                        'value' => '$data->user->username'
                    ),
                    array(
                        'name' => 'branch_name',
                        'filter' => CHtml::activeDropDownList($model, 'recipient_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->recipientBranch->name'
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit}',
                        'buttons' => array(
                            'edit' => array(
                                'label' => 'edit',
                                'url' => 'Yii::app()->createUrl("transaction/transactionReturnOrder/update", array("id"=>$data->id))',
//                                'visible' => 'count(MovementOutHeader::model()->findAllByAttributes(array("return_order_id"=>$data->id))) == 0 && Yii::app()->user->checkAccess("purchaseReturnEdit") && $data->status != "Rejected"',
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>