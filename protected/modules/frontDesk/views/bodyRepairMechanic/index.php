<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Manage',
);

$this->menu = array(
    array('label' => 'List RegistrationTransaction', 'url' => array('admin')),
    array('label' => 'Create RegistrationTransaction', 'url' => array('index')),
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
    
    $('.search-form form').submit(function() {
        $('#registration-transaction-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });

    $('#info').click(function(){
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
        <h1>Mechanic Body Repair Work Order</h1>

        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Waitlist' => array(
                        'content' => $this->renderPartial('_viewWaitlist', array(
                            'plateNumber' => $plateNumber,
                            'workOrderNumber' => $workOrderNumber,
                            'model' => $model,
                            'modelDataProvider' => $modelDataProvider,
                        ), true),
                    ),
                    'Service Queue' => array(
                        'content' => $this->renderPartial('_viewQueue', array(
                            'registrationBodyRepairDetail' => $registrationBodyRepairDetail,
                            'queueDataProvider' => $queueDataProvider,
                        ), true),
                    ),
                    'Assigned' => array(
                        'content' => $this->renderPartial('_viewMechanicAssignment', array(
                            'registrationBodyRepairDetail' => $registrationBodyRepairDetail,
                            'registrationAssignmentDataProvider' => $registrationAssignmentDataProvider,
                        ), true),
                    ),
                    'On-Progress' => array(
                        'content' => $this->renderPartial('_viewMechanicProgress', array(
                            'registrationBodyRepairDetail' => $registrationBodyRepairDetail,
                            'registrationProgressDataProvider' => $registrationProgressDataProvider,
                        ), true),
                    ),
                    'Ready to QC' => array(
                        'content' => $this->renderPartial('_viewQualityControl', array(
                            'registrationBodyRepairDetail' => $registrationBodyRepairDetail,
                            'qualityControlDataProvider' => $qualityControlDataProvider,
                        ), true),
                    ),
                    'Finished' => array(
                        'content' => $this->renderPartial('_viewHistory', array(
                            'registrationHistoryDataProvider' => $registrationHistoryDataProvider,
                            'branchId' => $branchId,
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