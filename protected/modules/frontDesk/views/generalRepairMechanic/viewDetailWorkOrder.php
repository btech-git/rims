<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Mechanic' => array('index'),
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
    $('.search-form form').submit(function(){
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
"); ?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Management General Repair Progress</h1>

        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Work Order' => array(
                        'content' => $this->renderPartial('_viewWorkOrder', array(
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
        <div id="aaa"></div>

        <div class="grid-view">
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Duration</th>
                        <th>Countdown</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registration->registrationServices as $registrationService): ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'service.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'hour')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'start')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'end')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'total_time')); ?></td>
                        <td><?php echo CHtml::button('test', array('onclick' => 'setInterval(function() { $("#aaa").html("abc"); }, 1000);')); ?></td>
                        <td><?php echo CHtml::submitButton('Start', array('name' => 'StartOrPauseTimesheet', 'confirm' => 'Are you sure you want to start?', 'class' => 'button cbuton success', 'onclick' => '$("#_FormSubmit_").val($(this).attr("name")); this.disabled = true')); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'registration-service-grid',
                'dataProvider' => $registrationServiceDataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
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
                        'value' => 'substr($data->service->name, 0, 50)',
                    ),
                    array(
                        'header' => 'Category',
                        'value' => '$data->service->serviceCategory->name'
                    ),
                    array(
                        'header' => 'Duration',
                        'value' => '$data->hour'
                    ),
                    array(
                        'type' => 'raw',
                        'cssClassExpression' => '"countdown"',
                        'header' => 'Countdown',
                        'value' => ''
                    ),
                    'start',
                    'end',
                    array(
                        'name' => 'total_time',
                        'value' => '$data->total_time',
                        'footer' => $registrationService->getTotal($_GET["registrationId"])
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
                        )),
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
                                'url' => 'Yii::app()->createUrl("frontDesk/generalRepairMechanic/workOrderStartService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-start'),
                                'click' => "js:function(e){
                                    e.preventDefault();
                                    var url = $(this).attr('href');
                                    //  do your post request here
                                    console.log(url);
                                    setInterval(function() {
                                        var distance = 3600000;
                                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                        $(this).closest('tr').find('td.countdown').html(hours + 'h '
  + minutes + 'm ' + seconds + 's ');
                                    }, 1000);
//                                    $.post(url,function(html){
//                                        $.fn.yiiGridView.update('registration-service-grid');
//                                    });
                                }",
                                'visible' => '$data->start==NULL or $data->start=="0000-00-00 00:00:00" or ($data->end != "0000-00-00 00:00:00" and $data->registrationTransaction->is_passed == 0)'
                            ),
                            'pause' => array(
                                'label' => 'Pause',
                                'url' => 'Yii::app()->createUrl("frontDesk/generalRepairMechanic/WorkOrderPauseService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-pause'),
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                    //  do your post request here
                                    console.log(url);
                                    $.post(url,function(html){
                                        $.fn.yiiGridView.update('registration-service-grid');
                                    });
                                    return false;
                                }",
                                'visible' => '(($data->start!=NULL and $data->start!="0000-00-00 00:00:00") and $data->resume >= $data->pause) and (($data->end==NULL or $data->end=="0000-00-00 00:00:00" and $data->resume >= $data->pause))'
                            ),
                            'resume' => array(
                                'label' => 'Resume',
                                'url' => 'Yii::app()->createUrl("frontDesk/generalRepairMechanic/workOrderResumeService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-resume'),
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                    //  do your post request here
                                    console.log(url);
                                    $.post(url,function(html){
                                        $.fn.yiiGridView.update('registration-service-grid');
                                    });
                                    return false;
                                }",
                                'visible' => '($data->end==NULL or $data->end=="0000-00-00 00:00:00") and $data->resume < $data->pause'
                            ),
                            'finish' => array(
                                'label' => 'Finish',
                                'url' => 'Yii::app()->createUrl("frontDesk/generalRepairMechanic/workOrderFinishService", array("serviceId"=>$data->service_id,"registrationId"=>' . $_GET["registrationId"] . '))',
                                'options' => array('class' => 'registration-service-finish'),
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                    //  do your post request here
                                    console.log(url);
                                    $.post(url,function(html){
                                        $.fn.yiiGridView.update('registration-service-grid');
                                    });
                                    return false;
                                }",
                                'visible' => '($data->start!=NULL and $data->start!="0000-00-00 00:00:00") and $data->resume >= $data->pause and $data->status != "Finished"'
                            ),
                        ),
                        'htmlOptions' => array('style' => 'width: 15%'),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>