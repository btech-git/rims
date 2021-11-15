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
                    'On-Progress' => array(
                        'content' => $this->renderPartial(
                            '_viewProgress',
                            array(
                                'registrationServiceProgressDataProvider' => $registrationServiceProgressDataProvider,
                            ), true
                        ),
                    ),
                    'History' => array(
                        'content' => $this->renderPartial(
                            '_viewHistory',
                            array(
                                'registrationService' => $registrationService,
                                'registrationServiceHistoryDataProvider' => $registrationServiceHistoryDataProvider,
                                'branchId' => $branchId,
                            ), true
                        ),
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

<!--Registration Service Dialog -->
<?php /*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'registration-service-dialog',
    'options'=>array(
        'title'=>'Registration Service',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'1200',
        'close'=>'js:function(){ $.fn.yiiGridView.update("registration-transaction-grid"); }',
    ),
)); ?>

<div id="registration_service_div"></div>
<?php $this->endWidget(); ?>

<!--Update Status Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'update-status-dialog',
    'options'=>array(
        'title'=>'Update Status',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'1200',
        'close'=>'js:function(){ $.fn.yiiGridView.update("registration-transaction-grid"); }',
    ),
)); ?>

<div id="update_status_div"></div>
<?php $this->endWidget(); ?>

<!--Level Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'info-dialog',
    'options'=>array(
    	'title'=>'Info',
    	'autoOpen'=>false,
    	'modal'=>true,
    	'width'=>'800',
    ),
)); ?>

<div id="info_div"></div>
<?php $this->endWidget();*/ ?>