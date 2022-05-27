<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */

$this->breadcrumbs = array(
    'Movement Out Headers' => array('admin'),
    'Manage',
);

/* $this->menu=array(
  array('label'=>'List MovementOutHeader', 'url'=>array('index')),
  array('label'=>'Create MovementOutHeader', 'url'=>array('create')),
  ); */

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
    $('#movement-out-header-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <h2>Manage Movement Out</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					
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
                    'id' => 'movement-out-header-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => null,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'movement_out_no',
                            'value' => 'CHTml::link($data->movement_out_no, array("view", "id"=>$data->id))', 'type' => 'raw'
                        ),
                        'date_posting',
                        'status',
                        array(
                            'name' => 'branch_id',
                            'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value' => '$data->branch->name'
                        ),
                        array(
                            'name' => 'registration_transaction_number',
                            'value' => '(!empty($data->registrationTransaction->transaction_number) ? $data->registrationTransaction->transaction_number : "")'
                        ),
                        array(
                            'name' => 'delivery_order_number',
                            'value' => '(!empty($data->deliveryOrder->delivery_order_no)?$data->deliveryOrder->delivery_order_no:"")'
                        ),
                        array(
                            'name' => 'return_order_number',
                            'value' => '(!empty($data->returnOrder->return_order_no)?$data->returnOrder->return_order_no:"")'
                        ),
                        array(
                            'name' => 'user_id',
                            'value' => '$data->user->username',
                        ),
                        'date_created',
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{edit}',
                            'buttons' => array(
                                'edit' => array(
                                    'label' => 'edit',
                                    'url' => 'Yii::app()->createUrl("transaction/movementOutHeader/update", array("id"=>$data->id))',
                                    'visible' => '($data->status != "Approved") && $data->status != "Rejected" && ($data->status != "Delivered") && ($data->status != "Finished" ) && Yii::app()->user->checkAccess("movementOutEdit")',
                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>
            
            <fieldset>
                <legend>Pending Orders</legend>
                <div>
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Delivery Order' => array(
                                'content' => $this->renderPartial('_viewDelivery', array(
                                    'deliveryOrder' => $deliveryOrder,
                                    'deliveryOrderDataProvider' => $deliveryOrderDataProvider,
                                ), true)
                            ),
                            'Return Pembelian' => array(
                                'content' => $this->renderPartial('_viewReturn', array(
                                    'returnOrder' => $returnOrder,
                                    'returnOrderDataProvider' => $returnOrderDataProvider,
                                ), true)
                            ),
                            'Retail Sales' => array(
                                'content' => $this->renderPartial('_viewSales', array(
                                    'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
                                    'registrationTransaction' => $registrationTransaction,
                                ), true)
                            ),
                            'Materail Request' => array(
                                'content' => $this->renderPartial('_viewRequest', array(
                                    'materialRequestDataProvider' => $materialRequestDataProvider,
                                    'materialRequest' => $materialRequest,
                                ), true)
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>
                </div>
            </fieldset>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
