<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Idle Management' => array('indexMechanic'),
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
    $('#registration-service-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

	/*$('#registration-service-grid a.registration-service-start').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});

	$('#registration-service-grid a.registration-service-finish').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});*/
");
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <?php echo CHtml::link('Registration', array('/frontDesk/generalRepairRegistration/view', 'id'=>$registration->id), array('target' => '_blank', 'class'=>'button primary right')); ?>
    <span style="float: right">&nbsp;&nbsp;&nbsp;</span>
    <?php echo CHtml::link('Inspection', array('/frontDesk/vehicleInspection/create', 'vehicleId'=>$registration->vehicle_id, 'wonumber' => $registration->work_order_number), array('target' => '_blank', 'class'=>'button success right')); ?>
    <div class="clearfix page-action">
        <h1>Management General Repair Progress</h1>

        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Work Order' => array(
                        'content' => $this->renderPartial('_viewWorkOrderMechanic', array(
                            'registration' => $registration,
                            'memo' => $memo,
                        ), true),
                    ),
                    'Products' => array(
                        'content' => $this->renderPartial('_viewProduct', array(
                            'registration' => $registration,
                        ), true),
                    ),
                    'Quick Service' => array(
                        'content' => $this->renderPartial('_viewQuickService', array(
                            'registration' => $registration,
                            'registrationQuickService' => $registrationQuickService,
                            'registrationQuickServiceDataProvider' => $registrationQuickServiceDataProvider,
                        ), true),
                    ),
                    'Service History' => array(
                        'content' => $this->renderPartial('_viewServiceHistory', array(
                            'registration' => $registration,
                            'vehicle' => $vehicle,
                            'registrationHistories' => $registrationHistories,
                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_tab',
            ));
            ?>
        </div>

        <br />

        <div>
            <h3>List Memo</h3>
            <table>
                <?php foreach ($registration->registrationMemos as $i => $detail): ?>
                    <tr>
                        <td style="width: 5%"><?php echo CHtml::encode($i + 1); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'date_time')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'user.username')); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>

        <br />

        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'registration-service-grid',
                'dataProvider' => $registrationServiceDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:hidden ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'header' => "No",
                        'value' => '$this->grid->dataProvider->pagination->offset + $row+1',
                    ),
                    array(
                        'name' => 'service_id',
                        'value' => '$data->service->name'
                    ),
                    array(
                        'header' => 'Category',
                        'value' => '$data->service->serviceCategory->name'
                    ),
                    array(
                        'header' => 'duration',
                        'value' => '$data->hour'
                    ),
                    'start',
                    'end',
                    array(
                        'name' => 'total_time',
                        'value' => '$data->total_time',
                        'footer' => ' ' . $registrationService->getTotal($_GET["registrationId"])
                    ),
                    array(
                        'header' => 'Service Status',
                        'value' => '$data->status',
                        'type' => 'raw',
                        'filter' => CHtml::dropDownList('RegistrationService[status]', $registrationService->status, array(
                            '' => 'All',
                            'Pending' => 'Pending',
                            'Available' => 'Available',
                            'On Progress' => 'On Progress',
                            'Finished' => 'Finished'
                                )
                        ),
                    ),
                    array(
                        'header' => 'Mechanic',
                        'value' => '$data->startMechanicName',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{start} {pause} {resume} {finish}',
                        'buttons' => array(
                            'start' => array(
                                'label' => 'Start',
                                'url' => 'Yii::app()->createUrl("frontDesk/idleManagement/workOrderStartService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-start'),
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                //  do your post request here
                                //console.log(url);
                                    $.post(url,function(html){
                                        $.fn.yiiGridView.update('registration-service-grid');
                                    });
                                    return false;
                                }",
                                'visible' => '$data->start==NULL or $data->start=="0000-00-00 00:00:00" or ($data->end != "0000-00-00 00:00:00" and $data->registrationTransaction->is_passed == 0)'
                            ),
                            'pause' => array(
                                'label' => 'Pause',
                                'url' => 'Yii::app()->createUrl("frontDesk/idleManagement/WorkOrderPauseService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-pause'),
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                //  do your post request here
                                //console.log(url);
                                    $.post(url,function(html){
                                        $.fn.yiiGridView.update('registration-service-grid');
                                    });
                                    return false;
                                }",
                                'visible' => '(($data->start!=NULL and $data->start!="0000-00-00 00:00:00") and $data->resume >= $data->pause) and (($data->end==NULL or $data->end=="0000-00-00 00:00:00" and $data->resume >= $data->pause))'
                            ),
                            'resume' => array(
                                'label' => 'Resume',
                                'url' => 'Yii::app()->createUrl("frontDesk/idleManagement/workOrderResumeService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-resume'),
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                //  do your post request here
                                //console.log(url);
                                    $.post(url,function(html){
                                        $.fn.yiiGridView.update('registration-service-grid');
                                    });
                                    return false;
                                }",
                                'visible' => '($data->end==NULL or $data->end=="0000-00-00 00:00:00") and $data->resume < $data->pause'
                            ),
                            'finish' => array(
                                'label' => 'Finish',
                                'url' => 'Yii::app()->createUrl("frontDesk/idleManagement/workOrderFinishService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-finish'),
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                //  do your post request here
                                //console.log(url);
                                    $.post(url,function(html){
                                        $.fn.yiiGridView.update('registration-service-grid');
                                    });
                                    return false;
                                }",
                                'visible' => '($data->start!=NULL and $data->start!="0000-00-00 00:00:00") and $data->resume >= $data->pause and $data->status != "Finished"'
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>