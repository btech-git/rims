<?php
/* @var $this ConsignmentOutHeaderController */
/* @var $model ConsignmentOutHeader */

$this->breadcrumbs = array(
    'Consignment Out Headers' => array('admin'),
    'Manage',
);

/* $this->menu=array(
  array('label'=>'List ConsignmentOutHeader', 'url'=>array('index')),
  array('label'=>'Create ConsignmentOutHeader', 'url'=>array('create')),
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
    $('#consignment-out-header-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<!--<h1>Manage Consignment Out Headers</h1>-->


<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <?php echo CHtml::link('<span class="fa fa-plus"></span>New Consignment Out', Yii::app()->baseUrl . '/transaction/consignmentOutHeader/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("consignmentOutCreate"))) ?>

                <h2>Manage Consignment Out Headers</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <!--<div class="left clearfix bulk-action">
                    <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                    <input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
                    <input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
            </div>-->
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
                    'id' => 'consignment-out-header-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => $model,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        //'id',
                        array(
                            'name' => 'consignment_out_no', 
                            'value' => 'CHTml::link($data->consignment_out_no, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        //'consignment_out_no',
                        'date_posting',
                        'status',
                        // 'customer_id',
                        'delivery_date',
                        array(
                            'name' => 'customer_name',
                            'value' => '$data->customer->name',
                        ),
                        array(
                            'name' => 'branch_id',
                            'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value' => '$data->branch->name',
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '$data->totalRemainingQuantityDelivered',
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
                                    'url' => 'Yii::app()->createUrl("transaction/consignmentOutHeader/update", array("id"=>$data->id))',
                                    'visible' => '$data->status != "Approved" && $data->status != "Rejected" && Yii::app()->user->checkAccess("consignmentOutEdit")'
                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
