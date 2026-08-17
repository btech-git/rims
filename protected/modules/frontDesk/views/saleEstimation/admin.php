<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */

$this->breadcrumbs = array(
    'Registration Transactions' => array('admin'),
    'Manage',
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
    $('#sale-estimation-grid').yiiGridView('update', {
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
                <?php echo CHtml::link('Add', array("create"), array(
                    'class' => 'button success right', 
                    'style' => 'margin-right:10px',
                    'target' =>'_blank',
                )); ?>
                <div class="clearfix page-action">
                    <h2>Manage Estimasi Penjualan</h2>
                </div>

                <div class="search-bar">
                    <div class="clearfix button-bar">
                        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					
                        <div class="clearfix"></div>
                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search', array(
                                'model' => $model,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'plateNumber' => $plateNumber,
                                'customerName' => $customerName,
                            )); ?>
                        </div><!-- search-form -->
                    </div>
                </div>

                <div class="grid-view" id="sale-estimation-grid">
                    <?php $this->renderPartial('_saleEstimationDataTable', array(
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'customerName' => $customerName,
                        'plateNumber' => $plateNumber,
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
