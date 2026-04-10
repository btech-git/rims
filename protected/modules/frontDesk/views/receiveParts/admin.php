<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */

$this->breadcrumbs = array(
    'Penerimaan Parts Supply' => array('admin'),
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
    $('#receive-parts-header-grid').yiiGridView('update', {
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
                <?php echo CHtml::link('<span class="fa fa-plus"></span>New', Yii::app()->baseUrl . '/frontDesk/receiveParts/registrationTransactionList', array(
                    'class' => 'button success right', 
//                    'visible' => Yii::app()->user->checkAccess("maintenanceRequestCreate")
                )); ?>
                <h2>Manage Penerimaan Parts Supply</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php /*$this->renderPartial('_search', array(
                            'model' => $model,
                            'plateNumber' => $plateNumber,
                            'carMake' => $carMake,
                            'carModel' => $carModel,
                            'customerName' => $customerName,
                            'workOrderNumber' => $workOrderNumber,
                        ));*/ ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'receive-parts-header-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => null,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'transaction_number',
                            'value' => 'CHtml::link($data->transaction_number, array("/frontDesk/receiveParts/view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'transaction_date',
                        array(
                            'header' => 'Registration #',
                            'value' => '$data->registrationTransaction->transaction_number'
                        ),
                        'transaction_type',
                        'supplier_delivery_number',
                        array(
                            'header' => 'Asuransi',
                            'name' => 'insurance_company_id',
                            'value' => 'CHtml::encode(CHtml::value($data, "insuranceCompany.name"))',
                        ),
                        array(
                            'header' => 'Customer Name',
                            'value' => 'CHtml::encode(CHtml::value($data, "registrationTransaction.customer.name"))',
                        ),
                        array(
                            'header' => 'Plate #', 
                            'value' => 'CHtml::encode(CHtml::value($data, "registrationTransaction.vehicle.plate_number"))',
                        ),
                        array(
                            'header' => 'Vehicle',
                            'value' => 'CHtml::encode(CHtml::value($data, "registrationTransaction.vehicle.carMakeModelSubCombination"))',
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
