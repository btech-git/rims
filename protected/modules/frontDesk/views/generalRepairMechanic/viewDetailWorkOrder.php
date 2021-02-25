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

$str = '';
$currentTime = strtotime(date(DATE_ATOM));
foreach ($registration->registrationServices as $registrationService) {
    if ($registrationService->start !== null && $registrationService->end === null) {
        $str .= "setInterval(function() {
            var timeDiffSelector = $('table div#time_diff_" . $registrationService->id . "');
            var now = parseInt(Date.now() / 1000);
            var expected = " . (strtotime($registrationService->start) + $registrationService->hour * 3600) . ";
            var diff = timeDiffSelector.html();
            if (diff == '') {
                diff = " . $currentTime . " - now;
                timeDiffSelector.html(diff);
            }
            diff = parseInt(diff);
            var distance = expected - now + diff;
            if (distance < 0) {
                distance = 0;
            }
            var hours = Math.floor(distance / 3600);
            var minutes = Math.floor(distance / 60 % 60);
            var seconds = Math.floor(distance % 60);
            $('table td#countdown_" . $registrationService->id . "').html(hours + 'h ' + minutes + 'm ' + seconds + 's ');
        }, 1000);";
    }
}

Yii::app()->clientScript->registerScript('search', $str . "
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
                        <th>Start</th>
                        <th>End</th>
                        <th>Total Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $currentTimestamp = strtotime(date(DATE_ATOM)); ?>
                    <?php foreach ($registration->registrationServices as $registrationService): ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'service.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'hour')); ?></td>
                        <td id="countdown_<?php echo $registrationService->id; ?>"></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'start')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'end')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'formattedTotalTime')); ?></td>
                        <td>
                            <div id="time_diff_<?php echo $registrationService->id; ?>" style="display: none"></div>
                            <div class="detail_id" style="display: none">
                                <?php echo CHtml::encode(CHtml::value($registrationService, 'id')); ?>
                            </div>
                            <?php if ($registrationService->start === null && $registrationService->end === null): ?>
                                <?php echo CHtml::submitButton('Start', array('name' => 'StartService', 'confirm' => 'Are you sure you want to start?', 'class' => 'button cbuton success', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text());')); ?>
                                <?php //echo CHtml::submitButton('Start', array('name' => 'StartService', 'confirm' => 'Are you sure you want to start?', 'class' => 'button cbuton success', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text()); $("#_FormSubmit_").val($(this).attr("name")); this.disabled = true')); ?>
                            <?php elseif ($registrationService->start !== null && $registrationService->end === null && $registrationService->pause !== null && ($registrationService->resume === null || $registrationService->resume < $registrationService->pause)): ?>
                                <?php echo CHtml::submitButton('Resume', array('name' => 'ResumeService', 'confirm' => 'Are you sure you want to resume?', 'class' => 'button cbuton success', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text());')); ?>
                                <?php //echo CHtml::submitButton('Resume', array('name' => 'ResumeService', 'confirm' => 'Are you sure you want to resume?', 'class' => 'button cbuton success', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text()); $("#_FormSubmit_").val($(this).attr("name")); this.disabled = true')); ?>
                            <?php elseif ($registrationService->start !== null && $registrationService->end === null && ($registrationService->resume === null && $registrationService->pause === null || $registrationService->resume > $registrationService->pause)): ?>
                                <?php echo CHtml::submitButton('Pause', array('name' => 'PauseService', 'confirm' => 'Are you sure you want to pause?', 'class' => 'button cbuton warning', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text());')); ?>
                                <?php echo CHtml::submitButton('Finish', array('name' => 'FinishService', 'confirm' => 'Are you sure you want to finish?', 'class' => 'button cbuton alert', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text());')); ?>
                                <?php //echo CHtml::submitButton('Pause', array('name' => 'PauseService', 'confirm' => 'Are you sure you want to pause?', 'class' => 'button cbuton warning', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text()); $("#_FormSubmit_").val($(this).attr("name")); this.disabled = true')); ?>
                                <?php //echo CHtml::submitButton('Finish', array('name' => 'FinishService', 'confirm' => 'Are you sure you want to finish?', 'class' => 'button cbuton alert', 'onclick' => '$("#DetailId").val($(this).parent().find("div.detail_id").text()); $("#_FormSubmit_").val($(this).attr("name")); this.disabled = true')); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo CHtml::hiddenField('DetailId', ''); ?>
<?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
<?php echo CHtml::endForm(); ?>