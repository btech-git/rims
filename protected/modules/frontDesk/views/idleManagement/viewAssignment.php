<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Idle Management' => array('indexHead'),
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
"); ?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <h1>General Repair Mechanic Assignment</h1>

        <div>
            <?php 
            $registration = $registrationService->registrationTransaction; 
            $vehicle = $registration->vehicle;
            $duration = 0;
            $damage = "";
            ?>
            <table>
                <tr>
                    <td style="width: 50%">Plate Number: <?php echo $registrationService->registrationTransaction->vehicle->plate_number; ?></td>
                    <td>Problem : <?php echo $registration->problem; ?></td>
                </tr>
                <tr>
                    <td>Car Make: <?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td>Total Duration: <?php echo $duration . ' hr'; ?></td>
                </tr>
                <tr>
                    <td>Car Model: <?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td>Last Update By: <?php echo $registration->user->username; ?></td>
                </tr>
                <tr>
                    <td>Work Order #: <?php echo $registration->work_order_number; ?></td>
                    <td>Status: <?php echo $registration->status; ?></td>
                </tr>
                </tr>
            </table>
        </div>

        <br />

        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
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
            ));
            ?>
        </div>

        <br />

        <div class="grid-view">
            <table>
                <thead>
                    <tr style="background-color: yellow">
                        <th style="text-align: center">Service</th>
                        <th style="text-align: center">Category</th>
                        <th style="text-align: center">Duration</th>
                        <th style="text-align: center">Start</th>
                        <th style="text-align: center">Finish</th>
                        <th style="text-align: center">Total Time</th>
                        <th style="text-align: center">Service Status</th>
                        <th style="text-align: center">Assign Mechanic</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'service.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'service.serviceCategory.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'hour')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'start')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'end')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'total_time')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationService, 'status')); ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownlist($registrationService, 'assign_mechanic_id', CHtml::listData(EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array(
                                "branch_id" => $registration->branch_id,
                                "division_id" => 1,
                                "position_id" => 1,
                                "level_id" => array(1, 2, 3),
                            )), "employee_id", "employee.name"), array("empty" => "--Assign Mechanic--")); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="text-align:center">
    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'button success')); ?>
</div>
<?php echo CHtml::endForm(); ?>