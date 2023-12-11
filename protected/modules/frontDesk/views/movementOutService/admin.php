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
                <h2>Manage Pengeluaran Bahan Pemakaian</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                            'plateNumber' => $plateNumber,
                            'carMake' => $carMake,
                            'carModel' => $carModel,
                            'customerName' => $customerName,
                            'workOrderNumber' => $workOrderNumber,
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
                            'value' => 'CHtml::link($data->movement_out_no, array("/transaction/movementOutHeader/view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'date_posting',
//                        'status',
                        array(
                            'name' => 'branch_id',
                            'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value' => '$data->branch->code',
                        ),
                        array(
                            'header' => 'Registration #',
                            'name' => 'registration_transaction_number',
                            'value' => '(!empty($data->registrationTransaction->transaction_number) ? $data->registrationTransaction->transaction_number : "")'
                        ),
                        array('name' => 'plate_number', 'value' => '$data->registrationTransaction->vehicle->plate_number'),
                        array(
                            'header' => 'Car Make',
                            'name' => 'car_make_code',
                            'value' => 'empty($data->registrationTransaction->vehicle->carMake) ? "" : $data->registrationTransaction->vehicle->carMake->name'
                        ),
                        array(
                            'header'=>'Car Model',
                            'name'=>'car_model_code',
                            'value'=>'$data->registrationTransaction->vehicle->carModel->name'
                        ),
                        array(
                            'header' => 'Customer Name',
                            'name' => 'customer_name',
                            'value' => '$data->registrationTransaction->customer->name',
                        ),
                        'registrationTransaction.work_order_number',
                        array(
                            'name' => 'user_id',
                            'value' => '$data->user->username',
                        ),
//                        array(
//                            'class' => 'CButtonColumn',
//                            'template' => '{edit}',
//                            'buttons' => array(
//                                'edit' => array(
//                                    'label' => 'edit',
//                                    'url' => 'Yii::app()->createUrl("frontDesk/movementOutService/update", array("id"=>$data->id))',
//                                    'visible' => '($data->status != "Approved") && $data->status != "Rejected" && ($data->status != "Delivered") && ($data->status != "Finished" ) && Yii::app()->user->checkAccess("movementOutEdit")',
//                                ),
//                            ),
//                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
