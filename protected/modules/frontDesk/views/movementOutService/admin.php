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
                <h2>Manage Pengeluaran Bahan</h2>
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
                        array(
                            'header' => 'Permintaan Bahan #',
                            'value' => '!empty($data->material_request_header_id) ? $data->materialRequestHeader->transaction_number : ""'
                        ),
                        array(
                            'header' => 'WO #',
                            'value' => 'CHtml::encode(CHtml::value($data, "materialRequestHeader.registrationTransaction.work_order_number"))'
                        ),
//                        array(
//                            'header' => 'Customer Name',
//                            'value' => '!empty($data->material_request_header_id) ? $data->materialRequestHeader->registrationTransaction->customer->name : ""',
//                        ),
//                        array(
//                            'header' => 'Vehicle', 
//                            'value' => '!empty($data->material_request_header_id) ? $data->materialRequestHeader->registrationTransaction->vehicle->plate_number : ""'
//                        ),
//                        array(
//                            'header' => 'Car Make',
//                            'value' => '!empty($data->material_request_header_id) ? $data->materialRequestHeader->registrationTransaction->vehicle->carMake->name : ""'
//                        ),
//                        array(
//                            'header'=>'Car Model',
//                            'value'=>'!empty($data->material_request_header_id) ? $data->materialRequestHeader->registrationTransaction->vehicle->carModel->name : ""'
//                        ),
                        array(
                            'name' => 'user_id',
                            'value' => 'empty($data->user_id) ? "" : $data->user->username',
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
