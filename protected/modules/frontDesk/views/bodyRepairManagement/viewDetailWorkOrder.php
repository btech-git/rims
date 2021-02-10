<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Idle Management'=>array('indexMechanic'),
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
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
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
");
?>

<?php echo CHtml::beginForm(); ?>
    <div id="maincontent">
        <div class="clearfix page-action">
            <h1>Manage Body Repair Progress</h1>

            <div>
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Work Order' => array(
                            'content' => $this->renderPartial(
                                '_viewWorkOrderMechanic',
                                array(
                                    'registration' => $registration,
                                    'memo' => $memo,
                                ), true
                            ),
                        ),
                        'Products' => array(
                            'content' => $this->renderPartial(
                                '_viewProduct',
                                array(
                                    'registration' => $registration,
                                ), true
                            ),
                        ),
                        'Services' => array(
                            'content' => $this->renderPartial(
                                '_viewService',
                                array(
                                    'registration' => $registration,
                                    'registrationService' => $registrationService,
                                    'registrationServiceDataProvider' => $registrationServiceDataProvider,
                                ), true
                            ),
                        ),
                        'Damages' => array(
                            'content' => $this->renderPartial(
                                '_viewDamage',
                                array(
                                    'registration' => $registration,
                                    'registrationDamage' => $registrationDamage,
                                    'registrationDamageDataProvider' => $registrationDamageDataProvider,
                                ), true
                            ),
                        ),
                        'Service History' => array(
                            'content' => $this->renderPartial(
                                '_viewServiceHistory',
                                array(
                                    'registration' => $registration,
                                    'vehicle' => $vehicle,
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

            <br /><br />

            <div>
                <table>
                    <caption>Service</caption>
                    <thead>
                        <tr style="background-color: lightblue">
                            <th style="text-align: center">No.</th>
                            <th style="text-align: center">Process</th>
                            <th style="text-align: center">Start</th>
                            <th style="text-align: center">Finish</th>
                            <th style="text-align: center">Total Time</th>
                            <th style="text-align: center">Mechanic</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrationBodyRepairDetails as $i => $registrationBodyRepairDetail): ?>
                            <?php $isDetailRunning = $bodyRepairManagement->runningDetail === null ? false : $registrationBodyRepairDetail->id === $bodyRepairManagement->runningDetail->id; ?>
                            <tr style="<?php echo $isDetailRunning ? 'font-weight: bold; background-color: greenyellow' : ''; ?>">
                                <td style="text-align: center"><?php echo $i + 1; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'service_name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'start_date_time')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'finish_date_time')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'totalTimeFormatted')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'mechanic.name')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if ($bodyRepairManagement->runningDetail !== null): ?>
                    <table>
                        <caption>Timesheet</caption>
                        <thead>
                            <tr style="background-color: orange">
                                <th style="text-align: center">No.</th>
                                <th style="text-align: center">Start</th>
                                <th style="text-align: center">Finish</th>
                                <th style="text-align: center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bodyRepairManagement->runningDetail->registrationBodyRepairDetailTimesheets as $i => $registrationBodyRepairDetailTimesheet): ?>
                                <tr>
                                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetailTimesheet, 'start_date_time')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetailTimesheet, 'finish_date_time')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetailTimesheet, 'totalTimeFormatted')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($bodyRepairManagement->runningDetail !== null): ?>
        <?php $mechanicId = $bodyRepairManagement->runningDetail->mechanic_id; ?>
        <?php if ($mechanicId === null || $mechanicId !== null && $mechanicId === Yii::app()->user->id): ?>
            <div style="text-align: center">
                <?php if ($bodyRepairManagement->runningDetailTimesheet->start_date_time === null): ?>
                    <?php echo CHtml::submitButton('Start', array('name' => 'StartOrPauseTimesheet', 'confirm' => 'Are you sure you want to start?', 'class' => 'btn_blue')); ?>
                <?php else: ?>
                    <?php echo CHtml::submitButton('Pause', array('name' => 'StartOrPauseTimesheet', 'confirm' => 'Are you sure you want to pause?', 'class' => 'btn_blue')); ?>
                    <?php echo CHtml::submitButton('Finish', array('name' => 'FinishTimesheet', 'confirm' => 'Are you sure you want to finish?', 'class' => 'btn_blue')); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php echo CHtml::endForm(); ?>  