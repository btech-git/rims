<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Idle Management'=>array('indexHead'),
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
                            '_viewWorkOrder',
                            array(
                                'registration' => $registration,
                                'memo' => $memo,
                                'priorityLevel' => $priorityLevel,
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
                                'registrationServiceDataProvider' => $registrationServiceDataProvider,
                            ), true
                        ),
                    ),
                    'Damages' => array(
                        'content' => $this->renderPartial(
                            '_viewDamage',
                            array(
                                'registrationDamageDataProvider' => $registrationDamageDataProvider,
                            ), true
                        ),
                    ),
                    'Service History' => array(
                        'content' => $this->renderPartial(
                            '_viewServiceHistory',
                            array(
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
        
        <div>
            <table>
                <thead>
                    <tr style="background-color: yellow">
                        <th style="text-align: center">Process</th>
                        <th style="text-align: center">Start</th>
                        <th style="text-align: center">Finish</th>
                        <th style="text-align: center">Total Time</th>
                        <th style="text-align: center">Assign Mechanic</th>
                    </tr>
                </thead>
                <tbody>
                    <?php //foreach ($registration->registrationBodyRepairDetails as $i => $registrationBodyRepairDetail): ?>
                        <?php //if (substr($registration->status, 6) == $registrationBodyRepairDetail->service_name): ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::activeHiddenField($registrationBodyRepairDetail, "id"); ?>
                                    <?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'service_name')); ?>
                                </td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'start_date_time')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'finish_date_time')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'total_time')); ?></td>
                                <td>
                                    <?php //if (empty($registrationBodyRepairDetail->mechanic_assigned_id)): ?>
                                        <?php echo CHtml::activeDropDownlist($registrationBodyRepairDetail, "mechanic_assigned_id", CHtml::listData(EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array(
    //                                        "branch_id" => $registration->branch_id,
                                            "level_id" => $registrationBodyRepairDetail->getLevelIdByProcessName($registrationBodyRepairDetail->service_name),
                                        )), "employee_id", "employee.name"), array("empty" => "-- Assign Mechanic --")); ?>
                                    <?php /*else: ?>
                                        <?php echo CHtml::activeHiddenField($registrationBodyRepairDetail, "[$i]mechanic_assigned_id"); ?>
                                        <?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'mechanicAssigned.name')); ?>
                                    <?php endif;*/ ?>
                                </td>
                            </tr>
                        <?php //endif; ?>
                    <?php //endforeach; ?>                        
                </tbody>
            </table>
        </div>
	</div>
</div>

<br />

<?php if ($registration->service_status !== 'Finish'): ?>
    <div style="text-align:center">
        <?php echo CHtml::submitButton('Assign', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
<?php endif; ?>
<?php echo CHtml::endForm(); ?>  