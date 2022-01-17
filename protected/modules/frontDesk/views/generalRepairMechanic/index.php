<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
    'Manage',
);

$this->menu=array(
    array('label'=>'List RegistrationTransaction', 'url'=>array('admin')),
    array('label'=>'Create RegistrationTransaction', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function() {
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
        $('#registration-transaction-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });

    $('#info').click(function() {
        href = $(this).attr('href')
        $.ajax({
            type: 'POST',
            url: href,
            data: $('form').serialize(),
            success: function(html) {
                $('#info-dialog').dialog('open');
                $('#info_div').html(html);
            },
        });
    });
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Mechanic General Repair Work Order</h1>
        <div>
            <?php $serviceTabs['Waiting List'] = $this->renderPartial('_viewWaitlist', array(
                'model' => $model,
                'waitlistDataProvider' => $waitlistDataProvider,
            ), true); ?>
            
            <?php $serviceTypes = ServiceType::model()->findAll(array('condition' => 'id <> 2')); ?>
            <?php foreach ($serviceTypes as $i => $serviceType): ?>
                <?php $serviceTabs[$serviceType->name] = $this->renderPartial('_serviceTypeTable', array(
                    'registrationService' => $registrationService,
                    'serviceType' => $serviceType,
                    'registrationServiceManagementQueue' => $registrationServiceManagementQueue,
                    'registrationServiceManagementAssigned' => $registrationServiceManagementAssigned,
                    'registrationServiceManagementProgress' => $registrationServiceManagementProgress,
                    'registrationServiceManagementControl' => $registrationServiceManagementControl,
                    'registrationServiceManagementFinished' => $registrationServiceManagementFinished,
                    'serviceNames' => $serviceNames,
                ), true); ?>
            <?php endforeach; ?>
            
            <?php /*$serviceTabs['Finished'] = $this->renderPartial('_viewFinishedList', array(
                'model' => $model,
                'historyDataProvider' => $historyDataProvider,
            ), true);*/ ?>
            
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => $serviceTabs,
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_tab',
            )); ?>
        </div>
    </div>
</div>
