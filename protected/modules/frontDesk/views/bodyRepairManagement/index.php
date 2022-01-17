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
        <h1>Body Repair Head Management</h1>
        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Waitlist' => array(
                        'content' => $this->renderPartial('_viewWaitlist', array(
                            'model' => $model,
                            'waitlistDataProvider' => $waitlistDataProvider,
                        ), true),
                    ),
                    'Bongkar' => array(
                        'content' => $this->renderPartial('_viewBongkar', array(
                            'queueBongkarDataProvider' => $queueBongkarDataProvider,
                            'assignBongkarDataProvider' => $assignBongkarDataProvider,
                            'progressBongkarDataProvider' => $progressBongkarDataProvider,
                            'qualityControlBongkarDataProvider' => $qualityControlBongkarDataProvider,
                            'finishedBongkarDataProvider' => $finishedBongkarDataProvider,
                        ), true ),
                    ),
                    'Sparepart' => array(
                        'content' => $this->renderPartial('_viewSparepart', array(
                            'queueSparePartDataProvider' => $queueSparePartDataProvider,
                            'assignSparePartDataProvider' => $assignSparePartDataProvider,
                            'progressSparePartDataProvider' => $progressSparePartDataProvider,
                            'qualityControlSparePartDataProvider' => $qualityControlSparePartDataProvider,
                            'finishedSparePartDataProvider' => $finishedSparePartDataProvider,
                        ), true),
                    ),
                    'Ketok/Las' => array(
                        'content' => $this->renderPartial('_viewKetok', array(
                            'queueKetokDataProvider' => $queueKetokDataProvider,
                            'assignKetokDataProvider' => $assignKetokDataProvider,
                            'progressKetokDataProvider' => $progressKetokDataProvider,
                            'qualityControlKetokDataProvider' => $qualityControlKetokDataProvider,
                            'finishedKetokDataProvider' => $finishedKetokDataProvider,
                        ), true),
                    ),
                    'Dempul' => array(
                        'content' => $this->renderPartial('_viewDempul', array(
                            'queueDempulDataProvider' => $queueDempulDataProvider,
                            'assignDempulDataProvider' => $assignDempulDataProvider,
                            'progressDempulDataProvider' => $progressDempulDataProvider,
                            'qualityControlDempulDataProvider' => $qualityControlDempulDataProvider,
                            'finishedDempulDataProvider' => $finishedDempulDataProvider,
                        ), true),
                    ),
                    'Epoxy' => array(
                        'content' => $this->renderPartial('_viewEpoxy', array(
                            'queueEpoxyDataProvider' => $queueEpoxyDataProvider,
                            'assignEpoxyDataProvider' => $assignEpoxyDataProvider,
                            'progressEpoxyDataProvider' => $progressEpoxyDataProvider,
                            'qualityControlEpoxyDataProvider' => $qualityControlEpoxyDataProvider,
                            'finishedEpoxyDataProvider' => $finishedEpoxyDataProvider,
                        ), true),
                    ),
                    'Cat' => array(
                        'content' => $this->renderPartial('_viewCat', array(
                            'queueCatDataProvider' => $queueCatDataProvider,
                            'assignCatDataProvider' => $assignCatDataProvider,
                            'progressCatDataProvider' => $progressCatDataProvider,
                            'qualityControlCatDataProvider' => $qualityControlCatDataProvider,
                            'finishedCatDataProvider' => $finishedCatDataProvider,
                        ), true),
                    ),
                    'Pasang' => array(
                        'content' => $this->renderPartial('_viewPasang', array(
                            'queuePasangDataProvider' => $queuePasangDataProvider,
                            'assignPasangDataProvider' => $assignPasangDataProvider,
                            'progressPasangDataProvider' => $progressPasangDataProvider,
                            'qualityControlPasangDataProvider' => $qualityControlPasangDataProvider,
                            'finishedPasangDataProvider' => $finishedPasangDataProvider,
                        ), true),
                    ),
                    'Cuci' => array(
                        'content' => $this->renderPartial('_viewCuci', array(
                            'queueCuciDataProvider' => $queueCuciDataProvider,
                            'assignCuciDataProvider' => $assignCuciDataProvider,
                            'progressCuciDataProvider' => $progressCuciDataProvider,
                            'qualityControlCuciDataProvider' => $qualityControlCuciDataProvider,
                            'finishedCuciDataProvider' => $finishedCuciDataProvider,
                        ), true),
                    ),
                    'Poles' => array(
                        'content' => $this->renderPartial('_viewPoles', array(
                            'queuePolesDataProvider' => $queuePolesDataProvider,
                            'assignPolesDataProvider' => $assignPolesDataProvider,
                            'progressPolesDataProvider' => $progressPolesDataProvider,
                            'qualityControlPolesDataProvider' => $qualityControlPolesDataProvider,
                            'finishedPolesDataProvider' => $finishedPolesDataProvider,
                        ), true),
                    ),
                    'Finished' => array(
                        'content' => $this->renderPartial('_viewHistory', array(
                            'model' => $model,
                            'historyDataProvider' => $historyDataProvider,
                        ), true),
                    ),
                    'Available Mechanics' => array(
                        'content' => $this->renderPartial('_viewAvailableMechanic', array(
                            'employee' => $employee,
                            'employeeDataProvider' => $employeeDataProvider,
                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_assigned',
            )); ?>
            
            <?php /*$this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Waitlist' => array(
                        'content' => $this->renderPartial('_viewWaitlist', array(
                            'model' => $model,
                            'waitlistDataProvider' => $waitlistDataProvider,
                        ), true),
                    ),
                    'Service Queue' => array(
                        'content' => $this->renderPartial('_viewQueue', array(
                            'model' => $model,
                            'queueDataProvider' => $queueDataProvider,
                        ), true),
                    ),
                    'Assigned' => array(
                        'content' => $this->renderPartial('_viewAssigned', array(
                            'model' => $model,
                            'assignBongkarDataProvider' => $assignBongkarDataProvider,
                            'assignSparePartDataProvider' => $assignSparePartDataProvider,
                            'assignKetokDataProvider' => $assignKetokDataProvider,
                            'assignDempulDataProvider' => $assignDempulDataProvider,
                            'assignEpoxyDataProvider' => $assignEpoxyDataProvider,
                            'assignCatDataProvider' => $assignCatDataProvider,
                            'assignPasangDataProvider' => $assignPasangDataProvider,
                            'assignPolesDataProvider' => $assignPolesDataProvider,
                            'assignCuciDataProvider' => $assignCuciDataProvider,
                        ), true),
                    ),
                    'On-Progress' => array(
                        'content' => $this->renderPartial('_viewProgress', array(
                            'model' => $model,
                            'progressBongkarDataProvider' => $progressBongkarDataProvider,
                            'progressSparePartDataProvider' => $progressSparePartDataProvider,
//                            'progressKetokDataProvider' => $progressKetokDataProvider,
//                            'progressDempulDataProvider' => $progressDempulDataProvider,
//                            'progressEpoxyDataProvider' => $progressEpoxyDataProvider,
//                            'progressCatDataProvider' => $progressCatDataProvider,
//                            'progressPasangDataProvider' => $progressPasangDataProvider,
//                            'progressPolesDataProvider' => $progressPolesDataProvider,
//                            'progressCuciDataProvider' => $progressCuciDataProvider,
//                                'waitlistDataProvider' => $waitlistDataProvider,
                        ), true),
                    ),
                    'Ready to QC' => array(
                        'content' => $this->renderPartial('_viewQualityControl', array(
                            'model' => $model,
                            'qualityControlBongkarDataProvider' => $qualityControlBongkarDataProvider,
                            'qualityControlSparePartDataProvider' => $qualityControlSparePartDataProvider,
                        ), true),
                    ),
                    'Finished' => array(
                        'content' => $this->renderPartial('_viewFinished', array(
                            'model' => $model,
                            'finishedBongkarDataProvider' => $finishedBongkarDataProvider,
                            'finishedSparePartDataProvider' => $finishedSparePartDataProvider,
                        ), true),
                    ),
                    'Available Mechanics' => array(
                        'content' => $this->renderPartial('_viewAvailableMechanic', array(
                            'employee' => $employee,
                            'employeeDataProvider' => $employeeDataProvider,
                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_tab',
            ));*/ ?>
        </div>
    </div>
</div>

<!--Registration Service Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
<?php $this->endWidget(); ?>