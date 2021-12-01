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
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Waitlist' => array(
                        'content' => $this->renderPartial(
                            '_viewWaitlist',
                            array(
                                'plateNumber' => $plateNumber,
                                'workOrderNumber' => $workOrderNumber,
                                'status' => $status,
                                'branchId' => $branchId,
                                'registrationService' => $registrationService,
                                'registrationServiceDataProvider' => $registrationServiceDataProvider,
                            ), true
                        ),
                    ),
                    'Service Queue' => array(
                        'content' => $this->renderPartial('_viewPlanningList', array(
                            'registrationPlanningDataProvider' => $registrationPlanningDataProvider,
                        ), true),
                    ),
                    'Assigned' => array(
                        'content' => $this->renderPartial('_viewQueueList', array(
                            'registrationServiceQueueDataProvider' => $registrationServiceQueueDataProvider,
                        ), true),
                    ),
                    'On-Progress' => array(
                        'content' => $this->renderPartial('_viewProgress', array(
                            'registrationServiceProgressDataProvider' => $registrationServiceProgressDataProvider,
                        ), true),
                    ),
                    'Ready to QC' => array(
                        'content' => $this->renderPartial('_viewCheckList', array(
                            'registrationServiceQualityControlDataProvider' => $registrationServiceQualityControlDataProvider,
                        ), true),
                    ),
                    'Finished' => array(
                        'content' => $this->renderPartial('_viewHistory', array(
                            'registrationService' => $registrationService,
                            'registrationServiceHistoryDataProvider' => $registrationServiceHistoryDataProvider,
                            'branchId' => $branchId,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                        ), true),
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
    </div>
</div>
