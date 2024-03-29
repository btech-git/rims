<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List RegistrationTransaction', 'url' => array('admin')),
    array('label' => 'Create RegistrationTransaction', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });

    $('.search-form form').submit(function(){
        $('#registration-transaction-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Manage General Repair Registrations</h1>
<!--        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
            </div>
        </div>
        <div class="clearfix"></div>-->
        <div class="search-form" style="display:none">
            <?php /*$this->renderPartial('_search', array(
                'model' => $model,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'plateNumber' => $plateNumber,
                'carMake' => $carMake,
                'carModel' => $carModel,
                'customerName' => $customerName,
            ));*/ ?>
        </div><!-- search-form -->
    </div>
    <div class="clearfix"></div>
</div>

<br />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'registration-transaction-grid',
        'dataProvider' => $dataProvider,
        'filter' => null,
        'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'header' => '#',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1', //  row is zero based
            ),
            array(
                'name' => 'employee_id',
                'value' => '$data->employee->name',
                'filter' => false, // Set the filter to false when date range searching
            ),
            array(
                'name' => 'position_id', 
                'value' => '$data->position->name'
            ),
            array(
                'name' => 'level_id',
                'value' => '$data->level->name'
            ),
            array(
                'name' => 'division_id',
                'value' => '$data->division->name'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{views}',
                'buttons' => array(
                    'views' => array(
                        'label' => 'view',
                        'url' => 'Yii::app()->createUrl("frontDesk/mechanicPerformance/view", array("employeeId"=>$data->employee_id))',
//                        'visible' => 'Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")'
                    ),
                ),
            ),
        ),
    )); ?>
</div>